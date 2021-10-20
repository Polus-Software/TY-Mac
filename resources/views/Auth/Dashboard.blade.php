

@extends('layouts.app')
@section('content')
<h1>welcome</h1>

<div class="card-header"> Welcome {{Auth::user()->email}}</div>
<div class="card-body">
  @if (session('success'))
    <div class="alert alert-success" role="alert">
      {{ session('success') }}
    </div>
  @endif

 </div>
 <div>
     <ul>
     <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}">logout</a>
    </li>
     </ul>
 </div>
 @endsection