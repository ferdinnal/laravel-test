<?php

namespace App\Actions;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;

class LoginUser
{
    use AsAction;
    public function handle(LoginRequest $loginRequest)
    {
        $loginRequest->authenticate();
        $loginRequest->session()->regenerate();
        return redirect()->intended(RouteServiceProvider::HOME);
    }
    public function rules()
    {
        return [
            'email' => ['required'],
            'password' => ['required'],
        ];
    }
}
