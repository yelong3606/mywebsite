<div class="row">
    <div class="col-4">
        <div class="card mb-2">
            <div class="card-header">
                Add to Batch
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">Region</label>
                    <div class="autocomplete" style="width:300px;">
                        <input type="text" class="form-control" name="region_name" id="regionsAutoComplete" autocomplete="off" placeholder="e.g. Clonsilla">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Minimum Order Amount</label>
                    <input type="number" step="0.01" class="form-control text-right" name="minimum" id="minimum" value="0">
                </div>
                <div class="form-group">
                    <label for="">Delivery Fee</label>
                    <input type="number" step="0.01" class="form-control text-right" name="delivery" id="delivery" value="0">
                </div>
                <input type="button" id="addToBatch" value="Add to Batch" class="btn btn-secondary">
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card mb-2">
            <div class="card-header">
                Batch
            </div>
            <div class="card-body">
                <div class="form-group">
                    <textarea name="delivery_lines" id="deliveryLines" class="form-control" rows="14"></textarea>
                </div>
                <input type="submit" value="Submit" class="btn btn-primary">
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card mb-2 border-info">
            <div class="card-header">
                Batch Format
            </div>
            <div class="card-body">
                <div class="card-text text-info">
                    DUNBOYNE 10 2<br>
                    HARTSTOWN €10 €3.80<br>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script>
    $(document).ready(function(){
        $('#addToBatch').click(function(){
            var region = $('#regionsAutoComplete').val();
            if (region == '') {
                alert('please choose region first');
                return;
            }

            // remove parent part
            region = region.substring(0, region.indexOf(','));

            var old = $('#deliveryLines').text();
            if (old != '') {
                old += "\r\n";
            }
            $('#deliveryLines').text(old + region + ' ' + $('#minimum').val() + ' ' + $('#delivery').val());
        });
    });
</script>
@endsection