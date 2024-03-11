<?php

namespace App\Repositories\UserPostingPlan;

interface UserPostingPlanInterface
{
    public function get();

    public function getById($id);

    public function store($request);

    public function update($request);

    public function destroy($id);

    public function destroyAll($ids);

    public function search($query);

    public function getByUser($id);

    public function cancelPlan($user_id, $id);
}
