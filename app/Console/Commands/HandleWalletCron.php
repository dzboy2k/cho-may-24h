<?php

namespace App\Console\Commands;

use App\Models\SupportTransaction;
use App\Models\Wallet;

use App\Repositories\Transaction\TransactionInterface;
use App\Repositories\SupportTransaction\SupportTransactionInterface;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class HandleWalletCron extends Command
{
    private $transactionRepo;
    private $supportTransactionRepo;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallet:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command to calc deprecacation wallet and sale wallet';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function __construct(TransactionInterface $transactionRepo, SupportTransactionInterface $supportTransactionRepo)
    {
        parent::__construct();
        $this->transactionRepo = $transactionRepo;
        $this->supportTransactionRepo = $supportTransactionRepo;
    }

    public function handle()
    {
        try {
            $transactions = SupportTransaction::where('expiration_date', '>', Carbon::now())
                ->where('is_need_for_calc_each_day', true)
                ->get();
            $user_total_support = [];
            $receive_percent = setting('site.support_receive_percent') / 100;
            $total_consuming_support = 0;
            $the_time_caculating = Carbon::now();
            foreach ($transactions as $transaction) {
                if ($transaction->expiration_date > $the_time_caculating) {
                    if (isset($user_total_support[$transaction->wallet_id])) {
                        $user_total_support[$transaction->wallet_id] += $transaction->receive_support;
                    } else {
                        $user_total_support[$transaction->wallet_id] = $transaction->receive_support;
                    }
                } else {
                    try {
                        $dataSupport = [
                            'fluctuation' => $transaction->fluctuation,
                            'expiration_date' => $transaction->expiration_date,
                            'wallet_id' => $transaction->wallet_id,
                            'description' => __('transaction.support_limit_outdate', ['support_limit' => $transaction->id]),
                            'is_need_for_calc_each_day' => false,
                            'receive_type' => $transaction->receive_type,
                        ];
                        $this->supportTransactionRepo->createSupportTransaction($dataSupport);
                    } catch (\Exception $e) {
                    }
                }
            }
            foreach ($user_total_support as $wallet_id => $total_support) {
                try {
                    DB::beginTransaction();
                    $get_depreciation_support = $total_support * $receive_percent;
                    $user_wallet = Wallet::find($wallet_id);
                    $user_wallet->get_depreciation_support += $get_depreciation_support;
                    $user_wallet->depreciation_support_limit = $total_support;
                    $user_wallet->save();
                    $this->transactionRepo->storeDepreciationTransaction($user_wallet->id, $get_depreciation_support, config('constants.TRANSACTION_TYPE')['RECEIVE_SUPPORT']);
                    DB::commit();
                    $total_consuming_support += $get_depreciation_support;
                } catch (\Exception $exception) {
                    $this->error(Carbon::now() . ' - Error when process support transaction for wallet : ' . $wallet_id);
                    DB::rollBack();
                }
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
