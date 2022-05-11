<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\EditRequest;
use App\Http\Services\Profile\ProfileService;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show(Request $request)
    {
        return $request->user();
    }

    public function update(EditRequest $request)
    {
        $this->profileService->edit($request->user()->id, $request);

        return User::findOrFail($request->user()->id);
    }
}
