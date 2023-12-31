<?php

namespace App\Admin\Controllers;

use App\Models\Restaurant;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Extensions\Tools\CsvImport;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
use Illuminate\Http\Request;

class RestaurantController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Restaurant';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Restaurant());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'));
        $grid->column('catchphrase', __('Catchphrase'));
        $grid->column('description', __('Description'));
        $grid->column('price', __('Price'))->sortable();
        $grid->column('seat', __('Seat'));
        $grid->column('postcode', __('Postcode'));
        $grid->column('address', __('Address'));
        $grid->column('prefecture', __('Prefecture'));
        $grid->column('city', __('City'));
        $grid->column('street_address', __('Street Address'));
        $grid->column('nearest_station', __('Nearest Station'));
        $grid->column('phone_number', __('Phone Number'));
        $grid->column('start_time', __('Start Time'));
        $grid->column('end_time', __('End Time'));
        $grid->column('closed_day', __('Closed Day'));
        $grid->column('category_id', __('Category Id'));
        $grid->column('image', __('Image'))->image();
        $grid->column('recommend_flag', __('Recommend Flag'));
        $grid->column('created_at', __('Created At'))->sortable();
        $grid->column('updated_at', __('Updated At'))->sortable();

        $grid->filter(function ($filter) {
            $filter->like('name', '店舗名');
            $filter->like('description', '店舗説明');
            $filter->between('price', '金額');
            $filter->in('category_id', 'カテゴリー')->multipleSelect(Category::all()->pluck('name', 'id'));
            $filter->equal('recommend_flag', 'おすすめフラグ')->select(['0' => 'false', '1' => 'true']);
        });

        $grid->tools(function ($tools) {
            $tools->append(new CsvImport());
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Restaurant::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('catchphrase', __('Catchphrase'));
        $show->field('description', __('Description'));
        $show->field('price', __('Price'));
        $show->field('seat', __('Seat'));
        $show->field('postcode', __('Postcode'));
        $show->field('address', __('Address'));
        $show->field('prefecture', __('Prefecture'));
        $show->field('city', __('City'));
        $show->field('street_address', __('Street Address'));
        $show->field('nearest_station', __('Nearest Station'));
        $show->field('phone_number', __('Phone Number'));
        $show->field('start_time', __('Start Time'));
        $show->field('end_time', __('End Time'));
        $show->field('closed_day', __('Closed Day'));
        $show->field('category_id', __('Category Id'));
        $show->field('image', __('Image'))->image();
        $show->field('recommend_flag', __('Recommend Flag'));
        $show->field('created_at', __('Created At'));
        $show->field('updated_at', __('Updated At'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Restaurant());

        $form->text('name', __('Name'));
        $form->image('image', __('Image'));
        $form->text('catchphrase', __('Catchphrase'));
        $form->textarea('description', __('Description'));
        $form->number('price', __('Price'));
        $form->number('seat', __('Seat'));
        $form->text('postcode', __('Postcode'));
        $form->text('address', __('Address'));
        $form->text('phone_number', __('Phone Number'));
        $form->time('start_time', __('Start Time'));
        $form->time('end_time', __('End Time'));
        $form->text('closed_day', __('Closed Day'));
        $form->number('category_id', __('Category Id'));
        $form->text('prefecture', __('Prefecture'));
        $form->text('city', __('City'));
        $form->text('street_address', __('Street Address'));
        $form->text('nearest_station', __('Nearest Station'));
        $form->switch('recommend_flag', __('Recommend Flag'));

        return $form;
    }

    public function csvImport(Request $request)
    {
        $file = $request->file('file');
        $lexer_config = new LexerConfig();
        $lexer = new Lexer($lexer_config);

        $interpreter = new Interpreter();
        $interpreter->unstrict();

        $rows = array();
        $interpreter->addObserver(function (array $row) use (&$rows) {
            $rows[] = $row;
        });

        $lexer->parse($file, $interpreter);
        foreach ($rows as $key => $value) {

            if (count($value) == 14) {
                Restaurant::create([
                    'name' => $value[0],
                    'description' => $value[1],
                    'price' => $value[2],
                    'seat' => $value[3],
                    'postcode' => $value[4],
                    'address' => $value[5],
                    'prefecture' => $value[6],
                    'city' => $value[7],
                    'street_address' => $value[8],
                    'nearest_station' => $value[9],
                    'phone_number' => $value[10],
                    'category_id' => $value[11],
                    'image' => $value[12],
                    'recommend_flag' => $value[13],
                ]);
            }
        }

        return response()->json(
            ['data' => '成功'],
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}
