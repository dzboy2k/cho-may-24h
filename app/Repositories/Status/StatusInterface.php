<?php

namespace App\Repositories\Status;

interface StatusInterface
{
    public function get();

    public function getById($id);

    public function store($request);

    public function update($request);

    public function destroy($id);

    public function destroyAll($ids);

    public function search($query);
}
