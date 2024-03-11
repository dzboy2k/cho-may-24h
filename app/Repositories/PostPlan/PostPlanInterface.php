<?php

namespace App\Repositories\PostPlan;

interface PostPlanInterface
{
    public function get();

    public function getById($id);

    public function store($request);

    public function update($request);

    public function destroy($id);

    public function destroyAll($ids);

    public function search($search_query);

    public function registerPlan($id);
}
