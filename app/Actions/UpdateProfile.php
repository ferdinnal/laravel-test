<?php

namespace App\Actions;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateProfile
{
    use AsAction;

    public function handle(User $user, string $name, string $email)
    {
        $user->name = $name;
        $user->email = $email;
        $user->save();
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
        ];
    }
    public function asController(ProfileUpdateRequest $request)
    {
        $this->handle(
            $request->user(),
            $request->get('name'),
            $request->get('email'),
        );

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}
