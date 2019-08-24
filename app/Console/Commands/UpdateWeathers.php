<?php

namespace App\Console\Commands;

use App\Helpers\HeWeather;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateWeathers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:update_weathers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update weather info for users.';

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
        $users = User::all();
        foreach ($users as $user) {
            $weather = $user->weather;
            if (!isset($weather->update) || Carbon::parse($weather->update->loc)->isBefore(now()->subHours(3))) {
                $weather = HeWeather::getWeather("forecast", $user->last_login_ip);
                if ($weather->status === "ok") {
                    echo "[Success] ".$user->id." - ".$user->name." ".$weather->status."\n";
                } else {
                    echo "[Failure] ".$user->id." - ".$user->name." ".$weather->status."\n";
                }
                $user->weather = json_encode($weather);
                $user->save();
            } else {
                echo "[Skipped] ".$user->id." - ".$user->name."\n";
            }
        }

        echo "Done updating weather info for users.\n";
        return 0;
    }
}
