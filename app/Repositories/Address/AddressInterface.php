<?php

namespace App\Repositories\Address;

interface AddressInterface
{
    public function get($request);

    public function getById($id);

    public function store($request);

    public function update($request, $id);

    public function destroy($id);

    public function saveAddressUser($user_id, $data);
}