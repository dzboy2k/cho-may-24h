<?php

namespace App\Repositories\PostPlan;

use App\Models\PostPlan;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Models\UserPlanPayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PostPlanRepository extends Controller implements PostPlanInterface
{
    private $postPlantModel;
    private $userPlanPaymentModel;

    public function __construct(PostPlan $postPlantModel,UserPlanPayment $userPlanPaymentModel)
    {
        $this->postPlantModel = $postPlantModel;
        $this->userPlanPaymentModel = $userPlanPaymentModel;
    }

    public function get()
    {
        return $this->postPlantModel::paginate(config('constants.DATA_PER_PAGE'));
    }

    public function getById($id)
    {
        return $this->postPlantModel::find($id);
    }

    public function store($request)
    {
        return $this->postPlantModel::create($request->all());
    }

    public function update($request)
    {
        $post_update = $this->postPlantModel::find($request->id);
        $post_update->fill($request->all());
        $post_update->save();
        return $post_update;
    }

    public function checkHasUserPlant($id)
    {
        return $this->userPlanPaymentModel::where('package_id', $id)->exists();
    }

    public function destroy($id)
    {
        try {
            $plant = $this->postPlantModel::find($id);
            if ($this->checkHasUserPlant($id)) {
                return response()->json(['message' => __('post_plan.has_user')], 400);
            }
            $this->deleteStorageFile($plant->image);
            $plant->delete();
            return response()->json(['message' => __('message.delete_success', ['name' => $plant->title])]);
        } catch (\Exception $exception) {
            return response()->json(['message' => __('message.delete_failed')], 500);
        }
    }

    public function destroyAll($ids)
    {
        try {
            foreach ($ids as $id) {
                $plant = $this->postPlantModel::find($id);
                if ($this->checkHasUserPlant($id)) {
                    return response()->json(['message' => __('post_plan.has_user')], 400);
                }
                $this->deleteStorageFile($plant->image);
                $plant->delete();
            }
            return response()->json(['message' => __('message.delete_success', ['name' => 'plans'])]);
        } catch (\Exception $exception) {
            return response()->json(['message' => __('message.delete_failed')], 500);
        }
    }

    public function search($search_query)
    {
        return $this->postPlantModel::where('title', 'LIKE', '%' . $search_query . '%')->paginate(config('constants.DATA_PER_PAGE'));
    }

    public function canPaid($need_coin, $have_coin)
    {
        if ($need_coin <= 0) {
            return false;
        }
        return $have_coin - $need_coin >= 0;
    }

    public function registerPlan($id)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('auth.login.form');
            }
            $plan = $this->getById($id);
            $user_wallet = Auth::user()->wallet;
            $user_id = Auth::id();

            if (!$user_wallet) {
                return redirect()
                    ->route('site.post-plans')
                    ->with('message', ['type' => 'error', 'content' => __('wallet.no_wallet')]);
            }

            if (!$plan) {
                return redirect()
                    ->route('site.post-plans')
                    ->with('message', ['type' => 'error', 'content' => __('wallet.no_plan')]);
            }

            if (!$this->canPaid($plan->price_per_month, $user_wallet->payment_coin)) {
                return redirect()
                    ->route('site.post-plans')
                    ->with('message', ['type' => 'error', 'content' => __('wallet.no_en_money')]);
            }
            DB::beginTransaction();
            $user_plan = $this->userPlanPaymentModel::where('user_id', $user_id)->first();
            $user_wallet->payment_coin -= $plan->price_per_month;
            $user_wallet->save();

            if (!$user_plan) {
                $user_plan = $this->userPlanPaymentModel::create([
                    'user_id' => $user_id,
                    'package_id' => $id,
                    'expire_date' => Carbon::now()->addMonth(),
                ]);
            } else {
                $user_plan = new $this->userPlanPaymentModel();
                $user_plan->package_id = $id;
                $user_plan->expire_date = Carbon::now()->addMonth();
                $user_plan->save();
            }
            Transaction::create([
                'type' => config('constants.TRANSACTION_TYPE')['PAYMENT_WALLET'],
                'fluctuation' => -$plan->price_per_month,
                'wallet_id' => $user_wallet->id,
                'status' => config('constants.TRANSACTION_STATUS')['SUCCESS'],
                'description' => __('plan_payment'),
            ]);
            DB::commit();
            return redirect()
                ->route('site.post-plans')
                ->with('message', ['type' => 'success', 'content' => __('wallet.register_plan_success')]);
        } catch (\Exception $exception) {
            DB::rollback();
            return redirect()
                ->route('site.post-plans')
                ->with('message', ['type' => 'error', 'content' => __('wallet.reg_failed')]);
        }
    }
}
