@extends('layouts.siteadmin')

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
                        Shop #{{$shop->id}}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-2">
        @include('share.info')
    </div>
    <div class="col-2">
        <div class="card">
            <div class="card-header">Management</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <a href="{{ route('categories.index', ['shop' => $shop->id]) }}">Categories</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('menus.index', ['shop' => $shop->id]) }}">Menus</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('options.index', ['shop' => $shop->id]) }}">Menu Options</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('settings.edit', ['shop' => $shop->id]) }}">Settings</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('deliveries.index', ['shop' => $shop->id]) }}">Delivery Areas</a>
                </li>
            </ul>
        </div>
        
    </div>
</div>
@endsection