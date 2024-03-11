<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Post\PostInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryRepo;
    private $postRepo;

    public function __construct(CategoryInterface $categoryRepo, PostInterface $postRepo)
    {
        $this->categoryRepo = $categoryRepo;
        $this->postRepo = $postRepo;
    }

    public function index(Request $request)
    {
        $special_categories = config('constants.SPECIAL_CATEGORIES');
        $postByCategory = null;
        $category = null;
        $name = null;
        $slug = $request->slug;
        $is_official = $request->is_official == 1;
        if (in_array($request->slug, $special_categories)) {
            if ($request->slug === $special_categories[0]) {
                $name = __('home.recent');
                $postByCategory = $this->postRepo->getRecentPost(true, $is_official);
            } else if ($request->slug === $special_categories[1]) {
                $name = __('home.supported');
                $postByCategory = $this->postRepo->getSupportedPost(true, $is_official);
            }
        } else {
            $category = $this->categoryRepo->getBySlug($request->slug);
            if (!$category) {
                abort(404);
            }
            $name = $category->name;
            $postByCategory = $this->postRepo->getSupportPostByCategoryId($category->id, $is_official);
        }

        return view('site.category.index', compact('category', 'slug', 'name', 'postByCategory'));
    }
}
