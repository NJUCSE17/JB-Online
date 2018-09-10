<?php

namespace App\Console\Commands;

use App\Repositories\Frontend\Auth\UserRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forum:updatefeeds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache blog feeds.';

    /**
     * @var UserRepository $userRepository
     */
    protected $userRepository;

    /**
     * Create a new command instance.
     *
     * @param UserRepository $userRepository
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Caching blog feeds at " . Carbon::now() . "\n";
        echo "Start caching blog feeds. \n";
        $users = $this->userRepository->getAllUsers();
        foreach ($users as $user) {
            if ($user->blog != null) {
                $originFeed = \Feeds::make([$user->blog], 0, false);
                echo "Updated blog feed for " . $user->full_name . "... ";
                if (count($originFeed->get_items())) {
                    echo "success.\n";
                } else {
                    echo "failed.\n";
                }
            } else {
                echo "Skipping for " . $user->full_name . "\n";
            }
        }

        echo "Done caching blog feeds.\n";
        return $this;
    }
}
