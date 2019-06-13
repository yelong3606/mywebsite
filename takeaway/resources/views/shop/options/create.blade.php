<form action="{{route($route_prefix . 'options.store', ['shop' => $shop->id])}}" method="POST">
    @csrf
    <div class="form-group">
        {{ Form::label('option_name', 'Option Name') }}
        {{ Form::text('option_name', '', ['class' => 'form-control', 'placeholder' => 'Please enter an unique name for the option']) }}
    </div>
    <div class="form-group">
        {{ Form::label('option_values', 'Option Values') }}
        {{ Form::textarea('option_values', '', ['class' => 'form-control', 'placeholder' => 'Each value per line']) }}
    </div>
    <div class="form-group">
        {{ Form::label('', 'Option Type') }}
        <div class="form-check">
            <input class="form-check-input" type="radio" name="option_type" id="optionType1" value="main">
            <label class="form-check-label" for="optionType1">
                main
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="option_type" id="optionType2" value="side">
            <label class="form-check-label" for="optionType2">
                side
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="option_type" id="optionType3" value="both" checked>
            <label class="form-check-label" for="optionType3">
                both
            </label>
        </div>
    </div>
    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
</form>