<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Status;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Image\ImageInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Post\PostInterface;
use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $postRepo;
    private $notificationRepo;
    private $userRepo;
    private $categoryRepo;

    public function __construct(PostInterface $postRepo, ImageInterface $imageRepo, NotificationRepositoryInterface $notificationRepo, UserInterface $userRepo, CategoryInterface $categoryRepo)
    {
        $this->postRepo = $postRepo;
        $this->notificationRepo = $notificationRepo;
        $this->userRepo = $userRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function index()
    {
        $posts = $this->postRepo->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function showCreateForm()
    {
        $statuses = Status::where('type', config('constants.STATUS_TYPES')['POST'])->get();
        $brands = Brand::all();
        $categories = $this->categoryRepo->get();
        $is_add = true;
        return view('site.posts.modify', compact('statuses', 'brands', 'categories', 'is_add'));
    }

    public function showEditForm($id)
    {
        $is_add = false;
        $post_edit = $this->postRepo->getById($id);
        return view('site.posts.modify', compact('is_add', 'post_edit'));
    }

    public function edit(Request $request)
    {
        if ($this->postRepo->update($request)) {
            return response()->json(['message' => __('post.delete_success')]);
        } else {
            return response()->json(['message' => __('post.delete_failed')], 500);
        }
    }

    public function delete($id)
    {
        return $this->postRepo->destroy($id) ? response()->json(['message' => __('post.delete_success')]) : response()->json(['message' => __('post.delete_failed')], 500);
    }

    public function showVerifyForm($id)
    {
        $is_verify = true;
        $post = $this->postRepo->getById($id);
        return view('site.posts.modify', compact('is_verify', 'post'));
    }

    public function deleteAll(Request $request)
    {
        return $this->postRepo->destroyAll($request->json()->all());
    }

    public function detail($id)
    {
        $post = $this->postRepo->getById($id);
        return view('admin.posts.browser', compact('post'));
    }

    public function verifyPost(Request $request)
    {
        try {
            $post = $this->postRepo->verifyPost($request);
            $author = $post->author;
            $post_image = $post->images[0];

            $notificationData = [
                'user_id' => $author->id,
                'content' => __('notification.post_verified'),
                'link' => route('post.detail', ['slug' => str_replace('/', '', $post->slug)]),
                'image_path' => asset($post_image->path),
            ];

            $this->notificationRepo->createAndPushNotificationForUser($notificationData);
            $notificationData['content'] = __('notification.follower_has_new_post', ['user' => $author->name]);

            $this->notificationRepo->createAndPushNotificationForUsers($this->userRepo->getListUserIdFollowing($author->id), $notificationData);
            return redirect()
                ->route('admin.posts')
                ->with('message', ['content' => __('post.verify_success'), 'type' => 'success']);
        } catch (\Exception $exception) {
            return back()->with('message', ['content' => __('post.verify_failed'), 'type' => 'error']);
        }
    }

    public function unVerifyPost()
    {
        $posts = $this->postRepo->getUnVerifyPost();
        return view('admin.un_verify_posts.index', compact('posts'));
    }

    public function search(Request $request)
    {
        $query = $request->search_query;
        $posts = $this->postRepo->search($query);
        return view('admin.posts.index', compact('posts', 'query'));
    }
}
