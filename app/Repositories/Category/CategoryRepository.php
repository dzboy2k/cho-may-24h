<?php

namespace App\Repositories\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;

class CategoryRepository extends Controller implements CategoryInterface
{
    private Category $category;


    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function get()
    {
        return $this->category::paginate(setting('site.category_per_page'));
    }

    public function getById($id)
    {
        return $this->category::find($id);
    }

    public function store($request)
    {
        try {
            $this->category::create($request);
            return redirect()->route('admin.categories')->with('message', ['content' => __('message.create_success', ['name' => __('categories.category_low') . ' ' . $request['name']]), 'type' => 'success']);
        } catch (\Exception $e) {
            return back()->withErrors(['create_failed' => __('message.create_failed', ['name' => __('categories.category_low')])])->withInput();
        }
    }

    public function update($request)
    {
        $category = $this->category::find($request->id);
        $category->fill($request->all())->save();
        return $category;
    }

    protected function hasChildren($id)
    {
        return $this->category::where('parent_id', $id)->exists();
    }

    public function checkIsDescendant($target_category_id, $check_id)
    {

        if ($target_category_id == $check_id) return true;
        $cat_check = $this->category::select('parent_id')->where('id', $check_id)->first();
        if (@$cat_check->parent_id) {
            if ($target_category_id == $cat_check->parent_id) return true;
            return $this->checkIsDescendant($target_category_id, $cat_check->parent_id);
        }
        return false;
    }

    public function destroy($id)
    {
        try {
            $category = $this->category::find($id);
            if ($this->hasPost($id)) {
                return response()->json(['message' => __('categories.has_post')], 400);
            }
            if ($this->hasChildren($id)) {
                return response()->json(['message' => __('categories.has_children')], 400);
            }
            $this->deleteStorageFile($category->image->path);
            $image = $category->image;
            $category->delete();
            $image->delete();
            return response()->json(['message' => __('categories.delete_success')]);
        } catch (\Exception $e) {
            return response()->json(['message' => __('categories.delete_failed')], 500);
        }
    }

    public
    function getBySlug($slug)
    {
        return $this->category::where('slug', $slug)->first();
    }

    public
    function deleteAll($ids)
    {
        try {
            $categories = $this->category::whereIn('id', $ids)->get();

            if (Post::whereIn('category_id', $ids)->exists()) {
                return response()->json(['message' => __('categories.has_post')], 400);
            }
            foreach ($ids as $id) {
                if ($this->hasChildren($id)) {
                    return response()->json(['message' => __('categories.has_children')], 400);
                }
            }
            foreach ($categories as $category) {
                $this->deleteStorageFile($category->image->path);
                $image = $category->image;
                $category->delete();
                $image->delete();
            }
            return response()->json(['message' => __('categories.delete_success')]);
        } catch (\Exception $e) {
            return response()->json(['message' => __('categories.delete_failed')], 500);
        }
    }

    protected function hasPost($id)
    {
        return Post::where('category_id', $id)->exists();
    }

    public
    function getCategoriesWithoutSelf($id)
    {
        return $this->category::where('id', '!=', $id)->get();
    }

    public
    function getIdBySlug($slug)
    {
        return $this->category::where('slug', $slug)->first()?->id;
    }

    public function search($query)
    {
        return $this->category::where('name', 'LIKE', '%' . $query . '%')->paginate(config('constants.DATA_PER_PAGE'));
    }
}
