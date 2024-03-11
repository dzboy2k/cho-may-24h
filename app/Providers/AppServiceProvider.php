<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Page;
use App\Repositories\Authentication\AuthenticationInterface;
use App\Repositories\Authentication\AuthenticationRepository;
use App\Repositories\Brand\BrandInterface;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Chat\ChatInterface;
use App\Repositories\Chat\ChatRepository;
use App\Repositories\Image\ImageInterface;
use App\Repositories\Image\ImageRepository;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Page\PageInterface;
use App\Repositories\Page\PageRepository;
use App\Repositories\Post\PostInterface;
use App\Repositories\Post\PostRepository;
use App\Repositories\PostPlan\PostPlanInterface;
use App\Repositories\PostPlan\PostPlanRepository;
use App\Repositories\Status\StatusInterface;
use App\Repositories\Status\StatusRepository;
use App\Repositories\Tag\TagInterface;
use App\Repositories\Tag\TagRepository;
use App\Repositories\SupportTransaction\SupportTransactionInterface;
use App\Repositories\SupportTransaction\SupportTransactionRepository;
use App\Repositories\Transaction\TransactionInterface;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\User\UserInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\UserPostingPlan\UserPostingPlanInterface;
use App\Repositories\UserPostingPlan\UserPostingPlanRepository;
use App\Repositories\Order\OrderInterface;
use App\Repositories\Order\OrderRepository;
use App\Repositories\SavedPost\SavedPostInterface;
use App\Repositories\SavedPost\SavedPostRepository;
use App\Repositories\RequestWithdrawTransaction\RequestWithdrawTransactionInterface;
use App\Repositories\RequestWithdrawTransaction\RequestWithdrawTransactionRepository;
use App\Repositories\SearchRepository\SearchRepositoryInterface;
use App\Repositories\SearchRepository\SearchRepositoryRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AuthenticationInterface::class, AuthenticationRepository::class);
        $this->app->bind(ImageInterface::class, ImageRepository::class);
        $this->app->bind(PostInterface::class, PostRepository::class);
        $this->app->bind(TagInterface::class, TagRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(PageInterface::class, PageRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(BrandInterface::class, BrandRepository::class);
        $this->app->bind(StatusInterface::class, StatusRepository::class);
        $this->app->bind(ChatInterface::class, ChatRepository::class);
        $this->app->bind(PostPlanInterface::class, PostPlanRepository::class);
        $this->app->bind(UserPostingPlanInterface::class, UserPostingPlanRepository::class);
        $this->app->bind(OrderInterface::class, OrderRepository::class);
        $this->app->bind(RequestWithdrawTransactionInterface::class,RequestWithdrawTransactionRepository::class);
        $this->app->bind(TransactionInterface::class,TransactionRepository::class);
        $this->app->bind(SavedPostInterface::class,SavedPostRepository::class);
        $this->app->bind(SupportTransactionInterface::class,SupportTransactionRepository::class);
        $this->app->bind(SearchRepositoryInterface::class,SearchRepositoryRepository::class);
        $this->app->singleton('categories', function () {
            return Category::all();
        });
        $this->app->singleton('menu_header', function () {
            return Page::where([['show_in_header', '=', 1], ['status', '=', 'ACTIVE']])->get();
        });
    }

    public function boot()
    {
        Paginator::useBootstrap();
    }
}
