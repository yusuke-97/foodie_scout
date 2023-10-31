<?php

namespace App\Console\Commands;

use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;
use DB;

class IndexRestaurants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:index-restaurants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'レストランデータのインデックス化を行う。';

    protected $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->client = app('elasticsearch');
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $restaurants = DB::table('restaurants')->get();

        foreach ($restaurants as $restaurant) {
            $category_name = DB::table('categories')->where('id', $restaurant->category_id)->value('name');
            $restaurant_data = (array) $restaurant;
            $restaurant_data['category'] = $category_name;

            $params = [
                'index' => 'restaurants',
                'id'    => $restaurant->id,
                'body'  => (array) $restaurant_data
            ];
            $this->client->index($params);
        }

        $this->info('All restaurants have been indexed.');
    }
}
