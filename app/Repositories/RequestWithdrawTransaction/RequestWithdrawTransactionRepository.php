<?php

namespace App\Repositories\RequestWithdrawTransaction;

use App\Models\RequestWithdrawTransaction;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class RequestWithdrawTransactionRepository extends Controller implements RequestWithdrawTransactionInterface
{
    private $requestWithdrawTransaction;
    private $transaction;
    public function __construct(RequestWithdrawTransaction $requestWithdrawTransaction, Transaction $transaction)
    {
        $this->requestWithdrawTransaction = $requestWithdrawTransaction;
        $this->transaction = $transaction;
    }

    public function get()
    {
        return $this->requestWithdrawTransaction::orderBy('created_at', 'desc')->paginate(config('constants.TRANSACTION_PER_PAGE'));
    }

    public function getListRequestWithdrawByUserId($request)
    {
        return $this->requestWithdrawTransaction
            ::where('user_id', $request->user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(config('constants.TRANSACTION_PER_PAGE'));
    }

    public function getById($id)
    {
        return $this->requestWithdrawTransaction::find($id);
    }

    public function store($request)
    {
        $fluctuation = $request->fluctuation;
        $new_fluctuation = $fluctuation + ($fluctuation * setting('site.percent_transfer')) / 100;
        try {
            DB::beginTransaction();
            $current_user_wallet = Auth::user()->wallet;
            if ($current_user_wallet->get_depreciation_support - $new_fluctuation < 0) {
                return back()->with('message', ['type' => 'error', 'content' => __('wallet.no_en_money')]);
            }
            $newTransaction = new $this->transaction();

            $newTransaction->fill([
                'type' => config('constants.TRANSACTION_TYPE')['GET_DEPRECIATION_SUPPORT_WALLET'],
                'status' => config('constants.TRANSACTION_STATUS')['PENDING'],
                'fluctuation' => -$new_fluctuation,
                'wallet_id' => $current_user_wallet->id,
                'description' => __('transaction.withdrawal_of_depreciation_support'),
            ]);
            $newTransaction->save();

            $request_withdraw = new $this->requestWithdrawTransaction();
            $request_withdraw_data = [
                'fluctuation' => $request->fluctuation,
                'user_id' => Auth::id(),
                'base_transaction_id' => $newTransaction->id,
                'bank_name' => $request->bank_name,
                'bank_account' => $request->bank_account,
                'bank_owner' => $request->bank_owner,
                'bank_branch' => $request->bank_branch,
                'status' => config('constants.TRANSACTION_STATUS')['PENDING'],
                'description' => __('transaction.withdrawal_of_depreciation_support'),
            ];

            $request_withdraw->fill($request_withdraw_data);
            $request_withdraw->save();
            DB::commit();
            return view('site.transaction.withdrawal.withdrawal_confirm');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();

            return back()->with('message', ['type' => 'error', 'content' => __('message.server_error')]);
        }
    }
    public function confirmRequest($id)
    {
        $requestWithdraw = $this->getById($id);
        if (!$requestWithdraw) {
            throw new \Exception(__('message.not_exists_by_id', ['target' => __('transaction.request_withdraw_transaction')]), 1);
        }

        if ($requestWithdraw->status == config('constants.TRANSACTION_STATUS')['PENDING']) {
            $baseTransaction = $this->transaction::find($requestWithdraw->base_transaction_id);
            if (!$baseTransaction) {
                throw new \Exception(__('message.not_exists_by_id', ['target' => __('transaction.transaction_in_lang')]), 1);
            } else {
                try {
                    DB::beginTransaction();
                    $userWallet = Wallet::find($baseTransaction->wallet_id);

                    $newTransaction = new $this->transaction();
                    $newTransaction->fill([
                        'type' => $baseTransaction->type,
                        'status' => config('constants.TRANSACTION_STATUS')['SUCCESS'],
                        'fluctuation' => $baseTransaction->fluctuation,
                        'wallet_id' => $baseTransaction->wallet_id,
                        'description' => $baseTransaction->description,
                    ]);
                    $newTransaction->save();
                    $userWallet->get_depreciation_support -= $baseTransaction->fluctuation;
                    $userWallet->save();
                    $requestWithdraw->status = config('constants.TRANSACTION_STATUS')['SUCCESS'];
                    $requestWithdraw->save();
                    DB::commit();
                    return redirect()->route('admin.withdraws')->with('message', ['content' => __('withdraw.verify_success'), 'type' => 'success']);
                } catch (\Exception $e) {
                    DB::rollback();
                    return redirect()->route('admin.withdraws')->with('message', ['content' => __('message.server_error'), 'type' => 'error']);
                }
            }
        } else {
            throw new \Exception('transaction_has_been_committed_before', 1);
        }
    }
    public function update($request, $id)
    {
    }

    public function destroy($id)
    {
        return $this->requestWithdrawTransaction::destroy($id);
    }

    public function searchById($id)
    {
        if ($id == '') {
            return $this->get();
        }
        return $this->requestWithdrawTransaction::where('id', $id)->paginate(config('constants.DATA_PER_PAGE'));
    }
}