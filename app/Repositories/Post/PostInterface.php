<?php

namespace App\Repositories\Post;

use Illuminate\Http\Request;

interface PostInterface
{
    public function get();

    public function getById($id);

    public function store($request);

    public function update($request);

    public function destroy($id);

    public function getBySlug($slug);

    public function getRelatePost($category_id, $post_id);

    public function filterPost(Request $request);

    public function getSupportedPost($with_paginate, $is_official);

    public function getPostByCategory($limit, $category_id, $with_paginate);

    public function getRecentPost($with_paginate, $is_official);

    public function existsPostByCategories($categories_id);

    public function getPostByCategories($limit, $is_official);

    public function getUnVerifyPost();

    public function destroyAll($ids);

    public function verifyPost($request);

    public function search($query);

    public function getPostByIdForChat($post_id);

    public function getByUser($id);

    public function getSupportPostByCategoryId($id,$is_official);

    public function getUnVerifyPostByUser($currentUserId);

    public function getPostByUserWithShowType($userId, $showType);

    public function getSoldPostByUser($userId);

    public function getOfficialPost();
}
