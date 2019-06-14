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
                        Shop #{{$shop->id}} Dashboard
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-2">
        @include('shop.info')
    </div>
    <div class="col-2">
        <div class="card">
            <div class="card-header">Management</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <a href="{{ route($route_prefix . 'categories.index', ['shop' => $shop->id]) }}">Categories</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route($route_prefix . 'menus.index', ['shop' => $shop->id]) }}">Menus</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route($route_prefix . 'options.index', ['shop' => $shop->id]) }}">Menu Options</a>
                </li>
            </ul>
        </div>
        
    </div>
</div>
@endsection