<?php

namespace App\Console\Commands;

use Cone\Laravel\Auth\Interfaces\Models\AuthCode;
use Illuminate\Console\Command;

class ClearExpiredAuthCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:clear-expired-auth-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the expired auth codes';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $count = $this->laravel->make(AuthCode::class)->newQuery()->expired()->delete();

        $this->info(sprintf('%d auth codes were deleted!', $count));
    }
}
