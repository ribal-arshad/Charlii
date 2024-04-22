<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserForgotPasswordRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserResetPasswordRequest;
use App\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(){
        return view('authentication.login');
    }

    public function loginData(UserLoginRequest $request){
        return $this->userRepository->loginAttempt($request);
    }

    public function forgotPassword(){
        return view('authentication.forgot-password');
    }

    public function forgotPasswordData(UserForgotPasswordRequest $request){
        return $this->userRepository->submitForgotPasswordReq($request);
    }

    public function resetPassword($token){
        $user = $this->userRepository->checkResetToken($token);
        if(!empty($user)){
            return view('authentication.reset-password', compact('user'));
        }
        abort(404);
    }

    public function resetPasswordData($token, UserResetPasswordRequest $request){
        return $this->userRepository->resetPasswordReq($token, $request);
    }

    public function logout(){
        return $this->userRepository->logout();
    }
}
