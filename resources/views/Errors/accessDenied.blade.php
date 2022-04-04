@extends('Layouts.app')
@section('content')
<div class="container" style="height:80vh;padding-top: 10%;">
    <div class="row bg-white mt-5 mb-5">
        <div class="col-lg-12 d-flex justify-content-center">
            <h1 class="pt-5">Access Denied!</h1>
        </div>

        <div class="col-lg-12 d-flex justify-content-center">
            <h5 class="">You dont have permission to view this page.</h5>
        </div>

        <div class="col-lg-12 d-flex justify-content-center mb-5">
           <a id="login_btn" onclick="loginLoad()" href="" class="btn btn-dark" href="#login" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
        </div>
    </div>
</div>
<script>
    function loginLoad() {
        var url_string = window.location.href;
        var url = new URL(url_string);
        var session_id = url.searchParams.get("sessionId");
        if(session_id != null) {
            document.getElementById('loginForm').elements['session_id'].value = session_id;
            document.getElementById('loginForm').elements['redirect_page'].value = 'session';
        }
    }
</script>
@endsection('content')