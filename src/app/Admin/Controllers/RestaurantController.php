<?php

namespace App\Admin\Controllers;

use App\Models\Restaurant;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        $grid->filter(function ($filter) {
            $filter->like('name', '店舗名');
            $filter->like('description', '店舗説明');
            $filter->between('price', '金額');
            $filter->in('category_id', 'カテゴリー')->multipleSelect(Category::all()->pluck('name', 'id'));
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

        return $form;
    }
}
