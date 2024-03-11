<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

class CreateWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:casso_webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command create new casso webhook';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $secure_token_for_casso_hook = env(config('constants.CASSO_KEY_NAME'));
        $casso_key = setting('site.casso_key');
        if (!$secure_token_for_casso_hook) {
            Artisan::call('gen:casso_key');
            $this->info('generated casso key success');
        }

        if (!$casso_key) {
            $this->error("No casso api key found, let's update casso api key in admin settings");
            return;
        }
        $data = [
            'webhook' => route('api.transactions.fluctuations'),
            'secure_token' => $secure_token_for_casso_hook,
            'income_only' => true
        ];
        $response = Http::withHeaders([
            'Authorization' => "Apikey $casso_key"
        ])
            ->post(config('constants.CASSO_APIS')['CREATE_HOOK'], $data);
        $this->info($response);
    }
}
