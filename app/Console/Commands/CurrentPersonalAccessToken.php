<?php
namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Laravel\Passport\Token;

/**
 * Class CurrentPersonalAccessToken
 * @package App\Console\Commands
 */
class CurrentPersonalAccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gateway:personal-access-token:current';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the current personal access tokens.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var User $user */
        $user = User::find($this->ask('User-ID'));

        $headers = ['id', 'user_id', 'client_id', 'name', 'scopes'];

        $values = [];

        foreach ($user->tokens()->getResults() as $token) {
            /** @var Token $token */
            $values[] = [
                $token->getAttribute('id'),
                $token->getAttribute('user_id'),
                $token->getAttribute('client_id'),
                $token->getAttribute('name'),
                implode(',', $token->getAttribute('scopes'))
            ];
        }

        $this->table($headers, $values);
    }
}
