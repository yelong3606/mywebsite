<div class="row">
    <div class="col-4">
        <div class="card mb-2">
            <div class="card-body">
                <div class="form-group">
                    <label for="">Region</label>
                    <input type="text" class="form-control" name="region_name" value="{{$delivery->region_name}}" readonly>
                </div>
                <div class="form-group">
                    <label for="">Minimum Order Amount</label>
                    <input type="number" step="0.01" class="form-control text-right" name="minimum"                         value="{{$delivery->minimum}}">
                </div>
                <div class="form-group">
                    <label for="">Delivery Fee</label>
                    <input type="number" step="0.01" class="form-control text-right" name="delivery"                        value="{{$delivery->delivery}}">
                </div>
            </div>
        </div>
    </div>
</div>