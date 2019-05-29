@extends('layouts.admin')

@section('main-title', 'Show Category')

@section('main-content')
	<fieldset disabled>
		<div class="form-group">
			{{ Form::label('category_name', 'Category Name') }}
			{{ Form::text('category_name', $category->category_name, ['class' => 'form-control', 'placeholder' => 'Please enter an unique name for the category']) }}
		</div>
		<div class="form-group">
			{{ Form::label('category_order', 'Display Order') }}
			{{ Form::text('category_order', $category->category_order, ['class' => 'form-control', 'placeholder' => 'Please enter an integer number, smaller the number is, more forward the category will be displayed']) }}
		</div>
	</fieldset>
@endsection

@section('main-button-group')
	<div class="btn-group mr-2">
		<a href="/admin/categories" class="btn btn-sm btn-outline-primary"><i data-feather="arrow-left"></i> Go Back</a>
		<a href="/admin/categories/{{$category->id}}/edit" class="btn btn-sm btn-outline-secondary"><i data-feather="edit"></i> Edit</a>
	</div>

	{{ Form::open(['action' => ['Admin\CategoriesController@destroy', $category->id], 'method' => 'POST']) }}
		{{ Form::hidden('_method', 'DELETE') }}
		<button type="submit" class="btn btn-sm btn-outline-danger"><i data-feather="x"></i> Delete</button>
	{{ Form::close() }}
@endsection