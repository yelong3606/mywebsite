<?php

namespace App\Http\Controllers\Site\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shop;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ShopsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // search conditions
        $conditions = [];
        if ($request->filled('id')) {
            array_push($conditions, ['id', $request->id]);
        }
        if ($request->filled('shop_name')) {
            array_push($conditions, ['shop_name', 'like', '%' . $request->shop_name . '%']);
        }
        if ($request->filled('shop_domain')) {
            array_push($conditions, ['shop_domain', 'like', '%' . $request->shop_domain . '%']);
        }

        // query
        $shops = Shop::where($conditions)
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('site.admin.shops.index')->with('shops', $shops);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('site.admin.shops.create');
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
            'shop_name' => array(
                'required',
                'alpha_dash',
                'unique:shops'
            ),
        ]);
        $validator->sometimes('shop_domain', 'unique:shops', function($input) {
            return !empty($input->shop_domain);
        });

        if ($validator->fails()) {
            return redirect(route('shops.create'))
                        ->withErrors($validator)
                        ->withInput();
        }

        $shop = new Shop();
        $shop->shop_name = $request->input('shop_name');
        $shop_domain = $request->input('shop_domain');
        if ($shop_domain == '') {
            $shop->shop_domain = $shop->shop_name . '.' . config('app.domain');
        } else {
            $shop->shop_domain = $shop_domain;
        }

        $shop->is_open = $request->input('is_open');
        $shop->created_on = $request->input('created_on');
        $shop->expire_on = $request->input('expire_on');
        $shop->save();

        return redirect(route('shops.index'))->with('success', 'Shop Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shop = Shop::find($id);
        if (is_null($shop)) {
            return redirect(route('shops.index'))
                ->with('error', 'Shop(' . $id . ') Not Found');
        }
        
        return view('site.admin.shops.edit')->with('shop', $shop);
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
        $shop = Shop::find($id);
        if (is_null($shop)) {
            return redirect(route('shops.index'))
                ->with('error', 'Shop(' . $id . ') Not Found');
        }

        // input validate
        $validator = Validator::make($request->all(), [
            'shop_name' => [
                'required',
                'alpha_dash',
                Rule::unique('shops')->ignore($shop->id),
            ],
            'shop_domain' => [
                'required',
                Rule::unique('shops')->ignore($shop->id),
            ],
        ]);

        if ($validator->fails()) {
            return redirect(route('shops.edit', ['shop' => $shop->id]))
                        ->withErrors($validator)
                        ->withInput();
        }

        $shop->shop_name = $request->input('shop_name');
        $shop->shop_domain = $request->input('shop_domain');
        $shop->is_open = $request->input('is_open');
        // $shop->created_on = $request->input('created_on');
        $shop->expire_on = $request->input('expire_on');
        $shop->save();

        return redirect(route('shops.index'))->with('success', 'Shop Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shop = Shop::find($id);
        if (is_null($shop)) {
            return redirect(route('shops.index'))
                ->with('error', 'Shop(' . $id . ') Not Found');
        }

        // todo: relation to shops
        $shop->delete();
        return redirect(route('shops.index'))
            ->with('success', 'Shop Removed');
    }
}
