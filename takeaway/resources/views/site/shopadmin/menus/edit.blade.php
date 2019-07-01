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
                        <a href="{{ route('menus.index', ['shop' => $shop->id]) }}">Menus</a>
                    </li>
                    <li class="breadcrumb-item">Menu #{{ $menu->id }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-2">
        @include('share.info')
    </div>
    <div class="col-10">
        <form action="{{ route('menus.update', ['shop' => $shop->id, 'menu' => $menu->id]) }}"
            method="POST">
            @csrf
            @method('PUT')
            @include('share.menus.create')
            <input type="submit" class="btn btn-primary" value="Submit" />
        </form>
    </div>
</div>
@endsection