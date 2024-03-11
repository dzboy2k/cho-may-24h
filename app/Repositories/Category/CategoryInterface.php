<?php

namespace App\Repositories\Category;

interface CategoryInterface
{
    public function get();

    public function getById($id);

    public function store($request);

    public function update($request);

    public function destroy($id);

    public function getBySlug($slug);

    public function deleteAll($ids);

    public function getCategoriesWithoutSelf($id);

    public function getIdBySlug($slug);

    public function search($query);

    public function checkIsDescendant($target_category_id, $check_id);

}
