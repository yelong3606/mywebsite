<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Option;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * can be used by both site-admin and shop-admin controller
 * must instance shop object in constructor
 */
trait Options
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
        return $this->template_prefix() . 'options.' . $name;
    }

    /**
     * @param String | index,create,edit
     * @param Integer
     * @return String
     */
    private function route($name, $option_id = null)
    {
        $route_name = $this->route_prefix() . 'options.' . $name;
        $parameters = ['shop' => $this->shop()->id];
        is_null($option_id) ?: $parameters['option'] = $option_id;

        return route($route_name, $parameters);
    }

    /**
     * trim value, remove empty value, remove same value
     * @param String
     * @return String
     */
    private function filterValue($value)
    {
        $replace = "<!@#$%>";
        $value = str_replace(["\r\n", "\n", "\r"], $replace, $value);
        $values = explode($replace, $value);
        for ($i = count($values) - 1; $i >= 0; $i--) {
            $values[$i] = trim($values[$i]);
            if (strlen($values[$i]) == 0) {
                unset($values[$i]);
            }
        }
        return join("\r\n", array_unique($values));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = Option::where('shop_id', $this->shop()->id)
            ->orderBy('id', 'DESC')
            ->get();
        return view($this->template('index'))
            ->with('options', $options);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->template('create'));
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
            'option_name' => [
                'required',

                // must unique within shop
                Rule::unique('options')->where(function($query) {
                    return $query->where('shop_id', $this->shop()->id);
                })
            ],
            'option_values' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect($this->route('create'))
                        ->withErrors($validator)
                        ->withInput();
        }


        $option = new Option();
        $option->shop_id = $this->shop()->id;
        $option->option_name = $request->input('option_name');
        $option->option_values = $this->filterValue($request->input('option_values'));
        $option->save();

        return redirect($this->route('index'))->with('success', 'Menu Option Created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($shop_id, $id)
    {
        // check if option with this id exists
        $option = Option::find($id);
        if (is_null($option) || $option->shop_id != $this->shop()->id) {
            return redirect($this->route('index'))
                ->with('error', 'Menu Option(' . $id . ') Not Found');
        }
        
        return view($this->template('edit'))->with('option', $option);
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
        // check if option with this id exists
        $option = Option::find($id);
        if (is_null($option) || $option->shop_id != $this->shop()->id) {
            return redirect($this->route('index'))
                ->with('error', 'Menu Option(' . $id . ') Not Found');
        }

        // input validate
        $validator = Validator::make($request->all(), [
            'option_name' => [
                'required',

                // must unique
                Rule::unique('options')->ignore($option->id)
            ],
            'option_values' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect($this->route('edit', $option->id))
                        ->withErrors($validator)
                        ->withInput();
        }

        // save
        $option->option_name = $request->input('option_name');
        $option->option_values = $this->filterValue($request->input('option_values'));
        $option->save();

        return redirect($this->route('index'))
            ->with('success', 'Menu Option Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($shop_id, $id)
    {
        // check if option with this id exists
        $option = Option::find($id);
        if (is_null($option) || $option->shop_id != $this->shop()->id) {
            return redirect($this->route('index'))
                ->with('error', 'Menu Option(' . $id . ') Not Found');
        }

        // todo: confirmation and relation to products
        $option->delete();
        return redirect($this->route('index'))
            ->with('success', 'Menu Option Removed');
    }
}