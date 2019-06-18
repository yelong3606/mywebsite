@extends('layouts.manage')

@section('main-content')

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2">
            <nav>
                <ol class="breadcrumb">
                    @if (request()->anyFilled(['id', 'region_name']))
                    <li class="breadcrumb-item"><a href="/manage/regions">Regions</a></li>
                    <li class="breadcrumb-item">Search Result</li>
                    @else
                    <li class="breadcrumb-item">Regions</li>
                    @endif
                </ol>
            </nav>
            <div class="btn-toolbar mb-2">
                <a class="btn btn-outline-secondary" href="/manage/regions/create">Add Region</a>
                <a class="btn btn-outline-warning" href="/manage/regions/999">Update Parent Name</a>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card">
            <div class="card-header">Search</div>
            <div class="card-body">
                <form action="/manage/regions">
                    <div class="form-group">
                        <select name="parent_id" class="form-control form-control-sm" size="15">
                            <option value="-1" @if(!isset(request()->parent_id) || request()->parent_id < 0) selected
                                    @endif>With or without parent</option>
                            <option value="0" @if(isset(request()->parent_id) && request()->parent_id == 0) selected
                                @endif>Without parent</option>
                            @foreach ($parents as $region)
                            <option value="{{$region->id}}" @if(request()->parent_id == $region->id) selected
                                @endif>{{$region->region_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="id" class="form-control form-control-sm" placeholder="id"
                            value="{{request()->id}}">
                    </div>
                    <div class="form-group">
                        <input type="text" name="region_name" class="form-control form-control-sm" placeholder="region_name"
                            value="{{request()->region_name}}">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-10">
        @if ($regions->count() > 0)
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Region ID</th>
                    <th>Region Name</th>
                    <th>Parent Region Name</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($regions as $region)
                <tr>
                    <td>{{ $region->id }}</td>
                    <td>{{ $region->region_name }}</td>
                    <td>{{ $region->parent_name }}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-secondary btn-sm"
                                href="{{ route('regions.edit', ['region' => $region->id]) }}">
                                Edit
                            </a>

                            <form action="{{ route('regions.destroy', ['region' => $region->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Are you sure?');">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $regions->appends([
            'id' => request()->id,
            'region_name' => request()->region_name,
            'parent_id' => request()->parent_id
        ])->links() }}
        @else
        <p>No Regions Found</p>
        @endif
    </div>
</div>
@endsection