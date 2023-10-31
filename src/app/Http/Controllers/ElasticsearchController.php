<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ElasticsearchController extends Controller
{
    public function search(Request $request)
    {
        $client = app('elasticsearch');

        $area = $request->input('area');
        $category = $request->input('category');
        $visit_date = $request->input('visit_date');
        $visit_time = $request->input('visit_time');
        $number_of_guests = $request->input('number_of_guests');

        $params = [
            'index' => 'restaurants',
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => []
                    ]
                ]
            ]
        ];

        if ($area) {
            $params['body']['query']['bool']['must'][] = [
                'bool' => [
                    'should' => [
                        ['match' => ['nearest_station' => $area]],
                        ['match' => ['address' => $area]]
                    ]
                ]
            ];
        }

        if ($category) {
            $params['body']['query']['bool']['must'][] = ['match' => ['category' => $category]];
        }

        $response = $client->search($params);

        $restaurants = $response['hits']['hits'];

        $available_restaurants = collect($restaurants)->filter(function ($restaurant) use ($visit_date, $visit_time, $number_of_guests) {
            $end_time = date('H:i', strtotime($visit_time . ' +1 hour 30 minutes'));

            $already_reserved_guests = DB::table('reservations')
            ->where('restaurant_id', $restaurant['_id'])
                ->where('visit_date', $visit_date)
                ->whereBetween('end_time', [$visit_time, $end_time])
                ->sum('number_of_guests');

            return $restaurant['_source']['seat'] - $already_reserved_guests >= $number_of_guests;
        });

        return view('restaurants.search', [
            'results' => $available_restaurants,
            'area' => $area,
            'category' => $category
        ]);
    }
}