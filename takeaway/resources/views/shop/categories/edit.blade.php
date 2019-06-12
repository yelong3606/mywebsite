<form action="{{ route($route_prefix . 'categories.update', ['shop' => $shop->id, 'category' => $category->id]) }}"
    method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        {{ Form::label('category_name', 'Category Name') }}
        {{ Form::text('category_name', $category->category_name, ['class' => 'form-control', 'placeholder' => 'Please enter an unique name for the category']) }}
    </div>
    <div class="form-group">
        {{ Form::label('category_desc', 'Category Description') }}
        {{ Form::textarea('category_desc', $category->category_desc, ['id' => 'summernote', 'class' => 'form-control', 'placeholder' => 'Category Description']) }}
    </div>
    <div class="form-group">
        {{ Form::label('category_order', 'Display Order') }}
        {{ Form::text('category_order', $category->category_order, ['class' => 'form-control', 'placeholder' => 'Please enter an integer number, smaller the number is, more forward the category will be displayed']) }}
    </div>
    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
</form>