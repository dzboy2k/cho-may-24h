<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;

use App\Exceptions\ReferralNotFound;
use App\Exceptions\UserNotFound;

use App\Repositories\Authentication\AuthenticationInterface;
use App\Repositories\SupportTransaction\SupportTransactionInterface;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $authenticationRepo;
    private $supportTransactionRepo;

    public function __construct(AuthenticationInterface $authenticationRepo, SupportTransactionInterface $supportTransactionRepo)
    {
        $this->authenticationRepo = $authenticationRepo;
        $this->supportTransactionRepo = $supportTransactionRepo;
    }

    public function showLoginForm()
    {
        return view('site.auth.login');
    }

    public function login(LoginRequest $request)
    {
        return $this->authenticationRepo->login($request);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function showRegisterForm()
    {
        return view('site.auth.register');
    }

    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $id = $this->authenticationRepo->register($request);
            if ($request->referral_code) {
                $data = ['referral_code' => $request->referral_code, 'user_who_input_referral_code_id' => $id];
                $this->supportTransactionRepo->createSupportTransactionForUserIdFromReferralCode($data);
            }
            DB::commit();
            return redirect()
                ->route('auth.login.form')
                ->with('message', ['content' => __('message.register_success'), 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            if ($e instanceof UserNotFound || $e instanceof ReferralNotFound) {
                $target = __('message.user');
                if ($e instanceof ReferralNotFound) {
                    $target = __('user_info.referral_code');
                }
                return back()
                    ->withErrors(['auth_failed'=>__('message.target_not_found', ['target' => $target])])
                    ->withInput();
            } else {
                dd($e);
                return back()
                    ->withErrors(['auth_failed'=>__('message.server_error')])
                    ->withInput();
            }
            return back()
                ->withErrors(['auth_failed' => __('message.register_failed')])
                ->withInput();
        }
    }

    public function showForgotPasswordForm()
    {
        return view('site.auth.forgot_password');
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        return $this->authenticationRepo->forgotPassword($request);
    }

    public function showVerifyForgotCodeForm(Request $request)
    {
        return view('site.auth.verify_forgot_code', ['token' => $request->token, 'email' => $request->email]);
    }

    public function verifyForgotCode(Request $request)
    {
        return $this->authenticationRepo->verifyForgotCode($request);
    }

    public function showResetPasswordForm(Request $request)
    {
        if (!$request->code) {
            return redirect()
                ->route('auth.forgot_password')
                ->with('message', ['content' => __('auth.not_allow_page'), 'type' => 'error']);
        }
        return view('site.auth.reset_password', ['token' => $request->token, 'email' => $request->email, 'code' => $request->code]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        if (!$request->code) {
            return redirect()
                ->route('auth.forgot_password')
                ->with('message', ['content' => __('auth.not_allow_page'), 'type' => 'error']);
        }
        return $this->authenticationRepo->resetPassword($request);
    }
}
