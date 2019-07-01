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
                        <a href="{{ route('deliveries.index', ['shop' => $shop->id]) }}">Delivery
                            Areas</a>
                    </li>
                    <li class="breadcrumb-item">Add Delivery Area</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-2">
        @include('share.info')
    </div>
    <div class="col-10">
        <form action="{{route('deliveries.store', ['shop' => $shop->id])}}" method="POST">
            @csrf
            @include('share.deliveries.create')
        </form>
    </div>
</div>
@endsection