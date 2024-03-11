<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Models\Brand;
use App\Models\Post;
use App\Models\Category;
use App\Models\Status;
use App\Repositories\Image\ImageInterface;
use App\Repositories\Post\PostInterface;
use App\Repositories\SavedPost\SavedPostInterface;
use App\Repositories\Transaction\TransactionInterface;
use App\Repositories\Tag\TagInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    private $postRepo, $imgRepo, $tagRepo, $savedPostRepo, $transactionRepo;

    public function __construct(PostInterface $postRepo, ImageInterface $imgRepo, TagInterface $tagRepo, SavedPostInterface $savedPostRepo, TransactionInterface $transactionRepo)
    {
        $this->postRepo = $postRepo;
        $this->imgRepo = $imgRepo;
        $this->tagRepo = $tagRepo;
        $this->savedPostRepo = $savedPostRepo;
        $this->transactionRepo = $transactionRepo;
    }

    public function postDetail($slug)
    {
        try {
            $userId = Auth::id();
            $post = $this->postRepo->getBySlug($slug);
            if ($post) {
                $isSavedPost = $this->savedPostRepo->findSavedPost($userId, $post->id);
                $isVerifiedOrSold = in_array($post->post_state, config('constants.POST_STATUS')['SOLD_OR_VERIFIED']);
                if ($isVerifiedOrSold) {
                    $related_posts = $this->postRepo->getRelatePost($post->category_id, $post->id);
                    return view('site.posts.post_detail', compact('post', 'related_posts', 'isSavedPost'));
                }
            }
            abort(404);
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function createPost(CreatePostRequest $request)
    {
        try {
            DB::beginTransaction();
            if (isset($request->tags)) {
                $tags = explode(',', $request->tags);
                if (count($tags) > 6) {
                    return back()
                        ->withErrors(['tags' => __('message.limit_tags')])
                        ->withInput();
                }
            }
            $this->transactionRepo->handleMinusSaleLimitFromCreatePost($request);
            $id = $this->postRepo->store($request);
            $this->imgRepo->savePostImage($id, $request);
            if (isset($request->tags)) {
                $this->tagRepo->savePostTag(['id' => $id, 'tags' => $request->tags]);
            }
            DB::commit();
            return redirect()
                ->route('admin.posts')
                ->with('message', ['content' => __('message.create_success', ['name' => __('message.post')]), 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('message', ['content' => __('message.create_failed', ['name' => __('message.post')]), 'type' => 'error'])
                ->withInput();
        }
    }

    public function showCreatePostForm()
    {
        try {
            $statuses = Status::where('type', config('constants.STATUS_TYPES')['POST'])->get();
            $brands = Brand::all();
            $categories = Category::all();
            return view('site.posts.modify', compact('statuses', 'brands', 'categories'));
        } catch (\Exception $e) {
            abort(500);
        }
    }

    public function filterPost(Request $request)
    {
        return $this->postRepo->filterPost($request);
    }

    public function showUpdatePostForm(Request $request)
    {
        try {
            $post = $this->postRepo->getById($request->id);
            $statuses = Status::where('type', config('constants.STATUS_TYPES')['POST'])->get();
            $brands = Brand::all();
            $categories = Category::all();
            return view('site.posts.modify', compact('statuses', 'brands', 'categories', 'post'));
        } catch (\Exception $e) {
            abort(500);
        }
    }

    public function edit(EditPostRequest $request)
    {
        try {
            DB::beginTransaction();
            $id = $request->id;
            $post = Post::where([['id' => $id], ['post_state', '!=', config('constants.POST_STATUS')['SOLD']]]);
            if (!$post) {
                return back()
                    ->with('message', ['content' => __('message.not_exists_by_id', ['target' => __('post.post_in_lang')]), 'type' => 'error'])
                    ->withInput();
            }
            $this->transactionRepo->handleUpdateSaleLimitFromUpdatePost($request, $post);
            if (!$this->postRepo->update($request)) {
                return back()
                    ->with('message', ['content' => __('message.not_exists_by_id', ['target' => __('post.post_in_lang')]), 'type' => 'error'])
                    ->withInput();
            }
            $this->imgRepo->savePostImage($id, $request);

            if (isset($request->tags)) {
                $tags = explode(',', $request->tags);
                if (count($tags) > 6) {
                    return back()
                        ->withErrors(['tags' => __('message.limit_tags')])
                        ->withInput();
                }
            }
            if (isset($request->tags)) {
                $this->tagRepo->savePostTag(['id' => $id, 'tags' => $request->tags]);
            }
            DB::commit();
            return redirect()
                ->route('user.info')
                ->with('message', ['content' => __('message.update_success', ['name' => __('message.post')]), 'type' => 'success'])
                ->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->with('message', ['content' => __('message.update_failed', ['name' => __('message.post')]), 'type' => 'error'])
                ->withInput();
        }
    }

    public function delete($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return back()
                ->with('message', ['content' => __('message.not_exists_by_id', ['target' => __('post.post_in_lang')]), 'type' => 'error'])
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $this->transactionRepo->handleAddSaleLimitFromDeletePost($post);
            $this->postRepo->destroy($id);
            DB::commit();
            return back()
                ->with('message', ['content' => __('message.delete_success', ['target' => __('post.post_in_lang')]), 'type' => 'success'])
                ->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->with('message', ['content' => __('message.delete_failed', ['target' => __('post.post_in_lang')]), 'type' => 'error'])
                ->withInput();
        }
    }
}
