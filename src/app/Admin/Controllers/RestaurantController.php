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
        $grid->column('description', __('Description'));
        $grid->column('price', __('Price'))->sortable();
        $grid->column('seat', __('Seat'));
        $grid->column('postcode', __('Postcode'));
        $grid->column('address', __('Address'));
        $grid->column('prefecture', __('Prefecture'));
        $grid->column('city', __('City'));
        $grid->column('street_address', __('Street address'));
        $grid->column('nearest_station', __('Nearest station'));
        $grid->column('phone_number', __('Phone number'));
        $grid->column('category.name', __('Category Name'));
        $grid->column('image', __('Image'))->image();
        $grid->column('recommend_flag', __('Recommend Flag'));
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

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
        $show->field('description', __('Description'));
        $show->field('price', __('Price'));
        $show->field('seat', __('Seat'));
        $show->field('postcode', __('Postcode'));
        $show->field('address', __('Address'));
        $show->field('prefecture', __('Prefecture'));
        $show->field('city', __('City'));
        $show->field('street_address', __('Street address'));
        $show->field('nearest_station', __('Nearest station'));
        $show->field('phone_number', __('Phone number'));
        $show->field('category.name', __('Category Name'));
        $show->field('image', __('Image'))->image();
        $show->field('recommend_flag', __('Recommend Flag'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

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
        $form->textarea('description', __('Description'));
        $form->number('price', __('Price'));
        $form->number('seat', __('Seat'));
        $form->text('postcode', __('Postcode'));
        $form->text('address', __('Address'));
        $form->text('phone_number', __('Phone number'));
        $form->select('category_id', __('Category Name'))->options(Category::all()->pluck('name', 'id'));
        $form->text('prefecture', __('Prefecture'));
        $form->text('city', __('City'));
        $form->text('street_address', __('Street address'));
        $form->text('nearest_station', __('Nearest station'));
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
