<?php

namespace App\Console\Commands;

use App\Repositories\Frontend\Auth\UserRepository;
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
        $users = $this->userRepository->getAllUsers();
        foreach ($users as $user) {
            if ($user->blog != null) {
                $originFeed = \Feeds::make([$user->blog], 0, false);
            }
            echo "Updated blog feed for " . $user->full_name . "\n";
        }

        echo "Done caching blog feeds.";
        return $this;
    }
}
