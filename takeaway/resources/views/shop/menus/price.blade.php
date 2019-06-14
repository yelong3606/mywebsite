@php
    if (isset($menu)) {
        $variants = json_decode($menu->main_option);
    }
    $has_variants = isset($variants) && count($variants) >= 2;
@endphp

<div class="card">
    <div class="card-header">
        Price
        <a href="#" class="float-right with-variants @if(!$has_variants) d-none @endif" id="remove-variants">Cancel</a>
        <a href="#" class="float-right without-variants @if($has_variants) d-none @endif" id="add-variants">Add Variants</a>
    </div>
    <div class="card-body">
        <div class="form-group without-variants @if($has_variants) d-none @endif">
            {{ Form::number('price', isset($menu->price) ? $menu->price : 0.00, ['id' => 'price', 'class' => 'form-control text-right', 'step' => '0.01']) }}
        </div>

        <table class="table table-sm table-borderless with-variants @if(!$has_variants) d-none @endif">
            <thead>
                <tr>
                    <th>Variant</th>
                    <th>Price</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if ($has_variants)
                    @foreach($variants as $variant)
                    <tr>
                        <td>
                            <input type="text" class="form-control-sm" name="variant_name[]" value="{{$variant->name}}">
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control-sm text-right" name="variant_price[]" value="{{$variant->price}}">
                        </td>
                        <td>
                            @if ($loop->index == 1)
                            <button type="button" class="btn btn-outline-secondary btn-sm add-variant">+</button>
                            @elseif ($loop->index > 1)
                            <button type="button" class="btn btn-outline-secondary btn-sm remove-variant">-</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    @for ($i = 0; $i < 2; $i++)
                    <tr>
                        <td>
                            <input type="text" class="form-control-sm" name="variant_name[]" value="">
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control-sm text-right" name="variant_price[]" value="0.00">
                        </td>
                        <td>
                            @if ($i == 1)
                            <button type="button" class="btn btn-outline-secondary btn-sm add-variant">+</button>
                            @endif
                        </td>
                    </tr>  
                    @endfor
                @endif
            </tbody>
        </table>
    </div>
</div>
<input id="has-variants" type="hidden" name="has_variants" value="{{$has_variants}}">

@section('scripts')
<script>
    $(document).ready(function(){
        $('.add-variant').click(function() {
            addVariant(this);
        });
        $('.remove-variant').click(function() {
            removeVariant(this);
        });
        $('#add-variants').click(function() {
            $('.with-variants').removeClass('d-none');
            $('.without-variants').addClass('d-none');
            $('#has-variants').val(1);
            return false;
        });
        $('#remove-variants').click(function() {
            $('.without-variants').removeClass('d-none');
            $('.with-variants').addClass('d-none');
            $('#has-variants').val(0);
            return false;
        });
    });

    function addVariant(btn) {
        var tbody = $(btn).parents('tbody')[0];
            var tr = $('<tr>').appendTo(tbody);
                var td1 = $('<td>').appendTo(tr);
                    $('<input>').appendTo(td1)
                        .attr('type', 'text')
                        .attr('name', 'variant_name[]')
                        .addClass('form-control-sm');
                var td2 = $('<td>').appendTo(tr);
                    $('<input>').appendTo(td2)
                        .attr('type', 'number')
                        .attr('step', '0.01')
                        .attr('name', 'variant_price[]')
                        .addClass('form-control-sm')
                        .addClass('text-right')
                        .val(0.00);
                var td3 = $('<td>').appendTo(tr);
                    $('<button>').appendTo(td3)
                        .attr('type', 'button')
                        .addClass('btn')
                        .addClass('btn-outline-secondary')
                        .addClass('btn-sm')
                        .addClass('remove-variant')
                        .html('-')
                        .click(function() {
                            removeVariant(this)
                        });
    }

    function removeVariant(btn) {
        $(btn).parents('tr').remove();
    }
</script>
@endsection