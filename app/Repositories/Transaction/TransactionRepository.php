<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionRepository extends Controller implements TransactionInterface
{
    private $transactionModel;

    public function __construct(Transaction $transactionModel)
    {
        $this->transactionModel = $transactionModel;
    }

    public function get()
    {
        return $this->transactionModel::orderBy('updated_at', 'desc')->paginate(config('constants.DATA_PER_PAGE'));
    }

    public function getWithoutPaginate()
    {
        return $this->transactionModel::orderBy('updated_at', 'desc')->get();
    }

    public function getByTransactionTypeWithPaginate($type)
    {
        return $this->transactionModel
            ::where([['type', $type], ['wallet_id', Auth::user()->wallet->id]])
            ->orderBy('created_at', 'desc')
            ->paginate(config('constants.TRANSACTION_PER_PAGE'));
    }

    public function getById($id)
    {
        return $this->transactionModel::find($id);
    }

    public function searchById($id)
    {
        if ($id == '') {
            return $this->transactionModel::orderBy('updated_at', 'desc')->paginate(config('constants.DATA_PER_PAGE'));
        }
        return $this->transactionModel::where('id', $id)->orderBy('updated_at', 'desc')->paginate(config('constants.DATA_PER_PAGE'));
    }

    public function getByIdAndType($id, $type)
    {
        return $this->transactionModel::where([['id', $id], ['type', $type]])->first();
    }

    public function getPendingDepositInfoById($id)
    {
        return $this->transactionModel::where([['id', $id], ['type', config('constants.TRANSACTION_TYPE')['PAYMENT_WALLET']], ['status', config('constants.TRANSACTION_STATUS')['PENDING']]])->first();
    }

    protected function getTransactionDataWithDefaultValue($request)
    {
        return [
            'type' => $request->type,
            'fluctuation' => $request->fluctuation,
            'wallet_id' => $request->wallet_id,
            'status' => config('constants.TRANSACTION_STATUS')['PENDING'],
            'description' => $request->description,
        ];
    }

    public function storeDeposit($request)
    {
        try {
            $request->description = __('transaction.deposit_with_id');
            $request->type = config('constants.TRANSACTION_TYPE')['PAYMENT_WALLET'];
            $transaction = $this->store($request);
            return redirect()
                ->route('deposit.transfer', ['id' => $transaction->id])
                ->with('message', ['type' => 'success', 'content' => __('transaction.create_success')]);
        } catch (\Exception $exception) {
            return back()->with('message', ['type' => 'error', 'content' => __('message.server_error')]);
        }
    }

    public function store($request)
    {
        $transaction = new Transaction();
        $transaction->fill($this->getTransactionDataWithDefaultValue($request))->save();
        return $transaction;
    }

    public function update($request)
    {
    }

    public function destroy($id)
    {
    }

    protected function sendNotificationForUserAboutTransaction($user_id, $msg, $notifi_repo)
    {
        $notifi_data = [
            'user_id' => $user_id,
            'content' => $msg,
            'link' => route('site.history.payment_history.blade'),
            'image_path' => asset(config('constants.DEFAULT_AVT_PATH')),
            'readed' => 0,
        ];
        $notifi_repo->createAndPushNotificationForUser($notifi_data);
    }

    private function tryToSaveDataOfTransaction($transaction, $wallet)
    {
        try {
            DB::beginTransaction();

            $transaction->save();
            $wallet->save();
            DB::commit();
        } catch (\Exception $exceptione) {
            DB::rollBack();
            Log::error(Carbon::now() . ' - Error when save transaction : ' . $exceptione->getMessage());
        }
    }

    public function processTransactionFromWebhook($transaction_data, $notifiRepo)
    {
        foreach ($transaction_data as $transaction) {
            try {
                $transaction_id = $transaction['description'];
                $transaction_process = $this->getPendingDepositInfoById($transaction_id);
                if (!$transaction_process) {
                    continue;
                }
                if ($transaction['amount'] != $transaction_process->fluctuation) {
                    $this->sendNotificationForUserAboutTransaction($transaction_process->user_id, __('transaction.fluctuation_incorrect'), $notifiRepo);
                    continue;
                }
                $wallet = Wallet::where('user_id', $transaction_process->user_id)->first();
                if (!$wallet) {
                    $this->sendNotificationForUserAboutTransaction($transaction_process->user_id, __('transaction.no_wallet_found'), $notifiRepo);
                    continue;
                }
                $wallet->payment_coin += $transaction_process->fluctuation;
                $transaction_process->status = config('constants.TRANSACTION_STATUS')['SUCCESS'];

                $this->tryToSaveDataOfTransaction($transaction_process, $wallet);
                $this->sendNotificationForUserAboutTransaction($transaction_process->user_id, __('transaction.success'), $notifiRepo);
            } catch (\Exception $exception) {
                Log::error(Carbon::now() . " - Transaction - $transaction->description - failed to process  :" . $exception->getMessage());
            }
        }
    }

    public function handleUpdateSaleLimitFromUpdatePost($request, $post)
    {
        if ($request->recieve_support > 0 || $post->recieve_support > 0) {
            $user_wallet = Auth::user()->wallet;

            if ($user_wallet->sale_limit - $post->recieve_support < 0) {
                return back()
                    ->with('message', ['content' => __('wallet.not_enough_money'), 'type' => 'error'])
                    ->withInput();
            }
            $fluctuation = $post->recieve_support - $request->recieve_support;
            $user_wallet->sale_limit += $fluctuation;
            $user_wallet->save();
            $newTransactionOfSaleLimitWallet = new Transaction();

            $newTransactionOfSaleLimitWallet->fill([
                'type' => config('constants.TRANSACTION_TYPE')['SALE_LIMIT_WALLET'],
                'status' => config('constants.TRANSACTION_STATUS')['SUCCESS'],
                'fluctuation' => $fluctuation,
                'wallet_id' => $user_wallet->id,
                'description' => __('transaction.add_sale_limit_by_delete_post', ['post_title' => strip_tags(html_entity_decode($post->title))]),
            ]);
        }
    }

    public function handleAddSaleLimitFromDeletePost($post)
    {
        if ($post->recieve_support > 0 && $post->post_state != config('constants.POST_STATUS')['SOLD']) {
            $user_wallet = Auth::user()->wallet;

            $user_wallet->sale_limit += $post->recieve_support;
            $user_wallet->save();
            $newTransactionOfSaleLimitWallet = new Transaction();

            $newTransactionOfSaleLimitWallet->fill([
                'type' => config('constants.TRANSACTION_TYPE')['SALE_LIMIT_WALLET'],
                'status' => config('constants.TRANSACTION_STATUS')['SUCCESS'],
                'fluctuation' => $post->recieve_support,
                'wallet_id' => $user_wallet->id,
                'description' => __('transaction.add_sale_limit_by_delete_post', ['post_title' => strip_tags(html_entity_decode($post->title))]),
            ]);
        }
    }

    public function handleMinusSaleLimitFromCreatePost($request)
    {
        if ($request->recieve_support > 0) {
            $user_wallet = Auth::user()->wallet;

            if ($user_wallet->sale_limit - $request->recieve_support < 0) {
                return back()
                    ->with('message', ['content' => __('wallet.not_enough_money'), 'type' => 'error'])
                    ->withInput();
            }
            $user_wallet->sale_limit -= $request->recieve_support;
            $user_wallet->save();
            $newTransactionOfSaleLimitWallet = new Transaction();
            $newTransactionOfSaleLimitWallet->fill([
                'type' => config('constants.TRANSACTION_TYPE')['SALE_LIMIT_WALLET'],
                'status' => config('constants.TRANSACTION_STATUS')['SUCCESS'],
                'fluctuation' => -$request->recieve_support,
                'wallet_id' => $user_wallet->id,
                'description' => __('transaction.minus_sale_limit_by_create_post', ['post_title' => strip_tags(html_entity_decode($request->title))]),
            ]);
        }
    }

    public function transferSaleLimit($request)
    {
        try {
            DB::beginTransaction();
            $fluctuation = $request->fluctuation;
            $receiver = User::where('referral_code', $request->referral_code)->first();
            if (!$receiver) {
                return back()->with('message', ['content' => __('wallet.receiver_wallet_not_found'), 'type' => 'error']);
            }
            $receiver_wallet = $receiver->wallet;
            $current_user_wallet = Auth::user()->wallet;

            if ($current_user_wallet->sale_limit - $fluctuation < 0) {
                return back()->with('message', ['content' => __('wallet.not_enough_money'), 'type' => 'error']);
            }
            $receive_coin = $fluctuation - ($fluctuation * setting('site.percent_transfer')) / 100;
            $current_user_wallet->sale_limit -= $fluctuation;
            $receiver_wallet->sale_limit += $receive_coin;
            $current_user_wallet->save();
            $receiver_wallet->save();

            $newTransactionOfPaymentWalletOfCurrentUser = new Transaction();
            $newTransactionOfPaymentWalletOfReceiver = new Transaction();

            $newTransactionOfPaymentWalletOfCurrentUser->fill([
                'type' => config('constants.TRANSACTION_TYPE')['SALE_LIMIT_WALLET'],
                'status' => config('constants.TRANSACTION_STATUS')['SUCCESS'],
                'fluctuation' => -$fluctuation,
                'wallet_id' => $current_user_wallet->id,
                'description' => __('transaction.transfer_sale_limit_to_id', ['id' => $receiver->referral_code]),
            ]);
            $newTransactionOfPaymentWalletOfReceiver->fill([
                'type' => config('constants.TRANSACTION_TYPE')['SALE_LIMIT_WALLET'],
                'status' => config('constants.TRANSACTION_STATUS')['SUCCESS'],
                'fluctuation' => $receive_coin,
                'wallet_id' => $receiver_wallet->id,
                'description' => __('transaction.receive_sale_limit_from_id', ['id' => Auth::user()->referral_code]),
            ]);

            $newTransactionOfPaymentWalletOfCurrentUser->save();
            $newTransactionOfPaymentWalletOfReceiver->save();
            DB::commit();
            return redirect()
                ->route('site.history.transaction', ['history_type' => config('constants.TRANSACTION_TYPE')['SALE_LIMIT_WALLET']])
                ->with('message', ['type' => 'success', 'content' => __('transaction.transfer_success')]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('message', ['content' => __('message.server_error'), 'type' => 'error']);
        }
    }

    public function createTransferFromGetDepreciationWalletToPaymentWallet($request)
    {
        try {
            DB::beginTransaction();
            $fluctuation = $request->fluctuation;
            $wallet = Auth::user()->wallet;
            if (!$wallet) {
                return back()->with('message', ['content' => __('wallet.create_error'), 'type' => 'error']);
            }
            if ($wallet->get_depreciation_support - $fluctuation < 0) {
                return back()->with('message', ['content' => __('wallet.not_enough_money'), 'type' => 'error']);
            }
            $receive_coin = $fluctuation - ($fluctuation * setting('site.percent_transfer')) / 100;
            $wallet->get_depreciation_support -= $fluctuation;
            $wallet->payment_coin += $receive_coin;
            $wallet->save();

            $newTransactionOfPaymentWallet = new Transaction();
            $newTransactionOfGetDepreciationWallet = new Transaction();

            $newTransactionOfPaymentWallet->fill([
                'type' => config('constants.TRANSACTION_TYPE')['PAYMENT_WALLET'],
                'status' => config('constants.TRANSACTION_STATUS')['SUCCESS'],
                'fluctuation' => $receive_coin,
                'wallet_id' => $wallet->id,
                'description' => __('transaction.transfer_from_get_deprecation_wallet_to_payment_wallet'),
            ]);
            $newTransactionOfGetDepreciationWallet->fill([
                'type' => config('constants.TRANSACTION_TYPE')['GET_DEPRECIATION_SUPPORT_WALLET'],
                'status' => config('constants.TRANSACTION_STATUS')['SUCCESS'],
                'fluctuation' => -$fluctuation,
                'wallet_id' => $wallet->id,
                'description' => __('transaction.minus_by_deposit'),
            ]);

            $newTransactionOfPaymentWallet->save();
            $newTransactionOfGetDepreciationWallet->save();
            DB::commit();
            return redirect()
                ->route('site.history.payment_history.blade')
                ->with('message', ['content' => __('transaction.transfer_success'), 'type' => 'success']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('message', ['content' => __('message.server_error'), 'type' => 'error']);
        }
    }

    public function transferFromPaymentWalletToSaleLimitWallet($request)
    {
        try {
            DB::beginTransaction();
            $wallet = Auth::user()->wallet;

            if ($wallet->payment_coin - $request->amount < 0) {
                return back()->with('message', ['content' => __('wallet.not_enough_money'), 'type' => 'error']);
            }

            $receive_coin = $request->amount * setting('site.sale_limit_ratio');
            $wallet->sale_limit += $receive_coin;
            $wallet->payment_coin -= $request->amount;
            $wallet->save();

            $newTransactionOfPaymentWallet = new Transaction();
            $newTransactionOfSaleLimitWallet = new Transaction();

            $newTransactionOfPaymentWallet->fill([
                'type' => config('constants.TRANSACTION_TYPE')['PAYMENT_WALLET'],
                'status' => config('constants.TRANSACTION_STATUS')['SUCCESS'],
                'fluctuation' => -$request->amount,
                'wallet_id' => $wallet->id,
                'description' => __('transaction.minus_payment_by_transfer_to_sale_limit'),
            ]);
            $newTransactionOfSaleLimitWallet->fill([
                'type' => config('constants.TRANSACTION_TYPE')['SALE_LIMIT_WALLET'],
                'status' => config('constants.TRANSACTION_STATUS')['SUCCESS'],
                'fluctuation' => $receive_coin,
                'wallet_id' => $wallet->id,
                'description' => __('transaction.add_sale_limit_from_payment'),
            ]);

            $newTransactionOfPaymentWallet->save();
            $newTransactionOfSaleLimitWallet->save();
            DB::commit();
            return redirect()
                ->route('home')
                ->with('message', ['content' => __('transaction.transfer_success'), 'type' => 'success']);
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('message', ['content' => __('message.server_error'), 'type' => 'error']);
        }
    }

    public function handleAddCointToWalletByAdminWithType($request)
    {
        try {
            DB::beginTransaction();
            $wallet = User::find($request->user_id)->wallet;
            $wallet_attribute_target = config('constants.WALLET_KEY_MAPPED_WITH_TRANSACTION_TYPE')[$request->type];

            $wallet->$wallet_attribute_target += $request->amount;
            $wallet->save();

            $newTransaction = new Transaction();

            $newTransaction->fill([
                'type' => $request->type,
                'status' => config('constants.TRANSACTION_STATUS')['SUCCESS'],
                'fluctuation' => $request->amount,
                'wallet_id' => $wallet->id,
                'description' => __('transaction.admin_do_somthing', ['content' => $request->description]),
            ]);
            $newTransaction->save();
            DB::commit();
            return redirect()
                ->route('voyager.user.wallet', ['id' => $request->user_id])
                ->with('message', ['content' => __('transaction.transfer_success'), 'type' => 'success']);
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('message', ['content' => __('message.server_error'), 'type' => 'error']);
        }
    }

    public function handleMinusCointToWalletByAdminWithType($request)
    {
        try {
            DB::beginTransaction();
            $wallet = User::find($request->user_id)->wallet;

            $wallet_attribute_target = config('constants.WALLET_KEY_MAPPED_WITH_TRANSACTION_TYPE')[$request->type];

            if ($wallet->$wallet_attribute_target - $request->amount < 0) {
                return back()->with('message', ['content' => __('wallet.not_enough_money'), 'type' => 'error']);
            }

            $wallet->$wallet_attribute_target -= $request->amount;
            $wallet->save();

            $newTransaction = new Transaction();

            $newTransaction->fill([
                'type' => $request->type,
                'status' => config('constants.TRANSACTION_STATUS')['SUCCESS'],
                'fluctuation' => -$request->amount,
                'wallet_id' => $wallet->id,
                'description' => __('transaction.admin_do_somthing', ['content' => $request->description]),
            ]);
            $newTransaction->save();
            DB::commit();
            return redirect()
                ->route('voyager.user.wallet', ['id' => $request->user_id])
                ->with('message', ['content' => __('transaction.transfer_success'), 'type' => 'success']);
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('message', ['content' => __('message.server_error'), 'type' => 'error']);
        }
    }
}
