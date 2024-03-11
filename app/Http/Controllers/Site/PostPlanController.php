<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Repositories\PostPlan\PostPlanInterface;
use App\Repositories\User\UserInterface;
use App\Repositories\UserPostingPlan\UserPostingPlanInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PostPlanController extends Controller
{
    private $postPlantRepo;
    private $userPostingPlanRepo;

    public function __construct(PostPlanInterface $postPlant, UserPostingPlanInterface $userPostingPlan)
    {
        $this->postPlantRepo = $postPlant;
        $this->userPostingPlanRepo = $userPostingPlan;
    }

    public function index()
    {
        $post_plans = $this->postPlantRepo->get();
        $user_plan = $this->userPostingPlanRepo->getByUser(Auth::id());
        return view('site.post_plans.index', compact('post_plans', 'user_plan'));
    }

    function registerPlan($id)
    {
        return $this->postPlantRepo->registerPlan($id);
    }

    function cancelPlan($id)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('auth.login.form');
            }
            return $this->userPostingPlanRepo->cancelPlan(Auth::id(), $id);
        } catch (\Exception $exception) {
            abort(404);
        }
    }
}
