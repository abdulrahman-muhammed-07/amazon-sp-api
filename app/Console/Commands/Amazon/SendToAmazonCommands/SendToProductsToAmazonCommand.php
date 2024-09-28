<?php

namespace App\Console\Commands\Amazon\SendToAmazonCommands;

use App\Jobs\Amazon\SendToAmazonJobs\SendProductsToAmazon;
use App\Models\User;
use Illuminate\Console\Command;


class SendToProductsToAmazonCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:amazon';

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

            dispatch(new SendProductsToAmazon($user));

        }
    }
}
