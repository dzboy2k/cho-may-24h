<?php

namespace App\Repositories\Transaction;

interface TransactionInterface
{
    public function get();

    public function getByTransactionTypeWithPaginate($type);

    public function getById($id);

    public function getByIdAndType($id, $type);

    public function getPendingDepositInfoById($id);

    public function store($request);

    public function storeDeposit($request);

    public function update($request);

    public function destroy($id);

    public function transferSaleLimit($request);

    public function handleAddSaleLimitFromDeletePost($post);

    public function handleUpdateSaleLimitFromUpdatePost($request, $post);

    public function handleMinusSaleLimitFromCreatePost($request);

    public function processTransactionFromWebhook($transaction_data, $notifiRepo);

    public function createTransferFromGetDepreciationWalletToPaymentWallet($request);

    public function transferFromPaymentWalletToSaleLimitWallet($request);

    public function handleAddCointToWalletByAdminWithType($request);

    public function handleMinusCointToWalletByAdminWithType($request);

    public function searchById($id);

    public function getWithoutPaginate();
}
