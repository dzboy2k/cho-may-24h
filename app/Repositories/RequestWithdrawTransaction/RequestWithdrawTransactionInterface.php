<?php

namespace App\Repositories\RequestWithdrawTransaction;


interface RequestWithdrawTransactionInterface
{
    public function confirmRequest($id);

    public function get();

    public function getListRequestWithdrawByUserId($request);

    public function getById($id);

    public function store($request);

    public function update($request, $id);

    public function destroy($id);

    public function searchById($id);
}