<?php

namespace App\Http\Controllers\Share;

use Illuminate\Http\Request;
use App\Region;
use App\Delivery;

/**
 * can be used by both site-admin and shop-admin controller
 * must instance shop object in constructor
 */
trait Settings
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
        return $this->template_prefix() . 'settings.' . $name;
    }

    /**
     * @param String | edit
     * @return String
     */
    private function route($name)
    {
        $route_name = 'settings.' . $name;
        $parameters = ['shop' => $this->shop()->id];

        return route($route_name, $parameters);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($shop_id)
    {
        return view($this->template('edit'))
            ->with('opening', $this->openinghours2str($this->shop()->opening_hours));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $shop_id)
    {
        $shop = $this->shop();
        $shop->title = $request->input('title');
        $shop->description = $request->input('description');
        if ($request->hasFile('shop_logo') && $request->file('shop_logo')->isValid()) {
            $shop->shop_logo = substr($request->shop_logo->store('public'), strlen('public/'));
        }
        $shop->addr_1 = $request->input('addr_1');
        $shop->addr_2 = $request->input('addr_2');
        $shop->addr_3 = $request->input('addr_3');
        $shop->addr_town = $request->input('addr_town');

        $shop->opening_hours = $this->str2openinghours($request->input('opening'));
        $shop->save();

        return redirect($this->route('edit'))->with('success', ' Settings Updated');
    }

    private function str2openinghours($str)
    {
        // init, null means close
        $result = array(
            'Monday' => '',
            'Tuesday' => '',
            'Wednesday' => '',
            'Thursday' => '',
            'Friday' => '',
            'Saturday' => '',
            'Sunday' => ''
        );

        // process
        $lines = \lines_explode(str_replace('-', ' ', $str));
        foreach ($lines as $line) {
            $fields = preg_split("/\s+/", $line);
            if (count($fields) >= 3 && isset($result[$fields[0]])) {
                $result[$fields[0]] = array(
                    'from' => date("H:i", strtotime($fields[1])),
                    'to' => date("H:i", strtotime($fields[2])),
                );
            }
        }

        return json_encode($result);
    }

    private function openinghours2str($openinghours) 
    {
        $result = '';

        $opening = json_decode($openinghours);
        if (!is_null($opening)) {
            foreach ($opening as $day => $time) {
                if (empty($time)) {
                    $result.= $day . ' Close' . "\r\n";
                } else{
                    $result.= $day . ' ' . $time->from . ' - ' . $time->to . "\r\n";
                }
            }
        }
        return $result;
    }
}