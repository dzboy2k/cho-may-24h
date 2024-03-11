<?php

namespace App\Http\Controllers\Site\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateRequestWithdraw;
use App\Repositories\RequestWithdrawTransaction\RequestWithdrawTransactionInterface;

class WithdrawalController extends Controller
{
    private $transactionRepo;

    public function __construct(RequestWithdrawTransactionInterface $transaction)
    {
        $this->transactionRepo = $transaction;
    }
    public function showWithdrawalForm()
    {
        return view('site.transaction.withdrawal.enter_amount');
    }

    public function showBankAccountForm()
    {
        return view('site.transaction.withdrawal.bank_account');
    }
    public function handleWithdraw(CreateRequestWithdraw $request)
    {
        return $this->transactionRepo->store($request);
    }
}
