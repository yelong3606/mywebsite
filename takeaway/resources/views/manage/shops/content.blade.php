<div class="col-4">
    <div class="card mb-2">
        <div class="card-body">
            <div class="form-group">
                {{ Form::label('shop_name', 'Shop Name') }}
                {{ Form::text('shop_name', isset($shop) ? $shop->shop_name : '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('shop_domain', 'Shop Domain') }}
                {{ Form::text('shop_domain', isset($shop) ? $shop->shop_domain : '', ['class' => 'form-control', 'placeholder' => 'Subdomain like "bangkook" or domain like "www.abc.com"']) }}
            </div>
            <div class="form-group">
                {{ Form::label('shop_logo', 'Shop Logo') }}
                {{ Form::file('shop_logo', ['class' => 'form-control']) }}
            </div>
        </div>
    </div>
</div>
<div class="col-4">
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                {{ Form::label('is_open', 'Status') }}
                {{ Form::select('is_open', ['1' => 'On', '0' => 'Off'], isset($shop) ? $shop->is_open : '1', ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('created_on', 'Created On') }}
                {{ Form::text('created_on', isset($shop) ? $shop->created_on : date('Y-m-d'), ['class' => 'form-control-plaintext', 'readonly']) }}
            </div>
            <div class="form-group">
                {{ Form::label('expire_on', 'Expire On') }}
                {{ Form::date('expire_on', isset($shop) ? $shop->expire_on : date('Y-m-d'), ['class' => 'form-control']) }}
            </div>
        </div>
    </div>
</div>