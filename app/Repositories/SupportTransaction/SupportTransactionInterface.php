<?php

namespace App\Repositories\SupportTransaction;

interface SupportTransactionInterface
{
    public function getSupportTransactionWithPaginate($request);

    public function getSupportTransaction();

    public function getSupportTransactionCanTransfer($request);

    public function getUserByReferralCode($referral_code);

    public function getById($id);

    public function createSupportTransactionForUserIdFromReferralCode($data);

    public function handleTransferSupport($request);

    public function createSupportTransactionForUserIdFromPost($data);

    public function createSupportTransaction($data);
}
