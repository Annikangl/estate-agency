<?php

namespace Tests\Unit\Entity\User;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class CreateTest extends TestCase
{
    public function testNew(): void
    {
        $user = User::new(
            $name = 'name',
            $email = 'email'
        );

        self::assertNotEmpty($user);
        self::assertEquals($name, $user->name);
        self::assertEquals($email, $user->email);
        self::assertEquals($email, $user->password);

        self::assertTrue($user->isActive());
        self::assertFalse($user->isAdmin());
    }
}
