<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTransaction;
use App\Repositories\SupportTransaction\SupportTransactionInterface;
use App\Repositories\Transaction\TransactionInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionController extends Controller
{
    private $transactionRepo;
    private $supportTransaction;

    public function __construct(TransactionInterface $transaction, SupportTransactionInterface $supportTransaction)
    {
        $this->transactionRepo = $transaction;
        $this->supportTransaction = $supportTransaction;
    }

    public function index(Request $request)
    {
        $transactions = $this->transactionRepo->getWithoutPaginate();
        $support_transaction = $this->supportTransaction->getSupportTransaction();
        $mergeTransactions = $transactions->merge($support_transaction);
        $page = $request->get('page', 1);
        $paginatedResult = new LengthAwarePaginator(
            $mergeTransactions->forPage($page, config('constants.DATA_PER_PAGE')),
            $mergeTransactions->count(),
            config('constants.DATA_PER_PAGE'),
            $page,
            ['path' => $request->url()]
        );
        return view('admin.transactions.index', ['transactions' => $paginatedResult]);
    }

    public function search(Request $request)
    {
        $query = $request->search_query;
        $transactions = $this->transactionRepo->searchById($query);
        return view('admin.transactions.index', compact('transactions', 'query'));
    }
}
