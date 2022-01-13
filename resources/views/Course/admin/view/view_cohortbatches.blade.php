@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<input id="course_id" type="hidden" value="{{ $course_id }}" />
@csrf
<!-- container -->
<div class="container llp-container">
  <div class="row">
  <div class="col-2 position-fixed">
      <!-- include sidebar here -->
      @include('Course.admin.view.sidebar')
    </div>
    <div class="col-9 ms-auto">
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
          @php ($slno = 0)
          @foreach($cohortbatches as $cohortbatch)
          @php ($slno = $slno + 1)
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
                        <p>{{ \Carbon\Carbon::parse($cohortbatch->start_date)->format('d-m-Y')}} - {{ \Carbon\Carbon::parse($cohortbatch->end_date)->format('d-m-Y')}}</p>
                        <p>Maximum <b>{{ $cohortbatch->students_count }}</b> students in this batch<p>
                      </div>
                    </div>
                  </div>


                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-lg-2">
                      <i class="far fa-clock fa-2x"></i>
                      </div>

                      <div class="col-lg-10">
                        <p>{{$cohortbatch->occurrence}}</p>
                        <p>{{\Carbon\Carbon::createFromFormat('H:i:s',$cohortbatch->start_time)->format('h : i A')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$cohortbatch->end_time)->format('h : i A')}} | {{$cohortbatch->time_zone}}</p>

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
          @endforeach
        </div>
      </main>
      <!-- main ends -->
    </div>
  </div>
</div>
<!-- container ends -->
@endsection('content')
