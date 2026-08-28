@extends('layouts.app')

@section('title', $viewData['title'])
@section('subtitle', 'Product created')

@section('content')
    <div class="alert alert-success text-center" role="alert">
        <h4 class="alert-heading">Product created successfully!</h4>
        <p class="mb-0">
            {{ $viewData['name'] }} - ${{ $viewData['price'] }}
        </p>
    </div>
@endsection
