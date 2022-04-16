<?php

namespace Tests\Unit\Entity\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    public function testRequest()
    {
        $user = User::register(
            $name = 'name',
            $email = 'test@ex.com',
            $password = 'test123'
         );

        self::assertNotEmpty($user);

        self::assertEquals($name, $user->name);
        self::assertEquals($email, $user->email);
        self::assertNotEmpty($user->password);
        self::assertNotEquals($password, $user->password);

        self::assertTrue($user->isWait());
        self::assertFalse($user->isActive());
        self::assertFalse($user->isAdmin());
    }

    public function testVerify(): void
    {
        $user = User::register('name','email','password');

        $user->verify();

        self::assertTrue($user->isWait());
        self::assertFalse($user->isActive());
        self::assertFalse($user->isAdmin());
    }

    public function testAlreadyVerified(): void
    {
        $user = User::register('name','email','password');

        $user->verify();

        $this->expectExceptionMessage('User is already verified');
        $user->verify();
    }
}
