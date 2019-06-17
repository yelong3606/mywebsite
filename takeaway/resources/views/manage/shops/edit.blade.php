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
                    <li class="breadcrumb-item">Edit Shop #{{ $shop->id }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<form action="{{route('shops.update', ['shop' => $shop->id])}}" method="POST" enctype="multipart/form-data">
    <div class="row">
        @csrf
        @method('PUT')
        @include('manage.shops.content')
    </div>
    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
</form>
@endsection