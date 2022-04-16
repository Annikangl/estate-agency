<?php

namespace Tests\Unit\Entity\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    use DatabaseTransactions;

    public function test_default()
    {
        $user = User::factory()->create([
            'phone' => null,
            'phone_verified' => false,
            'phone_verify_token' => null
        ]);

        self::assertFalse($user->isPhoneVerified());
    }

    public function test_request_empty_phone()
    {
        $user = User::factory()->create([
            'phone' => null,
            'phone_verified' => false,
            'phone_verify_token' => null
        ]);

        $this->expectExceptionMessage('Поле с номером телефона пустое');
        $user->requestPhoneVerification(Carbon::now());
    }

    public function test_request(): void
    {
        $user = User::factory()->create([
            'phone' => 380710000000,
            'phone_verified' => false,
            'phone_verify_token' => null
        ]);

        $token = $user->requestPhoneVerification(Carbon::now());

        self::assertFalse($user->isPhoneVerified());
        self::assertNotEmpty($token);
    }
}
