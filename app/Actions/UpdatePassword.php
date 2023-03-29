<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePassword
{
    use AsAction;

    public function handle(User $user, string $newPassword)
    {
        $user->password = Hash::make($newPassword);
        $user->save();
    }
    public function rules()
    {
        return [
            'current_password' => ['required'],
            'password' => ['required', 'confirmed'],
        ];
    }

    public function withValidator(Validator $validator, ActionRequest $request)
    {
        $validator->after(function (Validator $validator) use ($request) {
            if (!Hash::check($request->get('current_password'), $request->user()->password)) {
                $validator->errors()->add('current_password', 'The current password does not match.');
            }
        });
    }

    public function asController(ActionRequest $request)
    {
        $this->handle(
            $request->user(),
            $request->get('password')
        );

        return back()->with('status', 'password-updated');
    }
}
