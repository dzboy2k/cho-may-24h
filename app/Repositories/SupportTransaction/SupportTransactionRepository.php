<?php

namespace App\Repositories\SupportTransaction;

use App\Exceptions\PostNotFound;
use App\Exceptions\ReferralNotFound;
use App\Exceptions\UserNotFound;
use App\Models\Post;
use App\Models\SupportTransaction;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupportTransactionRepository extends Controller implements SupportTransactionInterface
{
    private SupportTransaction $supportTransactionModel;

    public function __construct(SupportTransaction $supportTransactionModel)
    {
        $this->supportTransactionModel = $supportTransactionModel;
    }

    public function getSupportTransactionWithPaginate($request)
    {
        return $this->supportTransactionModel
            ::where('wallet_id', Auth::user()->wallet->id)
            ->orderBy('created_at', 'desc')
            ->paginate(config('constants.DATA_PER_PAGE'));
    }

    public function getSupportTransactionCanTransfer($request)
    {
        return $this->supportTransactionModel
            ::where([['wallet_id', '=', Auth::user()->wallet->id], ['expiration_date', '>', Carbon::now()], ['receive_type', '=', config('constants.RECEIVE_SUPPORT_TYPE')['FROM_POST']]])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getById($id)
    {
        return $this->supportTransactionModel::find($id);
    }

    public function getUserByReferralCode($referral_code)
    {
        return User::where('referral_code', $referral_code)->first();
    }

    public function createSupportTransactionForUserIdFromReferralCode($data)
    {
        $userReferral = $this->getUserByReferralCode($data['referral_code']);
        if (!$userReferral) {
            throw new ReferralNotFound('Referral code not found', 1);
        }
        $expired = Carbon::now()->addMonth(setting('site.amount_month_support_for_referral_code'));
        $dataSupport = [
            'user_id' => $userReferral->id,
            'fluctuation' => setting('site.received_support_for_referral_code'),
            'receive_type' => config('constants.RECEIVE_SUPPORT_TYPE')['FROM_REFERRAL_CODE'],
            'expiration_date' => $expired,
            'description' => __('transaction.receive_by_target_referral_code', ['referral_code' => $data['referral_code']]),
            'is_need_for_calc_each_day' => true,
        ];
        $this->createSupportTransactionForUserId($dataSupport);
    }

    public function handleTransferSupport($request)
    {
        try {
            DB::beginTransaction();
            $sender = Auth::user();
            $receivedTypes = config('constants.RECEIVE_SUPPORT_TYPE');
            $original_transaction = $this->supportTransactionModel->where([['id', $request->suport_transaction_id], ['is_need_for_calc_each_day', true]])->first();

            if (!$original_transaction) {
                return back()->with('message', ['content' => __('transaction.suport_transaction_not_found'), 'type' => 'error']);
            }
            if ($original_transaction->recieve_type != $receivedTypes['FROM_POST']) {
                return back()->with('message', ['content' => __('transaction.just_suport_transaction_from_post_can_transfer'), 'type' => 'error']);
            }
            if ($original_transaction->wallet_id != $sender->wallet->id) {
                return back()->with('message', ['content' => __('transaction.just_can_transfer_from_your_own_support'), 'type' => 'error']);
            }
            $receiver = User::find($request->receiver_id);
            if (!$receiver) {
                return back()->with('message', ['content' => __('wallet.wallet_receive_not_found'), 'type' => 'error']);
            }
            $new_transaction_for_the_receiver_data = [
                'user_id' => $receiver->id,
                'fluctuation' => $original_transaction->fluctuation,
                'receive_type' => config('constants.RECEIVE_SUPPORT_TYPE')['FROM_REFERRAL_CODE'],
                'expiration_date' => $original_transaction->expiration_date,
                'description' => __('transaction.receive_by_target_target_transfer', ['target_transfer' => $sender->referral_code]),
                'is_need_for_calc_each_day' => true,
            ];
            $new_transaction_for_the_sender_data = [
                'user_id' => $sender->id,
                'fluctuation' => -$original_transaction->fluctuation,
                'receive_type' => config('constants.RECEIVE_SUPPORT_TYPE')['FROM_REFERRAL_CODE'],
                'expiration_date' => $original_transaction->expiration_date,
                'description' => __('transaction.transfer_support_limit_to_target', ['target_transfer' => $receiver->referral_code]),
                'is_need_for_calc_each_day' => false,
            ];
            $this->createSupportTransactionForUserId($new_transaction_for_the_receiver_data);
            $this->createSupportTransactionForUserId($new_transaction_for_the_sender_data);
            DB::commit();
            return back()->with('message', ['content' => __(''), 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            if ($e instanceof UserNotFound) {
                return back()->with('message', ['content' => __('transaction.can_not_find_receiver_or_sender'), 'type' => 'error']);
            }
            return back()->with('message', ['content' => __('wallet.wallet_receive_not_found'), 'type' => 'error']);
        }
    }

    public function createSupportTransactionForUserIdFromPost($data)
    {
        $post = Post::find($data['post_id']);
        if (!$post) {
            throw new PostNotFound('Post not found', 1);
        }
        $expired = Carbon::now()->addMonth($post->expire_limit_month);
        $data = [
            'fluctuation' => $post->receive_support,
            'receive_type' => config('constants.RECEIVE_SUPPORT_TYPE')['FROM_POST'],
            'expiration_date' => $expired,
            'description' => __('transaction.receive_limit_from_post'),
            'is_need_for_calc_each_day' => true,
            'user_id' => $data['user_id'],
        ];
        $this->createSupportTransactionForUserId($data);
    }

    public function createSupportTransactionForUserId($data)
    {
        $userReceivedSupport = User::find($data['user_id']);
        if (!$userReceivedSupport) {
            throw new UserNotFound('User not found', 1);
        }
        $data['wallet_id'] = $userReceivedSupport->wallet->id;
        $supportInstance = new $this->supportTransactionModel();
        $supportInstance->fill($data);
        $supportInstance->save();
    }

    public function createSupportTransaction($data)
    {
        $supportInstance = new $this->supportTransactionModel();
        $supportInstance->fill($data);
        $supportInstance->save();
    }

    public function getSupportTransaction()
    {
        return $this->supportTransactionModel::orderBy('created_at','desc')->get();
    }
}
