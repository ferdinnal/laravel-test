<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUserProfile
{
    use AsAction;

    public function asController(Request $request)
    {
        $user = $request->user();
        return view('profile.edit', compact('user'));
    }
}
