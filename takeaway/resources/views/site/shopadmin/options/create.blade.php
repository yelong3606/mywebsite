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
                        <a href="{{ route('options.index', ['shop' => $shop->id]) }}">Menu Options</a>
                    </li>
                    <li class="breadcrumb-item">Add Menu Option</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-2">
        @include('share.info')
    </div>
    <div class="col-5">
        <form action="{{route('options.store', ['shop' => $shop->id])}}" method="POST">
            @csrf
            @include('share.options.create')
            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        </form>
    </div>
</div>
@endsection