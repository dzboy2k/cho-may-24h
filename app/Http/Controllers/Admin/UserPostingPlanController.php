<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\UserPostingPlan\UserPostingPlanInterface;
use Illuminate\Http\Request;

class UserPostingPlanController extends Controller
{
    private $userPostingPlanRepo;

    public function __construct(UserPostingPlanInterface $userPostingPlanRepo)
    {
        $this->userPostingPlanRepo = $userPostingPlanRepo;
    }

    public function index()
    {
        return view('admin.user-posting-plan.index', ['list_users_sub_plans' => $this->userPostingPlanRepo->get()]);
    }

    public function delete($id)
    {
        return $this->userPostingPlanRepo->destroy($id)
            ? response()->json(['message' => __('user_posting_plan.delete_success')])
            : response()->json(['message' => __('user_posting_plan.delete_failed')], 500);
    }
    public function deleteAll(Request $request)
    {
        return $this->userPostingPlanRepo->destroyAll($request->json()->all());
    }

    public function search(Request $request)
    {
        $query = $request->search_query;
        $list_users_sub_plans = $this->userPostingPlanRepo->search($query);
        return view('admin.user-posting-plan.index', compact('list_users_sub_plans', 'query'));
    }

    public function detail($id)
    {
        $user_sub_plan = $this->userPostingPlanRepo->getById($id);
        if (!$user_sub_plan){ abort(404);}
        return view('admin.user-posting-plan.browser', compact('user_sub_plan'));
    }
}
