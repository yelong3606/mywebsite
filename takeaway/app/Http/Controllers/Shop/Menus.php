<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Menu;
use App\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * can be used by both site-admin and shop-admin controller
 * must instance shop object in constructor
 */
trait Menus
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
        return $this->template_prefix() . 'menus.' . $name;
    }

    /**
     * @param String | index,create,edit
     * @param Integer
     * @return String
     */
    private function route($name, $menu_id = null)
    {
        $route_name = $this->route_prefix() . 'menus.' . $name;
        $parameters = ['shop' => $this->shop()->id];
        is_null($menu_id) ?: $parameters['menu'] = $menu_id;

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
        $indexedCategories = array();
        foreach ($categories as $category) {
            $indexedCategories[$category->id] = $category->category_name;
        }

        $menus = Menu::where('shop_id', $this->shop()->id)
            ->orderBy('menu_order', 'asc')
            ->get();
        $indexedMenus = array();
        foreach ($menus as $menu) {
            if (isset($categories[$menu->category_id])) {
                $indexedMenus[$menu->category_id][] = $menu;
            } else {
                // not belong to any category
                $indexedMenus[0][] = $menu;
            }
        }

        if (isset($indexedMenus[0])) {
            $indexedCategories[0] = 'Ghost Category';
        }

        return view($this->template('index'))
            ->with('categories', $indexedCategories)
            ->with('menus', $indexedMenus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->template('create'))
            ->with('categories', $this->categories());
    }

    private function categories()
    {
        return Category::where('shop_id', $this->shop->id)
            ->orderBy('category_order', 'asc')
            ->get();
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
            'title' => [
                'required',
            ],
        ]);

        if ($validator->fails()) {
            return redirect($this->route('create'))
                        ->withErrors($validator)
                        ->withInput();
        }

        $menu = new Menu();
        $menu->shop_id = $this->shop()->id;
        $this->set_menu($menu, $request);
        $menu->save();

        return redirect($this->route('index'))->with('success', 'Menu Created');
    }

    private function set_menu($menu, $request) {
        $menu->title = $request->input('title');
        $menu->description = $request->input('description');
        $menu->category_id = $request->input('category_id') ?: 0;
        if ($request->input('has_variants')) {
            $menu->price = 0;

            $variant_names = $request->input('variant_name');
            $variant_prices = $request->input('variant_price');
            $variants = array();
            for ($i = 0; $i < count($variant_names); $i++) {
                $name = trim($variant_names[$i]);
                $price = number_format($variant_prices[$i], 2);
                if ($name) {
                    $variants[] = array(
                        'name' => $name,
                        'price' => $price
                    );
                }
            }

            // only one valid variant
            if (count($variants) == 1) {
                $menu->price = $variants[0]['price'];
                $variants = array();
            }
        } else {
            $menu->price = $request->input('price');
            $variants = array();
        }
        $menu->main_option = json_encode($variants);
        $menu->side_options = json_encode(array());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($shop_id, $id)
    {
        // check if menu with this id exists
        $menu = Menu::find($id);
        if (is_null($menu) || $menu->shop_id != $this->shop()->id) {
            return redirect($this->route('index'))
                ->with('error', 'Menu(' . $id . ') Not Found');
        }
        
        return view($this->template('edit'))
            ->with('menu', $menu)
            ->with('categories', $this->categories());
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
        // check if menu with this id exists
        $menu = Menu::find($id);
        if (is_null($menu) || $menu->shop_id != $this->shop()->id) {
            return redirect($this->route('index'))
                ->with('error', 'Menu(' . $id . ') Not Found');
        }

        // input validate
        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
            ],
        ]);

        if ($validator->fails()) {
            return redirect($this->route('edit', $menu->id))
                        ->withErrors($validator)
                        ->withInput();
        }

        // save
        $this->set_menu($menu, $request);
        $menu->save();

        return redirect($this->route('index'))
            ->with('success', 'Menu Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($shop_id, $id)
    {
        // check if menu with this id exists
        $menu = Menu::find($id);
        if (is_null($menu) || $menu->shop_id != $this->shop()->id) {
            return redirect($this->route('index'))
                ->with('error', 'Menu(' . $id . ') Not Found');
        }

        // todo: confirmation and relation to menus
        $menu->delete();
        return redirect($this->route('index'))
            ->with('success', 'Menu Removed');
    }
}