<?php

namespace App\Repositories\Order;

interface OrderInterface
{
    public function get($request);
    public function getByUserId($request);
    public function getByBuyerId($id);
    public function getBySellerId($id);
    public function getById($id);
    public function store($post_id);
    public function update($request, $id);
    public function setPaid($id);
    public function setReceived($id);
    public function destroy($id);
}
