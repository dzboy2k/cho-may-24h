<?php

namespace App\Http\Controllers\Site\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\SupportTransaction\SupportTransactionInterface;

class SupportController extends Controller
{
    private $supportTransactionRepo;

    public function __construct(SupportTransactionInterface $transaction)
    {
        $this->supportTransactionRepo = $transaction;
    }
    public function showTransfer(Request $request)
    {
        $supportTransactionCanTransfer = $this->supportTransactionRepo->getSupportTransactionCanTransfer($request);
        return view('site.transaction.transfer.support_transaction', compact('supportTransactionCanTransfer'));
    }
    public function handleTransfer(Request $request){
        return $this->supportTransactionRepo->handleTransferSupport($request);
    }
}
