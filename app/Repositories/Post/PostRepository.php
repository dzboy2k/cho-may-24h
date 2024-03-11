<?php

namespace App\Repositories\Post;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Post;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class PostRepository extends Controller implements PostInterface
{
    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function get()
    {
        return $this->post
            ::where('post_state', config('constants.POST_STATUS')['VERIFIED'])
            ->orWhere('post_state', config('constants.POST_STATUS')['SOLD'])
            ->orderBy('release_date', 'desc')
            ->paginate(config('constants.POST_PER_PAGE'));
    }

    public function getUnVerifyPost()
    {
        return $this->post
            ::where('post_state', config('constants.POST_STATUS')['UNVERIFIED'])
            ->orderBy('updated_at', 'desc')
            ->paginate(config('constants.POST_PER_PAGE'));
    }

    public function getById($id)
    {
        return $this->post::find($id);
    }

    protected function genPostDataFromRequest($request)
    {
        $receive_percent = setting('site.support_receive_percent') / 100;
        $current_role_id = Auth::user()->role_id;
        $scriptTagRegex = config('constants.SCRIPT_TAG_REGEX');
        $is_official = $current_role_id == config('constants.ROLES')['ADMIN'];
        $is_partner = $current_role_id == config('constants.ROLES')['PARTNER'];
        $data = [
            'price' => $request->price,
            'receive_support' => ($request->support_limit_receive * $receive_percent) / 100,
            'support_limit' => $request->support_limit_receive,
            'addition_info' => preg_replace($scriptTagRegex, '', html_entity_decode($request->introduce)),
            'description' => preg_replace($scriptTagRegex, '', html_entity_decode($request->description)),
            'title' => strip_tags(html_entity_decode($request->title)),
            'status_id' => $request->status,
            'category_id' => $request->category,
            'brand_id' => $request->brand,
            'slug' => strip_tags(html_entity_decode($request->slug)),
            'is_partner' => $is_partner,
            'post_state' => $is_official,
            'amount_view' => 0,
            'expire_limit_month' => $request->support_time,
            'is_official' => $is_official,
            'release_date' => $is_official ? now() : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        return $data;
    }

    public function store($request)
    {
        $currentAuth = Auth::user();
        $data = $this->genPostDataFromRequest($request);
        $data['author_id'] = $currentAuth->id;
        return $this->post::insertGetId($data);
    }

    public function update($request)
    {
        $post = $this->post::find($request->id);
        if (!$post) {
            return false;
        } else {
            $originalReleaseDate = $post->release_date;
            $this->deleteEverythingRelateToPost($post);
            $data = $this->genPostDataFromRequest($request);
            $data['release_date'] = $originalReleaseDate;
            $post->fill($data);
            $post->save();
            return true;
        }
    }

    public function getBySlug($slug)
    {
        return $this->post::where('slug', $slug)->first();
    }

    public function getRelatePost($category_id, $post_id)
    {
        return $this->post
            ::where([['category_id', '=', $category_id], ['id', '!=', $post_id], ['post_state', '=', config('constants.POST_STATUS')['VERIFIED']]])
            ->orderBy('release_date', 'desc')
            ->limit(config('constants.POST_PER_CATEGORY'))
            ->get();
    }

    public function filterPost(Request $request)
    {
        try {
            $categories = Category::all();
            $brands = Brand::all();
            $status = Status::all();
            $queryParams = [
                'post_state' => config('constants.POST_STATUS')['VERIFIED'],
            ];
            $queryParams = $this->mapDataToGetParamsIfNeeded($request, ['brand_id', 'status_id', 'category_id']);
            $order_by = $request->sort_by ?? 'price';
            $order_type = $request->sort_type ?? 'asc';
            $queryBuilder = $this->post::where($queryParams);
            $select_data = $request->query();
            if ($request->has('price') && $request->price) {
                $price = explode(',', $request->price);
                $queryBuilder->whereBetween('price', $price);
                $select_data['price'] = $price;
            }
            $postByFilter = $queryBuilder->orderBy($order_by, $order_type)->paginate(config('constants.POST_PER_PAGE'));

            return view('site.posts.filter_posts', compact('postByFilter', 'status', 'brands', 'categories', 'select_data'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function getSupportedPost($paginate, $is_official)
    {
        $queryBuilder = $this->post::where([['receive_support', '>', 0], ['post_state', '=', config('constants.POST_STATUS')['VERIFIED']]])->orderBy('release_date', 'desc');
        if ($is_official) {
            $queryBuilder->where('is_official', config('constants.OFFICIAL_TYPES')['IS_OFFICIAL']);
        }
        if ($paginate) {
            return $queryBuilder->paginate(config('constants.DATA_PER_PAGE'));
        }
        return $queryBuilder->limit(config('constants.POST_PER_CATEGORY'))->get();
    }

    public function getPostByCategory($limit, $category_id, $paginate)
    {
        $queryBuilder = $this->post::where([['category_id' => $category_id], ['post_state', '=', config('constants.POST_STATUS')['VERIFIED']]])->orderBy('release_date', 'desc');
        if ($limit) {
            return $queryBuilder->limit($limit)->get();
        }
        if ($paginate) {
            $queryBuilder->paginate(config('constants.POST_PER_PAGE'));
        }
        return $queryBuilder->get();
    }

    public function getRecentPost($with_paginate, $is_official)
    {
        $queryBuilder = $this->post::where([['post_state', '=', config('constants.POST_STATUS')['VERIFIED']]])->orderBy('release_date', 'desc');
        if ($is_official) {
            $queryBuilder->where('is_official', config('constants.OFFICIAL_TYPES')['IS_OFFICIAL']);
        }
        if ($with_paginate) {
            return $queryBuilder->paginate(config('constants.DATA_PER_PAGE'));
        }
        return $queryBuilder->limit(config('constants.POST_PER_CATEGORY'))->get();
    }

    public function getPostByCategories($limit, $is_official)
    {
        $categories = Category::where('parent_id', '=', null)->pluck('id');
        $queryBuilder = $this->post::where('post_state', config('constants.POST_STATUS')['VERIFIED'])->whereIn('category_id', $categories);
        if ($is_official) {
            $queryBuilder->where('is_official', config('constants.OFFICIAL_TYPES')['IS_OFFICIAL']);
        }
        $queryBuilder->orderBy('release_date', 'desc');
        return $this->groupPostByCategory($queryBuilder->get(), $limit);
    }

    private function groupPostByCategory($posts, $postPerCategory)
    {
        $postByCategories = [];
        foreach ($posts as $post) {
            $category_slug = str_replace('/', '', $post->category->slug);
            $title = $post->category->name;
            if (!array_key_exists($category_slug, $postByCategories)) {
                $postByCategories[$category_slug]['items'] = [];
                $postByCategories[$category_slug]['title'] = $title;
                $postByCategories[$category_slug]['slug'] = $category_slug;
            }
            if (count($postByCategories[$category_slug]['items']) < $postPerCategory) {
                $postByCategories[$category_slug]['items'][] = $post;
            }
        }
        return $postByCategories;
    }

    public function existsPostByCategories($categories_id)
    {
        return $this->post::whereIn('category_id', $categories_id)->exists();
    }

    public function deleteSavedPost($post)
    {
        foreach ($post->savedPost as $item) {
            $item->delete();
        }
    }

    public function deleteEverythingRelateToPost($post)
    {
        if ($post) {
            foreach ($post->images as $image) {
                $this->deleteStorageFile($image->path);
            }
            $post->images()->detach();
            $post->tags()->detach();
        }
    }

    private function returnSaleCoin($post)
    {
        try {
            if ($post->post_state != config('constants.POST_STATUS')['SOLD']) {
                $author_wallet = $post->author->wallet;
                if ($author_wallet) {
                    $author_wallet->sale_limit += $post->support_limit;
                    $author_wallet->save();
                }
            }
        } catch (\Exception $exception) {
            //TODO: push notification to user
        }
    }

    public function destroy($delete_post)
    {
        $this->returnSaleCoin($delete_post);
        $this->deleteEverythingRelateToPost($delete_post);
        $this->deleteSavedPost($delete_post);
        $delete_post->delete();
    }

    public function destroyAll($ids)
    {
        try {
            $posts = $this->post::whereIn('id', $ids)->get();
            foreach ($posts as $post) {
                $this->deleteEverythingRelateToPost($post);
                $this->deleteSavedPost($post);
                $this->returnSaleCoin($post);
                $post->delete();
            }
            return response()->json(['message' => __('post.delete_success')]);
        } catch (\Exception $exception) {
            return response()->json(['message' => __('post.delete_failed')], 500);
        }
    }

    public function verifyPost($request)
    {
        $post = $this->post::find($request->id);
        $post->fill([
            'post_state' => config('constants.POST_STATUS')['VERIFIED'],
            'expire_limit_month' => $request->support_time,
            'receive_support' => (float) $post->support_limit / $request->support_time / 30,
            'release_date' => Carbon::now(),
        ]);
        $post->save();
        return $post;
    }

    public function search($query)
    {
        return $this->post
            ::where([['post_state', '=', config('constants.POST_STATUS')['VERIFIED']]])
            ->where(function ($subquery) use ($query) {
                $subquery->where('title', 'LIKE', '%' . $query . '%')->orWhereHas('tags', function ($tagQuery) use ($query) {
                    $tagQuery->where('name', 'LIKE', '%' . $query . '%');
                });
            })
            ->orderBy('release_date', 'desc')
            ->paginate(config('constants.DATA_PER_PAGE'));
    }

    public function getPostByIdForChat($post_id)
    {
        return $this->post
            ::select('id', 'author_id', 'title', 'price')
            ->with('images')
            ->where('id', $post_id)
            ->first();
    }

    public function getByUser($id)
    {
        return $this->post
            ::where('author_id', '=', $id)
            ->where('post_state', config('constants.POST_STATUS')['VERIFIED'])
            ->orderBy('release_date', 'desc')
            ->paginate(config('constants.AMOUNT_POST_IN_PROFILE'));
    }

    public function getSupportPostByCategoryId($id, $is_official)
    {
        $queryBuilder = $this->post::where([['post_state', '=', config('constants.POST_STATUS')['VERIFIED']], ['category_id', '=', $id]]);
        if ($is_official) {
            $queryBuilder->where('is_official', config('constants.OFFICIAL_TYPES')['IS_OFFICIAL']);
        }
        $queryBuilder->orderBy('release_date', 'desc');
        return $queryBuilder->paginate(config('constants.DATA_PER_PAGE'));
    }

    public function getUnVerifyPostByUser($currentUserId)
    {
        return $this->post
            ::where([['author_id', '=', $currentUserId], ['post_state', '=', config('constants.POST_STATUS')['UNVERIFIED']]])
            ->orderBy('updated_at', 'desc')
            ->paginate(config('constants.AMOUNT_POST_IN_PROFILE'));
    }

    public function getPostByUserWithShowType($userId, $showType)
    {
        $showTypes = config('constants.SHOW_TYPES');
        switch ($showType) {
            case $showTypes['SHOWING']:
                return $this->getByUser($userId);
            case $showTypes['SOLD']:
                return $this->getSoldPostByUser($userId);
            case $showTypes['UNVERIFY']:
                return $this->getUnVerifyPostByUser($userId);
        }
    }

    public function getSoldPostByUser($userId)
    {
        return $this->post
            ::where([['author_id', '=', $userId], ['post_state', '=', config('constants.POST_STATUS')['SOLD']]])
            ->orderBy('release_date', 'desc')
            ->paginate(config('constants.AMOUNT_POST_IN_PROFILE'));
    }

    public function getOfficialPost()
    {
        $isVerifiedOrSold = config('constants.POST_STATUS')['SOLD_OR_VERIFIED'];

        return $this->post::whereIn([['post_state', '=', $isVerifiedOrSold], ['is_official', '=', config('constants.OFFICIAL_TYPES')['IS_OFFICIAL']]])->paginate(config('constants.DATA_PER_PAGE'));
    }
}
