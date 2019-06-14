<div class="form-group">
    {{ Form::label('option_name', 'Option Name') }}
    {{ Form::text('option_name', isset($option) ? $option->option_name : '', ['class' => 'form-control', 'placeholder' => 'Please enter an unique name for the option']) }}
</div>
<div class="form-group">
    {{ Form::label('option_values', 'Option Values') }}
    {{ Form::textarea('option_values', isset($option) ? $option->option_values : '', ['class' => 'form-control', 'placeholder' => 'Each value per line']) }}
</div>