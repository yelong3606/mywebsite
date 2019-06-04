@extends('layouts.admin')

@section('main-title', 'Edit Category')

@section('main-content')

	{{ Form::open(['action' => ['Admin\CategoriesController@update', $category->id], 'method' => 'POST']) }}
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
		{{ Form::hidden('_method', 'PUT') }}
		{{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
	{{ Form::close() }}

@endsection

@section('main-button-group')
	<a href="/admin/categories" class="btn btn-sm btn-outline-primary"><i data-feather="arrow-left"></i> Go Back</a>
@endsection