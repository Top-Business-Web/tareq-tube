<?php

namespace App\Console\Commands;

use App\Models\YoutubeKey;
use Carbon\Carbon;
use Illuminate\Console\Command;

class resetApiKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:apikey';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset The API Key';

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
        $day = Carbon::now();
        YoutubeKey::query()
            ->whereDate('created_at', '<', $day)
            ->update([
                'limit' => 0,
                'created_at' => $day
            ]);
    }
}
