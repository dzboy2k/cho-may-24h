<?php

namespace App\Repositories\Authentication;

interface AuthenticationInterface
{
    public function register($request);

    public function existsWithEmail(mixed $email);

    public function verifyCodeWithEmail($code, $email);

    public function resetPassword($request);

    public function generateResetCodeForEmail($email);
    public function forgotPassword($request);
    public function verifyForgotCode($request);

    public function login($request);
    public function existsWithPhone($phone);
}
