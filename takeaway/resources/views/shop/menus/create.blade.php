@php
$category_id = isset($menu) ? $menu->category_id : 0;
@endphp

<div class="row">
    <div class="col-5">
        {{-- title and description --}}
        <div class="card mb-2">
            <div class="card-body">
                <div class="form-group">
                    {{ Form::label('title', 'Title') }}
                    {{ Form::text('title', isset($menu) ? $menu->title : '', ['class' => 'form-control', 'placeholder' => 'Please enter an unique title for the menu']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('description', 'Description') }}
                    {{ Form::textarea('description', isset($menu) ? $menu->description : '', ['id' => 'summernote', 'class' => 'form-control']) }}
                </div>
            </div>
        </div>

        {{-- price | variants --}}
        @include('shop.menus.price')
    </div>
    <div class="col-3">
        {{-- Category Select --}}
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    {{ Form::label('category_id', 'Category') }}
                    <select name="category_id" id="category_id" class="form-control" size="20">
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}" @if ($category->id == $category_id) selected
                            @endif>{{$category->category_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        {{-- options --}}
        @include('shop.menus.options')
    </div>
</div>