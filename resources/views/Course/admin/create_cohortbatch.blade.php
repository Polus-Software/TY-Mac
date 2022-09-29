@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
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
      <div class="py-4">
          <h3>Course Title</h3>
          <hr class="my-4">
        </div>
      <div class="py-4">
        <ul class="nav nav-tabs llp-tabs border-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('view_cohortbatches', ['course_id' => $course_id]) }}" style="text-decoration:none; color:inherit;">Cohort List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{{ route('create-cohortbatch', ['course_id' => $course_id]) }}" style="text-decoration:none; color:inherit;">New Cohort</a>
          </li>
        </ul>
      </div>
        
        <form action="{{ route('save-cohortbatch') }}" enctype="multipart/form-data" method="GET" class="row g-3 llp-form">
        @csrf
        <input id="course_id" name="course_id" type="hidden" value="{{$course_id}}">

          
          <div class="col-12">
            <label for="title">Days*<small style="font-size:12px;color:#a3a3a3;">(Ex: MON - WED - FRI)</small></label>
            <input type="text" class="form-control" id="title" name="cohortbatch_title" value="">
            @if ($errors->has('cohortbatch_title'))
              <span class="text-danger">The batch title is required</span>
            @endif
          </div>
          <div class="col-12">
            <label for="batchname">Title*</label>
            <input type="text" class="form-control" id="batchname" name="batchname" value="">
            @if ($errors->has('batchname'))
              <span class="text-danger">The batch name is required</span>
            @endif
          </div>
          <div class="col-md-6">
            <label for="level">Start date*</label>
            <input type="text" class="form-control" id="title" name="cohortbatch_startdate" placeholder="Ex: 12/25/2021" readonly >
            @if ($errors->has('cohortbatch_startdate'))
              <span class="text-danger">The batch start date is required</span>
            @endif
          </div>
          <div class="col-md-6">
          <label for="level">End date*</label>
            <input type="text" class="form-control" id="title" name="cohortbatch_enddate" placeholder="Ex: 12/25/2021" readonly>
            @if ($errors->has('cohortbatch_enddate'))
              <span class="text-danger">The batch end date is required</span>
            @endif
          </div>
          <label for="batch">Batch</label>
          <input type="hidden" name="cohortbatch_batchname" id="batch_name" value="Daily">
          <div class="col-12">
            <div class="form-check">
            <input class="form-check-input" type="radio" name="cohortbatchdaily" id="cohortbatchdaily" value="Daily" checked>
            <label class="form-check-label" for="cohortbatchdaily">
            Daily
            </label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-check">
            <input class="form-check-input" type="radio" name="cohortbatchdaily" id="cohortbatchcustom">
            <label class="form-check-label" for="cohortbatchcustom">
            Custom
            </label>
            </div>
          </div>
          <div class="col-12" id="cohortbatchdaycontainer" style="display:none;">
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value=" Sunday">
              <label class="form-check-label" for="flexCheckDefault">
              Sunday 
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value="  Monday">
              <label class="form-check-label" for="flexCheckDefault">
            Monday
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value=" Tuesday">
              <label class="form-check-label" for="flexCheckDefault">
              Tuesday 
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value=" Wednesday">
              <label class="form-check-label" for="flexCheckDefault">
              Wednesday 
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value=" Thursday">
              <label class="form-check-label" for="flexCheckDefault">
              Thursday
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value=" Friday">
              <label class="form-check-label" for="flexCheckDefault">
              Friday
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value=" Saturday">
              <label class="form-check-label" for="flexCheckDefault">
              Saturday
              </label>
            </div>
          </div>
          
          <!-- <div class="col-md-4">
            <label for="duration">Start time</label>
            <input type="text" class="form-control" id="duration" name="cohortbatch_starttime"  placeholder="Ex: 09" readonly>
            @if ($errors->has('cohortbatch_starttime'))
              <span class="text-danger">The batch start time is required</span>
            @endif
          </div> -->
          <label for="duration">Start time</label>
          <div class="col-md-2">
            <label for="duration">Hour*</label>
            <input type="number" class="form-control" id="starttime_hour" name="starttime_hour" min="1" max="12">
            @if ($errors->has('starttime_hour'))
              <span class="text-danger">The batch start hour is required</span>
            @endif
          </div>
          <div class="col-md-2">
            <label for="duration">Minutes*</label>
            <input type="number" class="form-control" id="starttime_minutes" name="starttime_minutes" min="0" max="59">
            @if ($errors->has('starttime_minutes'))
              <span class="text-danger">The batch start minutes is required</span>
            @endif
          </div>
          <div class="col-md-1">
            <label for="duration">AM/PM</label>
            <select class="form-control" name="starttime_ampm">
              <option value="AM">AM</option>
              <option value="PM">PM</option>
            </select>
          </div>
          
          <!-- <div class="col-md-4">
            <label for="duration">End time</label>
            <input type="text" class="form-control" id="duration" name="cohortbatch_endtime"placeholder="Ex: 11" readonly>
            @if ($errors->has('cohortbatch_endtime'))
              <span class="text-danger">The batch end time is required</span>
            @endif
          </div> -->

          <label for="duration">End time</label>
          <div class="col-md-2">
            <label for="duration">Hour*</label>
            <input type="number" class="form-control" id="endtime_hour" name="endtime_hour" min="1" max="12">
            @if ($errors->has('endtime_hour'))
              <span class="text-danger">The batch end hour is required</span>
            @endif
          </div>
          <div class="col-md-2">
            <label for="duration">Minutes*</label>
            <input type="number" class="form-control" id="endtime_minutes" name="endtime_minutes" min="0" max="59">
            @if ($errors->has('endtime_minutes'))
              <span class="text-danger">The batch end minutes is required</span>
            @endif
          </div>
          <div class="col-md-1">
            <label for="duration">AM/PM</label>
            <select class="form-control" name="endtime_ampm">
              <option value="AM">AM</option>
              <option value="PM">PM</option>
            </select>
          </div>
         
          <div class="col-md-5">
            <label for="duration">Timezone*</label>
            <select name="cohortbatch_timezone" class="form-control">
              <option value="">Select Timezone</option>
    <!-- include timezones here -->
              @include('Course.admin.timezones')
            </select>
            @if ($errors->has('cohortbatch_timezone'))
              <span class="text-danger">The time zone is required</span>
            @endif
          </div>
          <div class="col-md-2">
          </div>
          <div class="col-md-4">
            <label for="students_count">Number of students allowed to enroll in a Cohort*</label>
            <input type="text" class="form-control" id="students_count" name="students_count">
            @if ($errors->has('students_count'))
              <span class="text-danger">Number of students in the batch is required</span>
            @endif
          </div>
          <div class="col-12">
            <label for="description" class="col-12 border-bottom mb-3 pb-3">Send an email reminder to students</label>
            @foreach($notifications as $notification)
            <div class="form-check ps-0">
                <input type="checkbox" value="{{$notification->id}}" name="cohortbatch_notification" checked>
                <label for="" class="ms-2">{{ $notification->description }}</label>
            </div>
            @endforeach
            
          </div>          
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
          <input class="btn btn-primary" id="save_course" type="submit" value="Save">
          </div>
        </form>
      </main>
    </div>
	<div class="col-1"></div>
  </div>
