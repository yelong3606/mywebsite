@extends('layouts.manage')

@section('main-content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2">
            <nav>
                <ol class="breadcrumb">
                    @if (request()->anyFilled(['id', 'shop_name', 'shop_domain']))
                    <li class="breadcrumb-item"><a href="/manage/shops">Shops</a></li>
                    <li class="breadcrumb-item">Search Result</li>
                    @else
                    <li class="breadcrumb-item">Shops</li>
                    @endif
                </ol>
            </nav>
            <div class="btn-toolbar mb-2">
                <a class="btn btn-outline-secondary" href="/manage/shops/create">Add Shop</a>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card">
            <div class="card-header">Search</div>
            <div class="card-body">
                <form action="/manage/shops">
                    <div class="form-group">
                        <label for="searchID"><small>Shop ID</small></label>
                        <input type="text" name="id" id="searchID" class="form-control-sm" value="{{request()->id}}">
                    </div>
                    <div class="form-group">
                        <label for="searchShopName"><small>Shop Name</small></label>
                        <input type="text" name="shop_name" id="searchShopName" class="form-control-sm"
                            value="{{request()->shop_name}}">
                    </div>
                    <div class="form-group">
                        <label for="searchShopDomain"><small>Shop Domain</small></label>
                        <input type="text" name="shop_domain" id="searchShopDomain" class="form-control-sm"
                            value="{{request()->shop_domain}}">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-10">
        @if ($shops->count() > 0)
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Shop ID</th>
                    <th>Shop Name</th>
                    <th>Shop Domain</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <th>Expire On</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($shops as $shop)
                <tr>
                    <td>{{ $shop->id }}</td>
                    <td>{{ $shop->shop_name }}</td>
                    <td>{{ $shop->shop_domain }}</td>
                    <td>{{ $shop->is_open ? 'On' : 'Off' }}</td>
                    <td>{{ $shop->created_on }}</td>
                    <td>{{ $shop->expire_on }}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-secondary btn-sm" href="{{ route('manage.dashboard', ['shop' => $shop->id]) }}">
                                Manage
                            </a>
                            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="">Edit</a>
                                <a class="dropdown-item" href="">Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $shops->links() }}
        @else
        <p>No Shops Found</p>
        @endif
    </div>
</div>
@endsection