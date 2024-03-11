<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostPlanRequest;
use App\Http\Requests\UpdatePostPlantRequest;
use App\Repositories\Image\ImageInterface;
use App\Repositories\PostPlan\PostPlanInterface;
use Illuminate\Http\Request;

class PostPlanController extends Controller
{
    private $postPlantRepo;
    private $imgRepo;
    private $upload_dir;
    private $public_dir;

    public function __construct(PostPlanInterface $postPlan, ImageInterface $image)
    {
        $this->postPlantRepo = $postPlan;
        $this->imgRepo = $image;
        $this->upload_dir = config('constants.PLAN_UPLOAD_DIR');
        $this->public_dir = config('constants.PLAN_PUBLIC_DIR');
    }

    public function index()
    {
        $post_plans = $this->postPlantRepo->get();
        return view('admin.post_plans.index', compact('post_plans'));
    }

    public function showCreateForm()
    {
        $is_add = true;
        return view('admin.post_plans.edit-add', compact('is_add'));
    }

    public function create(CreatePostPlanRequest $request)
    {
        try {
            $file = $request->file('image');
            $image_path = $this->imgRepo->getById($this->uploadImage($file, $request->title, $this->upload_dir, $this->public_dir, $this->imgRepo, 'plan-image'))->path;
            $plan = $this->postPlantRepo->store($request);
            $plan->image = $image_path;
            $plan->save();
            return redirect()->route('admin.post-plans')->with('message', ['type' => 'success', 'content' => __('message.create_success', ['name' => $request->title])]);
        } catch (\Exception $e) {
            return redirect()->route('admin.post-plans')->with('message', ['type' => 'success', 'content' => __('message.server_error')]);
        }
    }

    public function showEditForm($id)
    {
        $is_add = false;
        $post_plan = $this->postPlantRepo->getById($id);
        return view('admin.post_plans.edit-add', compact('is_add', 'post_plan'));
    }

    public function edit(UpdatePostPlantRequest $request)
    {
        try {
            $plan_updated = $this->postPlantRepo->update($request);
            if ($request->hasFile('image')) {
                $old_image = $this->imgRepo->getByPath($plan_updated->image);
                $image_path = $this->imgRepo->
                getById($this->uploadImage($request->file('image'), $request->title, $this->upload_dir, $this->public_dir, $this->imgRepo, 'plan-image', $old_image->id ?? null))->path;
                $plan_updated->image = $image_path;
                $plan_updated->save();
            }
            return redirect()->route('admin.post-plans')->with('message', ['type' => 'success', 'content' => __('message.update_success', ['name' => $request->title])]);
        } catch (\Exception $exception) {
            abort(404);
        }
    }

    public function delete($id)
    {
        return $this->postPlantRepo->destroy($id);
    }

    public function deleteAll(Request $request)
    {
        return $this->postPlantRepo->destroyAll($request->json()->all());
    }

    public function detail($id)
    {
        $post_plan = $this->postPlantRepo->getById($id);
        return view('admin.post_plans.browser', compact('post_plan'));
    }

    public function search(Request $request)
    {
        $query = $request->search_query;
        $post_plans = $this->postPlantRepo->search($request->search_query);
        return view('admin.post_plans.index', compact('post_plans', 'query'));
    }
}
