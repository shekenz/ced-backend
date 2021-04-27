<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\UsersController;

class Invite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invite {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends an register invitation to the email';

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
     * @return int
     */
    public function handle()
    {
        UsersController::inviteByMail($this->argument('email'));
		$this->info('Invitation mail sent to '.$this->argument('email'));
    }
}
