<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Page\PageInterface;
use App\Repositories\Post\PostInterface;

class PageController extends Controller
{
    private $pageRepo;
    private $postRepo;

    private $categoryRepo;

    public function __construct(PageInterface $pageRepo, PostInterface $postRepo, CategoryInterface $categoryRepo)
    {
        $this->pageRepo = $pageRepo;
        $this->postRepo = $postRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function index($slug)
    {
        $page = $this->pageRepo->getBySlug($slug);
        if ($page) {
            return view('site.pages.index', compact('page'));
        } else {
            abort(404);
        }
    }

    public function official()
    {
        $is_official = true;
        $slides = $this->pageRepo->getHomeSlide(config('constants.LIMIT_SLIDE'));
        $categories = $this->categoryRepo->get();
        $sub_categories = $this->pageRepo->getServicePage();
        $supported_posts = $this->postRepo->getSupportedPost(false, $is_official);
        $recent_posts = $this->postRepo->getRecentPost(false, $is_official);
        $posts_by_categories = $this->postRepo->getPostByCategories(config('constants.POST_PER_CATEGORY'), $is_official);
        return view('site.home', compact('slides', 'supported_posts', 'categories', 'posts_by_categories', 'recent_posts', 'sub_categories', 'is_official'));
    }
}
