<?php

namespace App\Repositories\Page;

interface PageInterface
{
    public function get();

    public function getById($id);

    public function store($request);

    public function update($request);

    public function destroy($id);

    public function getHomeSlide($limit);

    public function search($search_query);

    public function getServicePage();

    public function getBySlug($slug);
}
