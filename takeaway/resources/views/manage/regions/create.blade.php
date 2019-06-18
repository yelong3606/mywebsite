@extends('layouts.manage')

@section('main-content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('regions.index') }}">Regions</a>
                    </li>
                    <li class="breadcrumb-item">Add Region</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<form action="{{route('regions.store')}}" method="POST">
    <div class="row">
        @csrf
        <div class="col-3">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="form-group">
                        {{ Form::label('parent_id', 'Parent') }}
                        <select name="parent_id" id="parent_id" class="form-control" size="20">
                            <option value="0" selected>No Parent</option>
                            @foreach ($parents as $region)
                            <option value="{{$region->id}}">{{$region->region_name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="form-group">
                        {{ Form::label('region_name', 'Region Name') }}
                        {{ Form::textarea('region_name', '', ['class' => 'form-control', 'placeholder' => 'each name per line']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
</form>
@endsection