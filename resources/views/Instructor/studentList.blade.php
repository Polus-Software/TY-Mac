@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')

<!-- container -->

<div class="container llp-container">
  <div class="row">
    <div class="col-2 position-fixed">
    @include('Layouts.admin.sidebar')
    </div>

    <div class="col-9 ms-auto">
      <main>
      <div class="row mt-4">
          <table class="table llp-table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Student Name</th>
                <th scope="col">Email</th>
                <th scope="col">image</th>
              
               
              </tr>
            </thead>
            <tbody id="assigned_course_tbody">
              @php ($slno = 0)
              @foreach($studentLists as $studentList)
              @php ($slno = $slno + 1)
              <tr id="{{$studentList['userId']}}">
                <th class="align-middle" scope="row">{{$slno}}</th>
                <td class="align-middle">{{$studentList['student_firstname']}} {{$studentList['student_lastname']}} </td>
                <td class="align-middle">{{$studentList['student_email']}}</td>
                <td class="align-middle"><img src="{{ asset('/storage/images/'.$studentList['student_profile']) }}" alt="" style="width:25px; height:25px;"></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
</div>