<?php

namespace App\Http\Controllers\API\Site;

use App\Http\Controllers\Controller;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Transaction\TransactionInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CassoWebhookController extends Controller
{
    private $transactionRepo;
    private $notificatiomRepo;

    public function __construct(TransactionInterface $transactionRepo, NotificationRepositoryInterface $notificationRepository)
    {
        $this->transactionRepo = $transactionRepo;
        $this->notificatiomRepo = $notificationRepository;
    }

    public function balanceFluctuations(Request $request)
    {
        $error = $request->json()->get('error');

        if ($error != 0) {
            Log::error(Carbon::now() . __('transaction.casso_transaction_failed'));
            return response()->json(['message' => __('transaction.casso_transaction_failed')], 400);
        }
        $transactions = $request->json()->all()['data'];
        if (count($transactions) <= 0) {
            return response()->json(['message' => __('transaction.no_casso_transaction')], 400);
        }
        $this->transactionRepo->processTransactionFromWebhook($transactions,$this->notificatiomRepo);
    }
}
