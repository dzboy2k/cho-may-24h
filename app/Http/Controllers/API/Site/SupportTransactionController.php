<?php

namespace App\Http\Controllers\API\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\SupportTransaction\SupportTransactionInterface;

class SupportTransactionController extends Controller
{
    private $supportTransactionRepo;

    public function __construct(SupportTransactionInterface $transaction)
    {
        $this->supportTransactionRepo = $transaction;
    }
    public function checkUserTargetToTransfer(Request $request)
    {
        $userTarget = $this->supportTransactionRepo->getUserByReferralCode($request->referral_code);
        if ($userTarget) {
            if($userTarget->id == Auth::id()){
                return response()->json(['message' => __('transaction.invalid_self_transfer')], 400);
            }
            else{
                return response()->json($userTarget->name);
            }
        } else {
            return response()->json(['message' => __('auth.user_not_found')], 404);
        }
    }
}
