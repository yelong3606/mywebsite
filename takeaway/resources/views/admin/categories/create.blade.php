@extends('layouts.admin')

@section('main-title', 'Create Category')

@section('main-content')

	{{ Form::open(array('url' => 'abc')) }}
	{{ Form::close() }}

@endsection