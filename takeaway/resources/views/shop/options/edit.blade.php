<form action="{{ route($route_prefix . 'options.update', ['shop' => $shop->id, 'option' => $option->id]) }}"
    method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        {{ Form::label('option_name', 'Option Name') }}
        {{ Form::text('option_name', $option->option_name, ['class' => 'form-control', 'placeholder' => 'Please enter an unique name for the option']) }}
    </div>
    <div class="form-group">
        {{ Form::label('', 'Option Type') }}
        <div class="form-check">
            <input class="form-check-input" type="radio" name="option_type" id="optionType1" value="main" 
                @if($option->option_type == 'main') checked @endif>
            <label class="form-check-label" for="optionType1">
                main
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="option_type" id="optionType2" value="side"
                @if($option->option_type == 'side') checked @endif>
            <label class="form-check-label" for="optionType2">
                side
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="option_type" id="optionType3" value="both"
                @if($option->option_type == 'both') checked @endif>
            <label class="form-check-label" for="optionType3">
                both
            </label>
        </div>
    </div>
    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
</form>