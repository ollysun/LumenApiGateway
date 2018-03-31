<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Passport\Token;

/**
 * Class DeletePersonalAccessToken
 * @package App\Console\Commands
 */
class DeletePersonalAccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gateway:personal-access-token:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete personal access token.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var Token $token */
        $token = Token::find($this->ask('Token-ID'));

        if ($token) {
            try {
                $token->delete();
            } catch (\Exception $e) {
                $this->error(
                    sprintf("Token was not deleted: %s", $e->getMessage())
                );
            }
        } else {
            $this->error("Token not found");
        }
    }
}
