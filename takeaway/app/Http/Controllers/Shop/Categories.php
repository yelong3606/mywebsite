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
     * current shop object
     * @var App\Shop
     */
    protected $shop;
    
    /**
     * template prefix
     * @var String
     */
    protected $template_prefix = 'manage.shop.categories.';

    /**
     * route prefix
     * @var String
     */
    protected $route_prefix = 'manage.categories.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('shop_id', $this->shop->id)
            ->orderBy('category_order', 'asc')
            ->get();
        return view($this->template_prefix . 'index')
            ->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $max_order = Category::where('shop_id', $this->shop->id)->max('category_order') ?: 0;
        return view($this->template_prefix .'create')
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
                    return $query->where('shop_id', $this->shop->id);
                })
            ],
            'category_order' => 'integer',
        ]);

        if ($validator->fails()) {
            return redirect()->route($this->route_prefix . 'create', ['shop' => $this->shop->id])
                        ->withErrors($validator)
                        ->withInput();
        }


        $category = new Category();
        $category->shop_id = $this->shop->id;
        $category->category_name = $request->input('category_name');
        $category->category_desc = $request->input('category_desc');
        $category->category_order = $request->input('category_order');
        $category->save();

        return redirect()->route($this->route_prefix . 'index', ['shop' => $this->shop->id])->with('success', 'Category Created');
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
        if (is_null($category) || $category->shop_id != $this->shop->id) {
            return redirect()->route($this->route_prefix . 'index', ['shop' => $this->shop->id])
                ->with('error', 'Category(' . $id . ') Not Found');
        }
        
        return view($this->template_prefix . 'edit')->with('category', $category);
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
        if (is_null($category) || $category->shop_id != $this->shop->id) {
            return redirect()->route($this->route_prefix . 'index', ['shop' => $this->shop->id])
                ->with('error', 'Category(' . $id . ') Not Found');
        }

        // input validate
        $validator = Validator::make($request->all(), [
            'category_name' => [
                'required',

                // must unique
                Rule::unique('categories')->ignore($category->id)
            ],
            'category_order' => 'integer',
        ]);

        if ($validator->fails()) {
            return redirect()->route($this->route_prefix . 'edit', ['shop' => $this->shop->id, 'category' => $category->id])
                        ->withErrors($validator)
                        ->withInput();
        }

        // save
        $category->category_name = $request->input('category_name');
        $category->category_desc = $request->input('category_desc');
        $category->category_order = $request->input('category_order');
        $category->save();

        return redirect()->route($this->route_prefix . 'index', ['shop' => $this->shop->id])
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
        if (is_null($category) || $category->shop_id != $this->shop->id) {
            return redirect()->route($this->route_prefix . 'index', ['shop' => $this->shop->id])
                ->with('error', 'Category(' . $id . ') Not Found');
        }

        // todo: confirmation and relation to products
        $category->delete();
        return redirect()->route($this->route_prefix . 'index', ['shop' => $this->shop->id])
            ->with('success', 'Category Removed');
    }
}