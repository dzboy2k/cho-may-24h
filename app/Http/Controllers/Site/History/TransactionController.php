<?php

namespace App\Http\Controllers\Site\History;

use App\Http\Controllers\Controller;
use App\Repositories\Transaction\TransactionInterface;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $transactionRepo;

    public function __construct(TransactionInterface $transaction)
    {
        $this->transactionRepo = $transaction;
    }

    public function index(Request $request)
    {
        $history_type = $request->history_type ?? 0;
        $view = config('constants.TRANSACTION_HISTORY_VIEW_MAPPED_WITH_ID_BY_INDEX');
        if ($history_type >= count($view)) {
            abort(404);
        }
        $transactions = $this->transactionRepo->getByTransactionTypeWithPaginate($history_type);
        return view($view[$history_type], compact('transactions'));
    }
}
