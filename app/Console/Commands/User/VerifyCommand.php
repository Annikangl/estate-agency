<?php

namespace App\Console\Commands\User;

use App\Http\Services\Auth\RegisterService;
use App\Models\User;
use Illuminate\Console\Command;

class VerifyCommand extends Command
{
    protected $signature = 'user:verify {email}';

    protected $description = 'Command fot verify user by email';

    private RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        parent::__construct();
        $this->registerService = $registerService;
    }

    public function handle(): bool
    {
        $email = $this->argument('email');

        if (!$user = User::where('email', $email)->first()) {
            $this->error('User not found by email ' . $email);
            return  false;
        }

        try {
            $this->registerService->verify($user->id);
        } catch (\DomainException $exception) {
            $this->error($exception->getMessage());
            return false;
        }

        $this->info('User verified successful');
        return true;
    }
}
