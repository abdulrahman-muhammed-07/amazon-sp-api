<?php

namespace App\Console\Commands\Amazon\GetFromAmazonCommands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Jobs\Amazon\GetFromAmazonJobs\GetAllProductTypesSchemesJob;

class GetAllProductTypesSchemesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::get();

        foreach ($users as $user) {
            dispatch(new GetAllProductTypesSchemesJob($user));
        }
    }
}
