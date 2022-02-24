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
                <th scope="col">Session Title</th>
                <th scope="col">Session Instructor</th>
                <th scope="col">Batch</th>
                <th scope="col">Topic</th>
                <th scope="col">Join</th>
              </tr>
            </thead>
            <tbody id="course_tbody">
              @if(count($sessions))
              @foreach($sessions as $session)
              <tr>
                <td scope="col">{{ $session['slNo'] }}</td>
                <td scope="col">{{ $session['sessionTitle'] }}</td>
                <td scope="col">{{ $session['instructor'] }}</td>
                <td scope="col">{{ $session['batch'] }}</td>
                <td scope="col">{{ $session['topic'] }}</td>
                <td scope="col"><a href="/session-view/{{ $session['id'] }}" data-id="{{ $session['id'] }}">Join</a></td>
              </tr>
              @endforeach
              @else
              <tr>
                <td style="text-align:center;" colspan="5">No records</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
</div>