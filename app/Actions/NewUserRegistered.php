<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Support\Facades\Hash;


class NewUserRegistered
{
    use AsAction;
    public function handle(string $name, string $email, string $password)
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed'],
        ];
    }
    public function asController(Request $request)
    {
        $this->handle(
            $request->get('name'),
            $request->get('email'),
            $request->get('password')
        );

        return redirect()->route('login');
    }
}
