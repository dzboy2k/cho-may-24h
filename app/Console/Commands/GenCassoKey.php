<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenCassoKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:casso_key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate casso sercu-key if dont have';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $key = '';
            $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            $charsetLength = strlen($charset);

            for ($i = 0; $i < config('constants.CASSO_KEY_LENGTH'); $i++) {
                $randomIndex = rand(0, $charsetLength - 1);
                $key .= $charset[$randomIndex];
            }

            $env_path = base_path('.env');
            $env_content = file_get_contents($env_path);
            $casso_key = config('constants.CASSO_KEY_NAME');
            $new_pair_casso_key_value = $casso_key . '=' . $key;

            if (file_exists($env_path)) {
                if (strpos($env_content, $casso_key)) {
                    $regex = "/$casso_key\=.*/";
                    file_put_contents($env_path, preg_replace($regex, $new_pair_casso_key_value, $env_content));
                    $this->info('Gen and update casso private key success:' . $new_pair_casso_key_value);
                } else {
                    file_put_contents($env_path, $env_content . $new_pair_casso_key_value);
                    $this->info('Gen casso private key success'.$new_pair_casso_key_value);
                }
            }
        } catch (\Exception $exception) {
            $this->error('Error : ', $exception->getMessage());
        }
    }
}
