<div class="card">
    <div class="card-header">Shop #{{$shop->id}}</div>
    <div class="card-body">
        <h5 class="card-title">Name</h5>
        <p class="card-text">{{$shop->shop_name}}</p>
        <h5 class="card-title">Domain</h5>
        <p class="card-text">{{$shop->shop_domain}}</p>
        <h5 class="card-title">Status</h5>
        <p class="card-text">{{$shop->is_open ? 'On' : 'Off'}}</p>
        <h5 class="card-title">Created On</h5>
        <p class="card-text">{{$shop->created_on}}</p>
        <h5 class="card-title">Expire On</h5>
        <p class="card-text">{{$shop->expire_on}}</p>
    </div>
</div>
