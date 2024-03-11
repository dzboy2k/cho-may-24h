<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\RequestWithdrawTransaction\RequestWithdrawTransactionInterface;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    private $withdrawRequestRepo;

    public function __construct(RequestWithdrawTransactionInterface $requestWithdrawTransaction)
    {
        $this->withdrawRequestRepo = $requestWithdrawTransaction;
    }

    public function index()
    {
        return view('admin.withdraws.index', ['request_withdraw' => $this->withdrawRequestRepo->get()]);
    }

    public function search(Request $request)
    {
        $search_query = $request->search_query;
        return view('admin.withdraws.index', ['request_withdraw' => $this->withdrawRequestRepo->searchById($search_query), 'query' => $search_query]);
    }

    public function verifyWithdrawRequest($id)
    {
        return $this->withdrawRequestRepo->confirmRequest($id);
    }
}
