<?php
namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

/**
 * Class CreatePersonalAccessToken
 * @package App\Console\Commands
 */
class CreatePersonalAccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gateway:personal-access-token:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create personal access token.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var User $user */
        $user = User::find($this->ask('User-ID'));

        $token = $user->createToken(
            $this->ask('Token-Name'),
            explode(',', $this->ask('Scopes (scope1,scope2, ...)'))
        )->accessToken;

        $this->line('Token:');
        $this->line($token);
    }
}
