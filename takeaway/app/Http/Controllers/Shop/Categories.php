<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * can be used by both site-admin and shop-admin controller
 * must instance shop object in constructor
 */
trait Categories
{
    /**
     * @return App\Shop
     */
    abstract protected function shop();

    /**
     * @return String
     */
    abstract protected function template_prefix();

    /**
     * @return String
     */
    abstract protected function route_prefix();

    /**
     * @param String | index,create,edit
     * @return String
     */
    private function template($name)
    {
        return $this->template_prefix() . 'categories.' . $name;
    }

    /**
     * @param String | index,create,edit
     * @param Integer
     * @return String
     */
    private function route($name, $category_id = null)
    {
        $route_name = $this->route_prefix() . 'categories.' . $name;
        $parameters = ['shop' => $this->shop()->id];
        is_null($category_id) ?: $parameters['category'] = $category_id;

        return route($route_name, $parameters);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('shop_id', $this->shop()->id)
            ->orderBy('category_order', 'asc')
            ->get();
        return view($this->template('index'))
            ->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $max_order = Category::where('shop_id', $this->shop()->id)->max('category_order') ?: 0;
        return view($this->template('create'))
            ->with('category_order', $max_order + 1);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // input validate
        $validator = Validator::make($request->all(), [
            'category_name' => [
                'required',

                // must unique within shop
                Rule::unique('categories')->where(function($query) {
                    return $query->where('shop_id', $this->shop()->id);
                })
            ],
            'category_order' => 'integer',
        ]);

        if ($validator->fails()) {
            return redirect($this->route('create'))
                        ->withErrors($validator)
                        ->withInput();
        }


        $category = new Category();
        $category->shop_id = $this->shop()->id;
        $category->category_name = $request->input('category_name');
        $category->category_desc = $request->input('category_desc');
        $category->category_order = $request->input('category_order');
        $category->save();

        return redirect($this->route('index'))->with('success', 'Category Created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($shop_id, $id)
    {
        // check if category with this id exists
        $category = Category::find($id);
        if (is_null($category) || $category->shop_id != $this->shop()->id) {
            return redirect($this->route('index'))
                ->with('error', 'Category(' . $id . ') Not Found');
        }
        
        return view($this->template('edit'))->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $shop_id, $id)
    {
        // check if category with this id exists
        $category = Category::find($id);
        if (is_null($category) || $category->shop_id != $this->shop()->id) {
            return redirect($this->route('index'))
                ->with('error', 'Category(' . $id . ') Not Found');
        }

        // input validate
        $validator = Validator::make($request->all(), [
            'category_name' => [
                'required',

                // must unique within shop
                Rule::unique('categories')->where(function($query) {
                    return $query->where('shop_id', $this->shop()->id);
                })->ignore($category->id)
            ],
            'category_order' => 'integer',
        ]);

        if ($validator->fails()) {
            return redirect($this->route('edit', $category->id))
                        ->withErrors($validator)
                        ->withInput();
        }

        // save
        $category->category_name = $request->input('category_name');
        $category->category_desc = $request->input('category_desc');
        $category->category_order = $request->input('category_order');
        $category->save();

        return redirect($this->route('index'))
            ->with('success', 'Category Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($shop_id, $id)
    {
        // check if category with this id exists
        $category = Category::find($id);
        if (is_null($category) || $category->shop_id != $this->shop()->id) {
            return redirect($this->route('index'))
                ->with('error', 'Category(' . $id . ') Not Found');
        }

        // todo: confirmation and relation to products
        $category->delete();
        return redirect($this->route('index'))
            ->with('success', 'Category Removed');
    }
}