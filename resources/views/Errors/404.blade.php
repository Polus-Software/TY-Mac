@extends('Layouts.app')
@section('content')
<!-- top banner-->

<div class="container mt-5 pt-5">
        <div class="alert alert-danger text-center">
            <h2 class="display-3">404</h2>
            <p class="display-5">Oops! Something is wrong.</p>
            <p class="display-5">{{ $errorMessage }}</p>
        </div>
    </div>
@endsection('content')
