<?php

namespace App\Http\Controllers\Site\Transaction;

use App\Http\Controllers\Controller;
use App\Repositories\Transaction\TransactionInterface;
use Illuminate\Http\Request;

class SaleLimitController extends Controller
{
    private $transactionRepo;

    public function __construct(TransactionInterface $transaction)
    {
        $this->transactionRepo = $transaction;
    }

    public function showTransfer(Request $request)
    {
        return view('site.transaction.transfer.sale_limit');
    }
    public function handleTransfer(Request $request){
        return $this->transactionRepo->transferSaleLimit($request);
    }
}
