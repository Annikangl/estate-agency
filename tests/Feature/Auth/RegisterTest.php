<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_example()
    {
        $response = $this->get('/register');

        $response
            ->assertStatus(200)
            ->assertSee('Регистрация');
    }

    public function testErrors(): void
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => '',
            'password' => ''
        ]);

        $response
            ->assertStatus(302)
            ->assertSessionHasErrors(['name','email','password']);
    }

    public function testSuccess(): void
    {
        $user = User::factory()->make();

        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect('/login')
            ->assertSessionHas('success', 'Проверьте вашу электронную почту и подтвердите регистрацию');
    }

    public function testVerifyIncorrect(): void
    {
        $response = $this->get('/verify/', Str::uuid());

        $response
            ->assertStatus(302)
            ->assertRedirect('/login')
            ->assertSessionHas('error','Ваша ссылка недейсвтительна');
    }

    public function testVerify(): void
    {
        $user = User::factory()->create([
            'status' => User::STATUS_WAIT,
            'verify_code' => Str::uuid()
        ]);

        $response = $this->get('/verify/' . $user->verify_code);

        $response
            ->assertStatus(302)
            ->assertRedirect('/login')
            ->assertSessionHas('success','Ваша почта подтверждена!');
    }
}
