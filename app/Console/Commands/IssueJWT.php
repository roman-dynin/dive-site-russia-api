<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

/**
 * Class IssueToken
 *
 * @package App\Console\Commands
 */
class IssueJWT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jwt:issue {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Issue JWT for user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $userId = (int)$this->argument('user_id');

        /**
         * @var \Illuminate\Contracts\Auth\Authenticatable $user
         */
        $user = User::query()->find($userId);

        if ($user) {
            $token = auth()->login($user);

            $this->info($token);
        } else {
            $this->error('User #'.$userId.' not found');
        }
    }
}
