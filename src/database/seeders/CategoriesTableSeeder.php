<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $major_category_names = [
            '和食', '洋食', '中華', '韓国料理'
        ];

        $japanese_foods = [
            '寿司', '天ぷら', 'うどん', 'お好み焼き'
        ];

        $western_foods = [
            'ハンバーグ', 'パスタ', 'ピザ', 'オムライス'
        ];

        $chinese_foods = [
            '火鍋', '餃子', '飲茶・点心', '小籠包'
        ];

        $korean_foods = [
            'サムギョプサル', '冷麺', 'タッカルビ', 'チヂミ'
        ];

        foreach ($major_category_names as $major_category_name) {
            if ($major_category_name == '和食') {
                foreach ($japanese_foods as $japanese_food) {
                    Category::create([
                        'name' => $japanese_food,
                        'description' => $japanese_food,
                        'major_category_name' => $major_category_name
                    ]);
                }
            }

            if ($major_category_name == '洋食') {
                foreach ($western_foods as $western_food) {
                    Category::create([
                        'name' => $western_food,
                        'description' => $western_food,
                        'major_category_name' => $major_category_name
                    ]);
                }
            }

            if ($major_category_name == '中華') {
                foreach ($chinese_foods as $chinese_food) {
                    Category::create([
                        'name' => $chinese_food,
                        'description' => $chinese_food,
                        'major_category_name' => $major_category_name
                    ]);
                }
            }

            if ($major_category_name == '韓国料理') {
                foreach ($korean_foods as $korean_food) {
                    Category::create([
                        'name' => $korean_food,
                        'description' => $korean_food,
                        'major_category_name' => $major_category_name
                    ]);
                }
            }
        }
    }
}
