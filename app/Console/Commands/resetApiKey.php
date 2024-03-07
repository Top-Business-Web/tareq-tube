<?php

namespace App\Console\Commands;

use App\Models\YoutubeKey;
use App\Models\YoutubeKeyEach;
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
        $day = Carbon::now()->subDay(); // Subtract 24 hours

        $each = YoutubeKeyEach::query()
            ->whereDate('created_at', '<', $day)
            ->select('key_id')
            ->groupBy('key_id');

        $each_counts_by_key_id = $each->select('key_id', \DB::raw('count(*) as count'))->get()->toArray();
        $arr = [];
        // $each_counts_by_key_id is an array where each element has 'key_id' and 'count'
        foreach ($each_counts_by_key_id as $index => $count_by_key_id) {
            $arr[$index]['key_id'] = $count_by_key_id['key_id'];
            $arr[$index]['count'] = $count_by_key_id['count'];
        }

        foreach ($arr as $value) {
            $youtubeKey = YoutubeKey::query()
                ->where('id', '=', $value['key_id'])->first();
            $youtubeKey->limit -= $value['count'];
            $youtubeKey->save();
        }

        $each->delete();

    }
}
