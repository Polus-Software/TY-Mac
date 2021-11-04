@extends('Layouts.Profile')
@section('content')
    
<div class="card m-auto mt-5  border border-2 rounded" style="width: 20rem;">
  <div class="card-body">
    <h1 class="card-title">{{$students->id}}</h1>
   
    <p class="card-text">First nmae : {{$students->firstname}}</p>
    <p> Last name : {{$students->lastname}}</p>
    <p> Email : {{$students->email}}</p>
   
   
  </div>
</div>
@endsection