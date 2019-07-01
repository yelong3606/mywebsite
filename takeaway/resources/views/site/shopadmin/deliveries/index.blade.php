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
                        <a href="{{ route('site.dashboard', ['shop' => $shop->id]) }}">Shop #{{$shop->id}}</a>
                    </li>
                    <li class="breadcrumb-item">
                        Delivery Areas
                    </li>
                </ol>
            </nav>
            <div class="btn-toolbar mb-2">
                <a class="btn btn-outline-secondary"
                    href="{{ route('deliveries.create', ['shop' => $shop->id]) }}">Add Delivery Area</a>
            </div>
        </div>
    </div>
    <div class="col-2">
        @include('share.info')
    </div>
    <div class="col-10">
        @include('share.deliveries.index')
    </div>
</div>
@endsection