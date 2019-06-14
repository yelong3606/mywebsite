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
                        <a href="{{ route($route_prefix . 'options.index', ['shop' => $shop->id]) }}">Menu Options</a>
                    </li>
                    <li class="breadcrumb-item">Menu Option #{{ $option->id }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-2">
        @include('shop.info')
    </div>
    <div class="col-5">
        <form action="{{ route($route_prefix . 'options.update', ['shop' => $shop->id, 'option' => $option->id]) }}"
            method="POST">
            @csrf
            @method('PUT')
            @include('shop.options.create')
            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        </form>
    </div>
</div>
@endsection