<?php

namespace Tests\Auth\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testForm()
    {
        $response = $this->get('/login');

        $response
            ->assertStatus(200)
            ->assertSee('Логин');
    }

    public function testErrors(): void
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => ''
        ]);

        $response
            ->assertStatus(302)
            ->assertSessionHasErrors(['email','password']);
    }

    public function testVerifyUser(): void
    {
        $user = User::factory()->create(['status' => User::STATUS_WAIT]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect('/')
            ->assertSessionHas('error', 'Вам нужно подтвердить регистрацию. Пожалуйста, проверьте вашу электронную почту');
    }

    public function testNotVerifyUser(): void
    {
        $user = User::factory()->create(['status' => User::STATUS_ACTIVE]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect('/cabinet/home');

        $this->assertAuthenticated();
    }
}
