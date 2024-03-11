<?php

namespace App\Repositories\Image;

interface ImageInterface
{
    public function get($request);

    public function getById($id);

    public function store($request);

    public function update($request, $id);

    public function destroy($id);

    public function savePostImage($post_id, $request);

    public function getByPath($image);
}
