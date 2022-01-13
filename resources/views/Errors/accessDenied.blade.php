@extends('Layouts.app')
@section('content')
<div class="container">
    <div class="row bg-white mt-5">
        <div class="col-lg-12 d-flex justify-content-center">
            <h1 class="pt-5">Access Denied !</h1>
        </div>

        <div class="col-lg-12 d-flex justify-content-center">
            <h5 class="">You dont have permission to view this page.</h5>
        </div>

        <div class="col-lg-12 d-flex justify-content-center mb-5">
           <a id="login_btn" href="" class="btn btn-dark">Login</a>
        </div>
    </div>
</div>
<script>
    document.getElementById('login_btn').addEventListener('click', function(e) {
        e.preventDefault();
        let path = "{{ route('home') }}?redirect=" + true;
        window.location = path;
    });
</script>
@endsection('content')