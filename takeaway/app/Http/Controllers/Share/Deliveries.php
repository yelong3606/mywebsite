<?php

namespace App\Http\Controllers\Share;

use Illuminate\Http\Request;
use App\Delivery;
use App\Region;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * can be used by both site-admin and shop-admin controller
 * must instance shop object in constructor
 */
trait Deliveries
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
     * @param String | index,create,edit
     * @return String
     */
    private function template($name)
    {
        return $this->template_prefix() . 'deliveries.' . $name;
    }

    /**
     * @param String | index,create,edit
     * @param Integer
     * @return String
     */
    private function route($name, $delivery_id = null)
    {
        $route_name = 'deliveries.' . $name;
        $parameters = ['shop' => $this->shop()->id];
        is_null($delivery_id) ?: $parameters['delivery'] = $delivery_id;

        return route($route_name, $parameters);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = Delivery::where('shop_id', $this->shop()->id)->get();

        return view($this->template('index'))
            ->with('deliveries', $deliveries);
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
        // count
        $inserted = 0;
        $ignored = 0;

        $lines = \lines_explode($request->input('delivery_lines'));
        foreach($lines as $line) {
            $fields = \preg_split("/\s+/", str_replace("€", "", $line));
            if (count($fields) >= 3 && is_numeric($fields[1]) && is_numeric($fields[2])) {
                $regions = Region::where('region_name', $fields[0])->get();
                if ($regions->count() > 0) {
                    $delivery = new Delivery();
                    $delivery->shop_id = $this->shop()->id;
                    $delivery->region_id = $regions[0]->id;
                    $delivery->region_name = $regions[0]->region_name;
                    $delivery->minimum = $fields[1];
                    $delivery->delivery = $fields[2];

                    try {
                        $delivery->save();
                    } catch (\Throwable $th) {
                        // already exist, ignored
                        $ignored++;
                        continue;
                    }
    
                    // inserted
                    $inserted++;
                    continue;
                }
            }
            $ignored++;
        }
    
        return redirect($this->route('index'))->with('success', $inserted . ' Delivery Area Created, ' . $ignored . ' ignored');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($shop_id, $id)
    {
        // check if delivery with this id exists
        $delivery = Delivery::find($id);
        if (is_null($delivery) || $delivery->shop_id != $this->shop()->id) {
            return redirect($this->route('index'))
                ->with('error', 'Delivery Area(' . $id . ') Not Found');
        }
        
        return view($this->template('edit'))
            ->with('delivery', $delivery);
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
        // check if delivery with this id exists
        $delivery = Delivery::find($id);
        if (is_null($delivery) || $delivery->shop_id != $this->shop()->id) {
            return redirect($this->route('index'))
                ->with('error', 'Delivery Area(' . $id . ') Not Found');
        }

        // save
        $delivery->minimum = $request->input('minimum');
        $delivery->delivery = $request->input('delivery');
        $delivery->save();

        return redirect($this->route('index'))
            ->with('success', 'Delivery Area Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($shop_id, $id)
    {
        // check if delivery with this id exists
        $delivery = Delivery::find($id);
        if (is_null($delivery) || $delivery->shop_id != $this->shop()->id) {
            return redirect($this->route('index'))
                ->with('error', 'Delivery Area(' . $id . ') Not Found');
        }

        // todo: confirmation and relation to deliveries
        $delivery->delete();
        return redirect($this->route('index'))
            ->with('success', 'Delivery Area Removed');
    }
}