@extends('layouts.manage')

@section('main-content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/manage/shops">Shops</a></li>
                    <li class="breadcrumb-item"><a href="/manage/shops">Shop #{{$shop->id}}</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route($route_prefix . 'index', ['shop' => $shop->id]) }}">Categories</a></li>
                </ol>
            </nav>
            <div class="btn-toolbar mb-2">
                <a class="btn btn-outline-secondary"
                    href="{{ route($route_prefix . 'create', ['shop' => $shop->id]) }}">Add Category</a>
            </div>
        </div>
    </div>
    <div class="col-2">
        @include('shop.info')
    </div>
    <div class="col-10">
        @include('shop.categories.index')
    </div>
</div>
@endsection