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
                        Menus
                    </li>
                </ol>
            </nav>
            <div class="btn-toolbar mb-2">
                {{-- <div class="btn-group-toggle mr-1" data-toggle="buttons">
                    <label class="btn btn-primary">
                        <input id="toggleDescription" type="checkbox" autocomplete="off"> Toggle Description
                    </label>
                </div> --}}
                <a class="btn btn-outline-secondary"
                    href="{{ route('menus.create', ['shop' => $shop->id]) }}">Add Menu</a>
            </div>
        </div>
    </div>
    <div class="col-2">
        @include('share.info')
    </div>
    <div class="col-2">
        @include('share.menus.category')
    </div>
    <div class="col-8">
        @include('share.menus.index')
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