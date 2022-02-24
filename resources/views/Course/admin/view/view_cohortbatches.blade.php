@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
@php 
use App\Models\CustomTimezone;
@endphp
<input id="course_id" type="hidden" value="{{ $course_id }}" />
@csrf
<!-- container -->
<div class="container-fluid llp-container">
  <div class="row">
  <div class="left_sidebar">
      <!-- include sidebar here -->
      @include('Course.admin.sidebar')
    </div>
    <div class="col-8 right_card_block">
      <!-- main -->
      <main>
    <div class="py-4"><h5>Course Title: {{$course_title}}</h5><hr class="my-4"></div>
      <div class="py-4">
        <ul class="nav nav-tabs llp-tabs">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="" style="text-decoration:none; color:inherit;">Cohort List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('create-cohortbatch', ['course_id' => $course_id]) }}" style="text-decoration:none; color:inherit;">New Cohort</a>
          </li>
        </ul>
      </div>

        <div class="row">
          @php ($slno = 0) @endphp
          @forelse($cohortbatches as $cohortbatch)
          @php ($slno = $slno + 1) @endphp
          <div class="col-12 mb-3">
            <div class="card">
              <div class="card-title ms-3 mt-3 pb-2 border-bottom">
                  Cohort {{$slno}} : <strong>{{$cohortbatch->title}}</strong>
              </div>
              <div class="card-body">
                <p class="card-text">{{$cohortbatch->title}}</p>
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-lg-2">
                        <i class="fas fa-calendar-alt fa-2x"></i>
                      </div>

                      <div class="col-lg-10">
                        <p>{{ \Carbon\Carbon::parse($cohortbatch->start_date)->format('m/d/Y')}} - {{ \Carbon\Carbon::parse($cohortbatch->end_date)->format('m/d/Y')}}</p>
                        <p>Maximum <b>{{ $cohortbatch->students_count }}</b> students in this batch<p>
                      </div>
                    </div>
                  </div>


                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-lg-2">
                      <i class="far fa-clock fa-2x"></i>
                      </div>
                      @php 
             

             $offset = CustomTimezone::where('name', $cohortbatch->time_zone)->value('offset');
      
             $offsetHours = intval($offset[1] . $offset[2]);
             $offsetMinutes = intval($offset[4] . $offset[5]);
             
             if($offset[0] == "+") {
                 $sTime = strtotime($cohortbatch->start_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                 $eTime = strtotime($cohortbatch->end_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
             } else {
                 $sTime = strtotime($cohortbatch->start_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                 $eTime = strtotime($cohortbatch->end_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
             }

             $startTime = date("H:i:s", $sTime);
             $endTime = date("H:i:s", $eTime);
             $date = new DateTime("now");
           @endphp
                      <div class="col-lg-10">
                        @php
                           $occStr = "";
                           $index = 0;
                           $occurrence = $cohortbatch->occurrence;
                           $occArr = explode(',', $occurrence);
                           $occArrCount = count($occArr);
                           foreach($occArr as $occ) {
                             $index++;
                             if($index == $occArrCount) {
                              $occStr .= $occ;
                             } else {
                              $occStr .= $occ .', ';
                             }
                             
                           }
                        @endphp
                        <p>{{$occStr}}</p>
                        <p>{{\Carbon\Carbon::createFromFormat('H:i:s',$startTime)->format('h:i A')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$endTime)->format('h:i A')}} | {{ $date->setTimeZone(new DateTimeZone($cohortbatch->time_zone))->format('T')[0] == "+" || $date->setTimeZone(new DateTimeZone($cohortbatch->time_zone))->format('T')[0] == "-" ? "(UTC " . $offset . ")" : $date->setTimeZone(new DateTimeZone($cohortbatch->time_zone))->format('T') }}</p>

                      </div>
                    </div>
                  </div>
             
              <div class="d-flex justify-content-end col-lg-12">
              <a class="btn btn-sm btn-outline-dark me-3" href="{{ route('edit-cohortbatch', ['cohort_batch_id' => $cohortbatch->id]) }}">Edit</a>
              <a class="btn btn-sm btn-outline-dark me-3" href="{{ route('delete-cohortbatch', ['cohort_batch_id' => $cohortbatch->id]) }}">Delete</a>
              </div>
              </div>

              </div>
            </div>
          </div>
          @empty
          <x-nodatafound message="No data to show!"  notype=""/>
          @endforelse
        </div>
      </main>
      <!-- main ends -->
    </div>
    <div class="col-1"></div>
  </div>
</div>
<!-- container ends -->
@endsection('content')
