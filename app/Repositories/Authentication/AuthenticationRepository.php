<?php

namespace App\Repositories\Authentication;

use App\Http\Controllers\Controller;

use App\Mail\ForgotPasswordMail;
use App\Models\User;
use App\Models\Wallet;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use App\Repositories\SupportTransaction\SupportTransactionInterface;

use Mockery\Exception;

class AuthenticationRepository extends Controller implements AuthenticationInterface
{
    private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function register($request)
    {
        $referralCode = '';
        do {
            $referralCode = str_pad(mt_rand(1, 999999999), config('constants.USER_REFERRAL_CODE_LENGTH'), '0', STR_PAD_LEFT);
        } while ($this->userModel::where('referral_code', $referralCode)->exists());

        $id = $this->userModel->insertGetId([
            'phone' => $request->phone,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referral_code' => $referralCode,
            'role_id' => config('constants.ROLES')['USER'],
            'created_at' => Carbon::now(),
        ]);
        Wallet::create([
            'user_id' => $id,
            'payment_coin' => 0,
            'sale_limit' => 0,
            'depreciation_support_limit' => 0,
            'get_depreciation_support' => 0,
        ]);
        return $id;
    }

    public function existsWithEmail(mixed $email)
    {
        return $this->userModel::where('email', $email)->exists();
    }

    public function verifyCodeWithEmail($code, $email)
    {
        return $this->userModel::where([['email', $email], ['reset_code', $code]])->exists();
    }

    public function resetPassword($request)
    {
        try {
            $user = $this->userModel::where('email', base64_decode($request->email))->first();
            if (Hash::check($user->reset_code, $request->code)) {
                $user->fill(['password' => Hash::make($request->password), 'reset_code' => null])->save();
                return redirect()
                    ->route('home')
                    ->with('message', ['content' => __('auth.reset_password_success'), 'type' => 'success']);
            }
            return redirect()
                ->route('auth.forgot_password')
                ->with('message', ['content' => __('auth.forgot_code_incorrect'), 'type' => 'error']);
        } catch (\Exception $exception) {
            return back()->with('message', ['content' => __('message.server_error'), 'type' => 'error']);
        }
    }

    /**
     * @throws \Exception
     */
    public function generateResetCodeForEmail($email)
    {
        $code = random_int(0, 999999);
        $this->userModel
            ::where('email', $email)
            ->first()
            ->fill(['reset_code' => $code])
            ->save();
        return $code;
    }

    public function forgotPassword($request)
    {
        try {
            if (!$this->existsWithEmail($request->email)) {
                return back()->with('message', ['content' => __('auth.email_dosent_exists'), 'type' => 'error']);
            }
            $token = Hash::make($request->email);
            $code = $this->generateResetCodeForEmail($request->email);
            $data = ['code' => $code, 'email' => $request->email];
            Mail::to($request->email)->send(new ForgotPasswordMail($data));
            return redirect()->route('auth.verify_forgot_password.form', ['token' => $token, 'email' => base64_encode($request->email)]);
        } catch (\Exception $exception) {
            return back()->with('message', ['content' => __('message.server_error'), 'type' => 'error']);
        }
    }

    public function verifyForgotCode($request)
    {
        try {
            $email = base64_decode($request->email);
            if (!$this->verifyCodeWithEmail($request->code, $email)) {
                return back()->with('msg', ['content' => __('auth.forgot_code_incorrect'), 'type' => 'error']);
            }
            $code = Hash::make($request->code);
            return redirect()->route('auth.reset_password.form', ['token' => $request->token, 'email' => $request->email, 'code' => $code]);
        } catch (\Exception $exception) {
            return back()->with('message', ['content' => __('message.server_error'), 'type' => 'error']);
        }
    }

    public function login($request)
    {
        try {
            $isRemember = $request->remember_account != null;

            if (is_numeric($request->username)) {
                $validator = Validator::make($request->all(), [
                    'username' => 'required|size:10',
                ]);
                if ($validator->fails()) {
                    return back()->withErrors(['username' => __('message.phone_incorrect_format')]);
                }
                $request->merge(['identity' => 'phone']);
            } elseif (filter_var($request->input('username'), FILTER_VALIDATE_EMAIL)) {
                $validator = Validator::make($request->all(), [
                    'username' => 'required|email:rfc,dns',
                ]);
                if ($validator->fails()) {
                    return back()->withErrors(['username' => __('message.email_incorrect_format')]);
                }
                $request->merge(['identity' => 'email']);
            }

            $data = $request->only(['identity', 'password', 'username']);
            if (isset($data['identity']) && $data['identity'] != null) {
                $credient = [$data['identity'] => $data['username'], 'password' => $data['password']];
                if (Auth::attempt($credient, $isRemember)) {
                    $request->session()->regenerate();
                    $apiAuthToken = hash('sha256', Str::random(40) . time() . Auth::id());
                    $user = User::find(Auth::id());
                    $user->update([
                        'api_auth_token' => $apiAuthToken,
                    ]);
                    return redirect()->route('home');
                }
                return back()
                    ->withErrors([
                        'auth_failed' => __('message.login_failed'),
                    ])
                    ->withInput();
            } else {
                return back()->withErrors([
                    'auth_failed' => __('message.no_support_login_method'),
                ]);
            }
        } catch (\Exception $exception) {
            return back()->withErrors([
                'auth_failed' => __('message.server_error'),
            ]);
        }
    }

    public function existsWithPhone($phone)
    {
        return $this->userModel::where('phone', $phone)->exists();
    }
}
