@extends('layouts.manage')

@section('main-content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('shops.index') }}">Shops</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('manage.dashboard', ['shop' => $shop->id]) }}">Shop #{{$shop->id}} Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route($route_prefix . 'options.index', ['shop' => $shop->id]) }}">Menu Options</a>
                    </li>
                    <li class="breadcrumb-item">Add Menu Option</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-2">
        @include('shop.info')
    </div>
    <div class="col-5">
        @include('shop.options.create')
    </div>
</div>
@endsection