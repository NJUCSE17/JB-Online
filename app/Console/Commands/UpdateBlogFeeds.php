<?php

namespace App\Console\Commands;

use App\Models\BlogFeed;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Mews\Purifier\Purifier;
use willvincent\Feeds\FeedsFactory;

class UpdateBlogFeeds extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:update_blog_feeds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update and cache blog feeds.';

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
     * @return mixed
     */
    public function handle()
    {
        BlogFeed::query()->truncate();

        $users = User::all();
        foreach ($users as $user) {
            if ($user->blog_feed_url != null) {
                $items = \Feeds::make($user->blog_feed_url, 15)->get_items();
                if (count($items)) {
                    foreach ($items as $item) {
                        BlogFeed::query()->create([
                            'user_id'      => $user->id,
                            'user_name'    => $user->name,
                            'permalink'    => $item->get_permalink(),
                            'title'        => $item->get_title(),
                            'content_html' => clean($item->get_content()),
                            'published_at' => Carbon::parse($item->get_date()),
                        ]);
                    }
                    echo "[Success] ".$user->id." - ".$user->name
                        ." [".count($items)." posts]\n";
                } else {
                    echo "[Failure] ".$user->id." - ".$user->name."\n";
                }
            } else {
                echo "[Skipped] ".$user->id." - ".$user->name."\n";
            }
        }
        echo "Done caching blog feeds.\n";
    }
}
