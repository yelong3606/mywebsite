@extends('layouts.siteadmin')

@section('main-content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('regions.index') }}">Regions</a>
                    </li>
                    <li class="breadcrumb-item">Edit Region #{{$region->id}}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<form action="{{route('regions.update', ['region' => $region->id])}}" method="POST">
    <div class="row">
        @csrf
        @method('PUT')
        <div class="col-4">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="form-group">
                        {{ Form::label('parent_id', 'Parent') }}
                        <select name="parent_id" id="parent_id" class="form-control">
                            <option value="0" @if($region->parent_id == 0) selected @endif>No Parent</option>
                            @foreach ($parents as $parent)
                            <option value="{{$parent->id}}" @if($region->parent_id == $parent->id) selected @endif>{{$parent->region_name}}</option>    
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        {{ Form::label('region_name', 'Region Name') }}
                        {{ Form::text('region_name', $region->region_name, ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
</form>
@endsection