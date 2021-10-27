

@extends('Layouts.Profile')
@section('content')
 <nav class="navbar navbar-expand-sm bg-dark">
  <ul class="navbar-nav">
    
    <li class="nav-item">
      <a class="nav-link" href="#">change password</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('edituser') }}"> Welcome {{Auth::user()->firstname.' '.Auth::user()->lastname}}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}">logout</a>
    </li>
  </ul>
</nav>
<div class="card-header"> Welcome {{Auth::user()->firstname}}</div>
<div class="card-body">
  @if (session('success'))
    <div class="alert alert-success" role="alert">
      {{ session('success') }}
    </div>
  @endif

@endsection