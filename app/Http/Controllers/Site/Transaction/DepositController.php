<?php

namespace App\Http\Controllers\Site\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\TransferToSaleLimitRequest;
use App\Repositories\Transaction\TransactionInterface;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    private $transactionRepo;

    public function __construct(TransactionInterface $transaction)
    {
        $this->transactionRepo = $transaction;
    }

    public function showDepositMethod()
    {
        return view('site.transaction.deposit.select_method');
    }

    public function showEnterSaleLimitAmount()
    {
        return view('site.transaction.deposit.sale_limit');
    }

    public function transferToSaleWallet(TransferToSaleLimitRequest $request)
    {
        return $this->transactionRepo->transferFromPaymentWalletToSaleLimitWallet($request);
    }

    public function createFromGetDepreciationWalletToMainWallet(CreateTransactionRequest $request)
    {
        return $this->transactionRepo->createTransferFromGetDepreciationWalletToPaymentWallet($request);
    }

    public function showEnterDepositAmount($type)
    {
        if (!in_array($type, config('constants.DEPOSIT_TYPES'))) {
            abort(404);
        }
        return view('site.transaction.deposit.enter_amount', compact('type'));
    }

    public function createTransaction(CreateTransactionRequest $request)
    {
        $request->wallet_id = Auth::user()->wallet->id;

        return $this->transactionRepo->storeDeposit($request);
    }

    public function showDepreciationTransferForm()
    {
        return view('site.transaction.deposit.depreciation');
    }

    public function showTransferInfo($id)
    {
        $transaction = $this->transactionRepo->getPendingDepositInfoById($id);
        if(!$transaction){
            abort(404);
        }
        return view('site.transaction.deposit.transfer_info', compact('transaction'));
    }
}
