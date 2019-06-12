<?php

namespace App\Http\Controllers\Shop;

trait Dashboard
{
    /**
     * @return String
     */
    abstract protected function template_prefix();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->template_prefix() . 'dashboard');
    }
}