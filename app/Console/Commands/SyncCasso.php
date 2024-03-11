<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncCasso extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'casso:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call casso sync api';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $bank_account_id_of_casso_id = setting('site.bank_account_id_of_casso');
            $casso_key = setting('site.casso_key');
            if (!$bank_account_id_of_casso_id) {
                $this->error('Please add bank account in settings!');
                return Command::FAILURE;
            }
            if (!$casso_key) {
                $this->error("No casso api key found, let's update casso api key in admin settings");
                return Command::FAILURE;
            }

            $resp = Http::withHeaders([
                'Authorization' => "Apikey $casso_key",
                'Content-Type:' => 'application/json'
            ])->post(config('constants.CASSO_APIS')['SYNC'], ['bank_acc_id' => $bank_account_id_of_casso_id]);
            $this->info($resp);
        } catch (\Exception $exception) {
            $this->info($exception->getMessage());
        }
    }
}
