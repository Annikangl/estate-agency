<?php


namespace App\Http\Services\Profile;


use App\Http\Requests\Profile\EditRequest;
use App\Models\User;

class ProfileService
{
    public function edit($id, EditRequest $request)
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        $oldPhone = $user->phone;

        $user->update($request->only('name','last_name','phone'));

        if ($user->phone !== $oldPhone) {
            $user->unverifyPhone();
        }
    }


}
