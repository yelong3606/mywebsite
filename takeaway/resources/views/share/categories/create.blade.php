<form action="{{route('categories.store', ['shop' => $shop->id])}}" method="POST">
    @csrf
    <div class="form-group">
        {{ Form::label('category_name', 'Category Name') }}
        {{ Form::text('category_name', '', ['class' => 'form-control', 'placeholder' => 'Please enter an unique name for the category']) }}
    </div>
    <div class="form-group">
        {{ Form::label('category_desc', 'Category Description') }}
        {{ Form::textarea('category_desc', '', ['id' => 'summernote', 'class' => 'form-control']) }}
    </div>
    <div class="form-group">
        {{ Form::label('category_order', 'Display Order') }}
        {{ Form::text('category_order', $category_order, ['class' => 'form-control', 'placeholder' => 'Please enter an integer number, smaller the number is, more forward the category will be displayed']) }}
    </div>
    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
</form>