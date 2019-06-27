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
                        <a href="{{ route('manage.dashboard', ['shop' => $shop->id]) }}">Shop #{{$shop->id}}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route($route_prefix . 'deliveries.index', ['shop' => $shop->id]) }}">Delivery
                            Areas</a>
                    </li>
                    <li class="breadcrumb-item">Delivery Area #{{ $delivery->id }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-2">
        @include('shop.info')
    </div>
    <div class="col-10">
        <form action="{{route($route_prefix . 'deliveries.update', ['shop' => $shop->id, 'delivery' => $delivery->id])}}" method="POST">
            @csrf
            @method('PUT')
            @include('shop.deliveries.edit')
            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        </form>
    </div>
</div>
@endsection