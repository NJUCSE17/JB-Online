<?php

namespace App\Console\Commands;

use App\Models\Forum\BlogFeed;
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
        BlogFeed::query()->truncate();
        $users = $this->userRepository->getAllUsers();
        foreach ($users as $user) {
            if ($user->blog != null) {
                $originFeed = \Feeds::make([$user->blog], 0, false);
                if (count($originFeed->get_items())) {
                    $items = $originFeed->get_items();
                    foreach ($items as $item) {
                        //$description = $item->get_description();
                        //$regex = '/(<[^>]+>)/is';
                        //$content = preg_replace($regex, '', $description);

                        $date = \Carbon\Carbon::parse($item->get_date());
                        BlogFeed::query()->create([
                            'permalink'   => $item->get_permalink(),
                            'title'       => $item->get_title(),
                            'content'     => \Purifier::clean($item->get_content()),
                            'author'      => $user->full_name,
                            'avatar'      => $user->picture,
                            'date'        => $date,
                        ]);
                    }

                    echo "[success] " . $user->id . " - " . $user->full_name
                        . " [" . count($originFeed->get_items()) . " posts]\n";
                } else {
                    echo "[failure] " . $user->id . " - " . $user->full_name . "\n";
                }
            } else {
                echo "[skipped] " . $user->id . " - " . $user->full_name . "\n";
            }
        }

        echo "Done caching blog feeds.\n";
        return $this;
    }
}
