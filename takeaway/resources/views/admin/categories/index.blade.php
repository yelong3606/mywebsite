@extends('layouts.admin')

@section('main-title', 'Categories')

@section('main-content')

	@if ($categories->count() > 0)
		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<caption>List of Categories, sorted by "Display Order"</caption>
				<thead class="thead-dark">
				<tr>
					<!-- <th>#</th> -->
					<th>Category Name</th>
					<th>Display Order</th>
				</tr>
				</thead>
				@foreach($categories as $category)
				<tr>
					<!-- <td>{{$category->id}}</td> -->
					<td>{{$category->category_name}}</td>
					<td>{{$category->category_order}}</td>
				</tr>
				@endforeach
			</table>
		</div>
	@else
		<p>No Categories Found</p>
	@endif

@endsection