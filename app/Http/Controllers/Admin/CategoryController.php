<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Image\ImageInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryRepo;
    private $upload_dir;
    private $public_dir;
    private $imgRepo;

    public function __construct(CategoryInterface $categoryRepo, ImageInterface $imgRepo)
    {
        $this->categoryRepo = $categoryRepo;
        $this->imgRepo = $imgRepo;
        $this->upload_dir = config('constants.CATEGORY_UPLOAD_DIR');
        $this->public_dir = config('constants.CATEGORY_ROOT_PATH');
    }

    public function index(Request $request)
    {
        $categories = $this->categoryRepo->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function showCreateForm()
    {
        $is_add = true;
        $categories = Category::all();
        return view('admin.categories.edit-add', compact('is_add', 'categories'));
    }

    public function showEditForm($id)
    {
        $is_add = false;
        $category = $this->categoryRepo->getById($id);
        $categories = $this->categoryRepo->getCategoriesWithoutSelf($id);
        return view('admin.categories.edit-add', compact('is_add', 'category', 'categories'));
    }

    public function create(CreateCategoryRequest $request)
    {
        $image_id = $this->uploadImage($request->file('image'), $request->name, $this->upload_dir, $this->public_dir, $this->imgRepo, 'Categories Image');
        return $this->categoryRepo->store(array_merge($request->all(), ['image_id' => $image_id]));
    }

    public function edit(UpdateCategoryRequest $request)
    {
        try {
            $category_image = $request->file('image') ?? null;
            if ($this->categoryRepo->checkIsDescendant($request->id, $request->parent_id)) {
                return back()->with('message', ['content' => __('categories.category_is_children'), 'type' => 'error']);
            }

            $category = $this->categoryRepo->update($request);

            if ($category_image !== null) {
                $old_image = $category->image;
                if ($old_image){
                    $this->deleteStorageFile($old_image->path);
                    $this->uploadImage($category_image, $request->name, $this->upload_dir, $this->public_dir, $this->imgRepo, 'categories image', $old_image->id);
                }
                $image_id = $this->uploadImage($category_image, $request->name, $this->upload_dir, $this->public_dir, $this->imgRepo, 'categories image');
                $category->image_id = $image_id;
                $category->save();
            }
            return redirect()->route('admin.categories')->with('message', ['content' => __('message.update_success', ['name' => __('categories.category_low')]), 'type' => 'success']);
        } catch (\Exception $e) {
            return back()->with('message', ['content' => __('message.server_error'), 'type' => 'error'])->withInput();
        }
    }

    public function delete($id)
    {
        return $this->categoryRepo->destroy($id);
    }

    public function detail($slug)
    {
        $category = $this->categoryRepo->getBySlug($slug);
        if (!$category) {
            return redirect()->route('admin.not_found');
        }
        return view('admin.categories.browser', compact('category'));
    }

    public function deleteAll(Request $request)
    {
        return $this->categoryRepo->deleteAll($request->json()->all());
    }

    public function search(Request $request)
    {
        $query = $request->search_query;
        $categories = $this->categoryRepo->search($query);
        return view('admin.categories.index', compact('categories', 'query'));
    }
}
