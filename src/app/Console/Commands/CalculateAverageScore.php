<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Restaurant;
use App\Models\Review;

class CalculateAverageScore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-average-score';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'レストランの平均評価を計算する。';

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
     */
    public function handle()
    {
        $restaurants = Restaurant::all();

        foreach ($restaurants as $restaurant) {
            $average_rating = Review::where('restaurant_id', $restaurant->id)->avg('score');
            $restaurant->average_rating = $average_rating;
            $restaurant->save();
        }

        $this->info('Average ratings have been calculated and saved.');
    }
}
