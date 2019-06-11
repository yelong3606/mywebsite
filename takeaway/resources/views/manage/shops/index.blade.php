@extends('layouts.manage')

@section('main-content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2">
            {{-- <h1 class="h2"><a href="?">Shops</a></h1> --}}
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/manage/shops">Shops</a></li>
                    @if (request()->anyFilled(['id', 'shop_name', 'shop_domain']))
                        <li class="breadcrumb-item">Search Result</li>
                    @endif
                </ol>
            </nav>
            <div class="btn-toolbar mb-2">
                <a class="btn btn-outline-secondary">Add Shop</a>
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
                </tr>
            </thead>
            <tbody>
                @foreach($shops as $shop)
                <tr class="clickable-row" data-href="/manage/shops/{{ $shop->id }}/edit">
                    <td>{{ $shop->id }}</td>
                    <td>{{ $shop->shop_name }}</td>
                    <td>{{ $shop->shop_domain }}</td>
                    <td>{{ $shop->is_open ? 'On' : 'Off' }}</td>
                    <td>{{ $shop->created_on }}</td>
                    <td>{{ $shop->expire_on }}</td>
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

@section('scripts')
<script>
    $(document).ready(function($) {
        $(".clickable-row").css('cursor', 'pointer');
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
</script>
@endsection
