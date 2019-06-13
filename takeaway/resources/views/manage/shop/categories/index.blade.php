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
                        Categories
                    </li>
                </ol>
            </nav>
            <div class="btn-toolbar mb-2">
                <div class="btn-group-toggle mr-1" data-toggle="buttons">
                    <label class="btn btn-primary active">
                        <input id="toggleDescription" type="checkbox" checked autocomplete="off"> Toggle Description
                    </label>
                </div>
                <a class="btn btn-outline-secondary"
                    href="{{ route($route_prefix . 'categories.create', ['shop' => $shop->id]) }}">Add Category</a>
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

@section('scripts')
<script>
    $(document).ready(function(){
        $('#toggleDescription').change(function() {
            this.checked ? $('.description').show() : $('.description').hide();
        });
    });
</script>
@endsection