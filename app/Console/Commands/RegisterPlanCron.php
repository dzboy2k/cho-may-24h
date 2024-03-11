<?php

namespace App\Console\Commands;

use App\Models\PostPlan;
use App\Models\User;
use App\Models\UserPlanPayment;
use App\Repositories\Notification\NotificationRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class RegisterPlanCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register plan command';
    private $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        parent::__construct();
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Execute the console command.
     *
     * @return array[]
     */
    function mapPlanById($plans)
    {
        $plans_mapped = array();
        foreach ($plans as $plan) {
            $plans_mapped[$plan['id']] = $plan['price_per_month'];
        }
        return $plans_mapped;
    }

    function handleSendNotifyForUser($user_id)
    {
        $this->notificationRepository->createAndPushNotificationForUser(
            [
                'user_id' => $user_id,
                'content' => __('post_plan.reg_failed'),
                'link' => route('site.post-plans'),
                'image_path' => asset(config('constants.DEFAULT_AVT_PATH')),
                'readed' => 0
            ]
        );
    }

    public function tryPaid($user_wallet, $plan)
    {
        $count = config('constants.LIMIT_REGISTER_PLAN_CRON');

        while ($count > 0) {
            try {
                DB::beginTransaction();
                $user_wallet->save();
                $plan->save();
                DB::commit();
            } catch (Exception $e) {
                $count--;
                DB::rollBack();
            }
        }
    }

    public function canRegister($need_coin, $have_coin)
    {
        if ($need_coin <= 0) {
            return false;
        }
        return $have_coin - $need_coin >= 0;
    }

    public function handle()
    {
        try {
            $user_plans = UserPlanPayment::where('expiration_date', '<', Carbon::now())->get();
            $plans = $this->mapPlanById(PostPlan::select('price_per_month', 'id')->get()->toArray());

            foreach ($user_plans as $plan) {
                $user_wallet = User::find($plan->user_id)->wallet;
                $price_need = $plans[$plan->package_id];

                if (!$user_wallet) {
                    continue;
                }
                if (!$this->canRegister($price_need, $user_wallet->payment_coin)) {
                    continue;
                }
                $user_wallet->payment_coin -= $price_need;
                $plan->expire_date = Carbon::now()->addMonth();
                $this->tryPaid($user_wallet, $plan);
            }
            return Command::SUCCESS;
        } catch (\Exception $exception) {
            Log::debug($exception);
            return Command::FAILURE;
        }
    }
}
