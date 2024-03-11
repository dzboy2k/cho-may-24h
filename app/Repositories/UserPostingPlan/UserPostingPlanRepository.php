<?php

namespace App\Repositories\UserPostingPlan;

use App\Http\Controllers\Controller;
use App\Models\UserPlanPayment;

class UserPostingPlanRepository extends Controller implements UserPostingPlanInterface
{
    private UserPlanPayment $userPostingPlan;

    public function __construct(UserPlanPayment $userPostingPlan)
    {
        $this->userPostingPlan = $userPostingPlan;
    }

    public function get()
    {
        return $this->userPostingPlan::paginate(config('constants.DATA_PER_PAGE'));
    }

    public function getById($id)
    {
        return $this->userPostingPlan::find($id);
    }

    public function store($request)
    {
        $this->userPostingPlan->create($request);
    }

    public function update($request)
    {
        $user_posting_plant = $this->getById($request['id']);
        $user_posting_plant->fill($request);
        $user_posting_plant->save();
        return $user_posting_plant;
    }

    public function destroy($id)
    {
        return $this->getById($id)->delete();
    }

    public function destroyAll($ids)
    {
        try {
            $this->userPostingPlan::whereIn('id', $ids)->delete();
            return response()->json(['message' => __('message.delete_success', ['name' => 'danh sách người dùng đăng kí gói'])]);
        } catch (\Exception $exception) {
            return response()->json(['message' => __('message.delete_failed')], 500);
        }
    }

    function search($query)
    {
        return $this->userPostingPlan::whereHas('user', function ($innerQuery) use ($query) {
            $innerQuery->where('name', 'like', '%' . $query . '%');
        })->orderBy('created_at', 'desc')->paginate(config('constants.DATA_PER_PAGE'));
    }

    public function getByUser($id)
    {
        return $this->userPostingPlan::where('user_id', $id)->first();
    }

    public function cancelPlan($user_id, $id)
    {
        $plan = $this->userPostingPlan::where([['user_id', '=', $user_id], ['package_id', '=', $id]])->first();
        if ($plan) {
            $plan->delete();
            return redirect()->route('site.post-plans')->with('message', ['type' => 'success', 'content' => __('wallet.cancel_plan_success')]);
        }
        return redirect()->route('site.post-plans')->with('message', ['type' => 'error', 'content' => __('wallet.no_plan')]);
    }
}
