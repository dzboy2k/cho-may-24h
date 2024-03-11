<?php

namespace App\Http\Controllers\Site\History;
use App\Http\Controllers\Controller;
use App\Repositories\SupportTransaction\SupportTransactionInterface;
use Illuminate\Http\Request;

class SupportTransactionController extends Controller
{
    private $suppportTransactionRepo;

    public function __construct(SupportTransactionInterface $suppportTransaction)
    {
        $this->suppportTransactionRepo = $suppportTransaction;
    }
    public function index(Request $request){
        $suppportTransactions = $this->suppportTransactionRepo->getSupportTransactionWithPaginate($request);
        return view('site.history.support_transaction', compact('suppportTransactions'));
    }
}
