<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
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
        return view('admin.categories.index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.categories.create');
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
            return redirect('/admin/categories/create')
                        ->withErrors($validator)
                        ->withInput();
        }


        $category = new Category();
        $category->shop_id = $this->shop->id;
        $category->category_name = $request->input('category_name');
        $category->category_order = $request->input('category_order');
        $category->save();

        return redirect('/admin/categories')->with('success', 'Category Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // check if category with this id exists
        $category = Category::find($id);
        if (is_null($category) || $category->shop_id != $this->shop->id) {
            return redirect('admin/categories')->with('error', 'Category(' . $id . ') Not Found');
        }
        
        return view('admin.categories.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // check if category with this id exists
        $category = Category::find($id);
        if (is_null($category) || $category->shop_id != $this->shop->id) {
            return redirect('admin/categories')->with('error', 'Category(' . $id . ') Not Found');
        }
        
        return view('admin.categories.edit')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // check if category with this id exists
        $category = Category::find($id);
        if (is_null($category) || $category->shop_id != $this->shop->id) {
            return redirect('admin/categories')->with('error', 'Category(' . $id . ') Not Found');
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
            return redirect('/admin/categories/' . $category->id . '/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        // save
        $category->category_name = $request->input('category_name');
        $category->category_order = $request->input('category_order');
        $category->save();

        return redirect('/admin/categories')->with('success', 'Category Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // check if category with this id exists
        $category = Category::find($id);
        if (is_null($category) || $category->shop_id != $this->shop->id) {
            return redirect('admin/categories')->with('error', 'Category(' . $id . ') Not Found');
        }

        // todo: confirmation and relation to products
        $category->delete();
        return redirect('/admin/categories')->with('success', 'Category Removed');
    }
}