</div>
<!-- container ends -->

<link rel="stylesheet" href="{{ asset('/assets/dtsel.css') }}">
<script type="text/javascript" src="{{ asset('/assets/dtsel.js') }}"></script>
<script>
  startdate = new dtsel.DTS('input[name="cohortbatch_startdate"]', {
    paddingX: 15, paddingY: 15
  });
  enddate = new dtsel.DTS('input[name="cohortbatch_enddate"]', {
    paddingX: 15, paddingY: 15
  });
  // starttime = new dtsel.DTS('input[name="cohortbatch_starttime"]', {
  //   paddingX: 15, paddingY: 15,showTime: true, showDate: false
  // });
  // endtime = new dtsel.DTS('input[name="cohortbatch_endtime"]', {
  //   paddingX: 15, paddingY: 15,showTime: true, showDate: false
  // });

  const cohortbatchdailyEl = document.querySelector('#cohortbatchdaily');
  const cohortbatchdayElList =  document.querySelectorAll('.cohortbatchday');
  const cohortbatchdaycontainer = document.querySelector('#cohortbatchdaycontainer');
  const cohortbatchcustom = document.querySelector('#cohortbatchcustom');
  cohortbatchdailyEl.addEventListener('change', (e)=>{
    cohortbatchdaycontainer.style.display = 'none';
    document.querySelector('#batch_name').value = e.currentTarget.value;
  });
  let customValue = [];
  const cohortbatchdayList = document.querySelectorAll('.cohortbatchday');
  cohortbatchcustom.addEventListener('change', ()=>{
    customValue = [];
    cohortbatchdaycontainer.style.display = 'block';
    
    cohortbatchdayList.forEach((el) => {
      if(el.checked) {
        customValue.push(el.value);
      }
    });
    document.querySelector('#batch_name').value = customValue;
  });
  cohortbatchdayList.forEach((el) => {
    el.addEventListener('change', (e) => {
      const currentItem = e.currentTarget;
        if(currentItem.checked) {
          customValue.push(currentItem.value.trim());
        } else {
          if(customValue.indexOf(currentItem.value) != -1) {
            customValue.splice(customValue.indexOf(currentItem.value), 1);
          }
        }
        document.querySelector('#batch_name').value = customValue;
    });
  })

  document.getElementById('starttime_hour').addEventListener('keyup', function(e) {
    if(document.getElementById('starttime_hour').value > 12) {
      document.getElementById('starttime_hour').value = 12;
    } else if(document.getElementById('starttime_hour').value < 1) {
      document.getElementById('starttime_hour').value = 1;
    }
  });

  document.getElementById('starttime_minutes').addEventListener('keyup', function(e) {
    if(document.getElementById('starttime_minutes').value > 59) {
      document.getElementById('starttime_minutes').value = 59;
    } else if(document.getElementById('starttime_minutes').value < 0) {
      document.getElementById('starttime_minutes').value = 0;
    }
  });

</script>

@endsection('content')
