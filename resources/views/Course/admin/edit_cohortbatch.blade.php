@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
@php 
use App\Models\CustomTimezone;
@endphp
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
      
      @foreach($cohortbatches as $cohortbatch)
        <form action="{{ route('update_cohortbatches') }}" enctype="multipart/form-data" method="POST" class="row g-3 llp-form">
        @csrf
        <input id="course_id" name="course_id" type="hidden" value="{{$cohortbatch->course_id}}">
        <input type="hidden" name="cohort_batch_id" value="{{$cohortbatch->id}}">
          <div class="py-4">
          <h3>Cohort Overview</h3>
          <hr class="my-4">
        </div>
          <div class="col-12">
            <label for="title">Title*</label>
            <input type="text" class="form-control" id="title" name="cohortbatch_title" value="{{$cohortbatch->title}}">
            @if ($errors->has('cohortbatch_title'))
              <span class="text-danger">The batch title is required</span>
            @endif
          </div>
          <div class="col-12">
            <label for="batchname">Batchname*</label>
            <input type="text" class="form-control" id="batchname" name="batchname" value="{{$cohortbatch->batchname}}">
            @if ($errors->has('batchname'))
              <span class="text-danger">The batch name is required</span>
            @endif
          </div>
         
          <div class="col-md-6">
            <label for="level">Start date*</label>
            <input type="text" class="form-control" id="title" name="cohortbatch_startdate" readonly value="{{date('m-d-Y', strtotime($cohortbatch->start_date))}}">
            @if ($errors->has('cohortbatch_startdate'))
              <span class="text-danger">The batch start date is required</span>
            @endif
          </div>
          <div class="col-md-6">
          <label for="level">End date*</label>
            <input type="text" class="form-control" id="title" name="cohortbatch_enddate" readonly value="{{date('m-d-Y', strtotime($cohortbatch->end_date))}}">
            @if ($errors->has('cohortbatch_enddate'))
              <span class="text-danger">The batch end date is required</span>
            @endif
          </div>
          <label for="batch">Batch</label>
          <input type="hidden" name="cohortbatch_batchname" id="batch_name" value="{{$cohortbatch->occurrence}}">
          <div class="col-12">
            <div class="form-check">
            @if($cohortbatch->occurrence == "Daily")
            <input class="form-check-input" type="radio" name="cohortbatchdaily" id="cohortbatchdaily" value="Daily" checked>
            @else
            <input class="form-check-input" type="radio" name="cohortbatchdaily" id="cohortbatchdaily" value="Daily">
            @endif
            <label class="form-check-label" for="cohortbatchdaily">
            Daily
            </label>
            </div>
          </div>

          @if($cohortbatch->occurrence != "Daily")
          @php 
          $days = explode(',', $cohortbatch->occurrence);
          $sundayFlag = in_array('Sunday', $days) ? 'checked' : '';
          $mondayFlag = in_array('Monday', $days) ? 'checked' : '';
          $tuesdayFlag = in_array('Tuesday', $days) ? 'checked' : '';
          $wednesdayFlag = in_array('Wednesday', $days) ? 'checked' : '';
          $thursdayFlag = in_array('Thursday', $days) ? 'checked' : '';
          $fridayFlag = in_array('Friday', $days) ? 'checked' : '';
          $saturdayFlag = in_array('Saturday', $days) ? 'checked' : '';
          @endphp
          <div class="col-12">
            <div class="form-check">
            <input class="form-check-input" type="radio" name="cohortbatchdaily" id="cohortbatchcustom" checked> 
            <label class="form-check-label" for="cohortbatchcustom">
            Custom
            </label>
            </div>
          </div>
          <div class="col-12" id="cohortbatchdaycontainer">
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value="Sunday" {{$sundayFlag}}>
              <label class="form-check-label" for="flexCheckDefault">
              Sunday
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value="Monday" {{$mondayFlag}}>
              <label class="form-check-label" for="flexCheckDefault">
              Monday
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value="Tuesday" {{$tuesdayFlag}}>
              <label class="form-check-label" for="flexCheckDefault">
              Tuesday
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value="Wednesday"  {{$wednesdayFlag}}>
              <label class="form-check-label" for="flexCheckDefault">
              Wednesday
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value="Thursday" {{$thursdayFlag}}>
              <label class="form-check-label" for="flexCheckDefault">
              Thursday
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value="Friday" {{$fridayFlag}}>
              <label class="form-check-label" for="flexCheckDefault">
              Friday
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value="Saturday"  {{$saturdayFlag}}>
              <label class="form-check-label" for="flexCheckDefault">
              Saturday
              </label>
            </div>
          </div>

          @else
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
              <input class="form-check-input cohortbatchday" type="checkbox" value="Sunday">
              <label class="form-check-label" for="flexCheckDefault">
              Sunday
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value="Monday">
              <label class="form-check-label" for="flexCheckDefault">
              Monday
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value="Tuesday">
              <label class="form-check-label" for="flexCheckDefault">
              Tuesday
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value="Wednesday">
              <label class="form-check-label" for="flexCheckDefault">
              Wednesday
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value="Thursday">
              <label class="form-check-label" for="flexCheckDefault">
              Thursday
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value="Friday">
              <label class="form-check-label" for="flexCheckDefault">
              Friday
              </label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input cohortbatchday" type="checkbox" value="Saturday">
              <label class="form-check-label" for="flexCheckDefault">
              Saturday
              </label>
            </div>
          </div>
          @endif
          <!-- <div class="col-lg-4 col-md-4 col-sm-5 col-10">
            <label for="duration">Start time</label> -->
            @php 
             

              $offset = CustomTimezone::where('name', $cohortbatch->time_zone) ->value('offset');
          
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
              $startHours = date("H", $sTime);
              $startAMPM = "";
              if($startHours == "00") {
                $startHours = 12;
                $startAMPM = "AM";
              } else if($startHours == "12") {
                $startHours = 12;
                $startAMPM = "PM";
              } else if($startHours > 12) {
                $startHours = $startHours - 12;
                $startAMPM = "PM";
              } else {
                $startHours = $startHours;
                $startAMPM = "AM";
              }
              $startMins = date("i", $sTime);
              $endHours = date("H", $eTime);
              $endAMPM = "";
              if($endHours == "00") {
                $endHours = 12;
                $endAMPM = "AM";
              } else if($endHours == "12") {
                $endHours = 12;
                $endAMPM = "PM";
              } else if($endHours > 12) {
                $endHours = $endHours - 12;
                $endAMPM = "PM";
              } else {
                $endHours = $endHours;
                $endAMPM = "AM";
              }
              $endMins = date("i", $eTime);
            @endphp
            <!-- <input type="text" class="form-control" id="duration" name="cohortbatch_starttime" readonly value="{{$startTime}}">
            @if ($errors->has('cohortbatch_starttime'))
              <span class="text-danger">The batch start time is required</span>
            @endif
          </div> -->
          <label for="duration">Start time</label>
          <div class="col-md-2">
            <label for="duration">Hour*</label>
            <input type="number" class="form-control" id="starttime_hour" name="starttime_hour" min="1" max="12" value="{{$startHours}}">
            @if ($errors->has('starttime_hour'))
              <span class="text-danger">The batch start hour is required</span>
            @endif
          </div>
          <div class="col-md-2">
            <label for="duration">Minutes*</label>
            <input type="number" class="form-control" id="starttime_minutes" name="starttime_minutes" min="0" max="59" value="{{$startMins}}">
            @if ($errors->has('starttime_minutes'))
              <span class="text-danger">The batch start minutes is required</span>
            @endif
          </div>
          <div class="col-md-1">
            <label for="duration">AM/PM</label>
            <select class="form-control" name="starttime_ampm">
              <option {{ $startAMPM == 'AM' ? 'selected' : ''}} value="AM">AM</option>
              <option {{ $startAMPM == 'PM' ? 'selected' : ''}} value="PM">PM</option>
            </select>
          </div>
          <!-- <div class="col-lg-4 col-md-4 col-sm-5 col-10">
            <label for="duration">End time</label>
            <input type="text" class="form-control" id="duration" name="cohortbatch_endtime" readonly value="{{$endTime}}">
            @if ($errors->has('cohortbatch_endtime'))
              <span class="text-danger">The batch end time is required</span>
            @endif
          </div> -->

          <label for="duration">End time</label>
          <div class="col-md-2">
            <label for="duration">Hour*</label>
            <input type="number" class="form-control" id="endtime_hour" name="endtime_hour" min="1" max="12" value="{{$endHours}}">
            @if ($errors->has('endtime_hour'))
              <span class="text-danger">The batch end hour is required</span>
            @endif
          </div>
          <div class="col-md-2">
            <label for="duration">Minutes*</label>
            <input type="number" class="form-control" id="endtime_minutes" name="endtime_minutes" min="0" max="59" value="{{$endMins}}">
            @if ($errors->has('endtime_minutes'))
              <span class="text-danger">The batch end minutes is required</span>
            @endif
          </div>
          <div class="col-md-1">
            <label for="duration">AM/PM</label>
            <select class="form-control" name="endtime_ampm">
              <option {{ $endAMPM == 'AM' ? 'selected' : ''}} value="AM">AM</option>
              <option {{ $endAMPM == 'PM' ? 'selected' : ''}} value="PM">PM</option>
            </select>
          </div>
          
          <div class="col-md-5">
            <label for="duration">Timezone*</label>
            <select id="cohortbatch_timezone" name="cohortbatch_timezone" class="form-control" checked value="{{$cohortbatch->time_zone}}">
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
            <input type="text" class="form-control" id="students_count" name="students_count" value="{{$cohortbatch->students_count}}">
            @if ($errors->has('students_count'))
              <span class="text-danger">Number of students in the batch is required</span>
            @endif
          </div>
          <div class="col-12">
            <label for="description">Send an email reminder to students</label>
            
            @foreach($notifications as $notification)
            <div class="form-check">
                <input type="checkbox" value="{{$notification->id}}" name="cohortbatch_notification_{{$notification->id}}" checked>
                <label for="">{{ $notification->description }}</label>
            </div>
            @endforeach
            
          </div>          
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
          <button class="btn btn-primary" id="update_course" type="submit" value="Update">Update</button>
          </div>
          @endforeach
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
  let flag = 0;
  let selectedTimeZone = document.getElementById('cohortbatch_timezone').getAttribute('value');
  document.getElementById('cohortbatch_timezone').value = selectedTimeZone;
  startdate = new dtsel.DTS('input[name="cohortbatch_startdate"]', {
    dateFormat: "mm-dd-yyyy",
    paddingX: 15, paddingY: 15
  });
  enddate = new dtsel.DTS('input[name="cohortbatch_enddate"]', {
    dateFormat: "mm-dd-yyyy",
    paddingX: 15, paddingY: 15
  });
  starttime = new dtsel.DTS('input[name="cohortbatch_starttime"]', {
    paddingX: 15, paddingY: 15,showTime: true, showDate: false
  });
  endtime = new dtsel.DTS('input[name="cohortbatch_endtime"]', {
    paddingX: 15, paddingY: 15,showTime: true, showDate: false
  });

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
      let batchDays = document.getElementsByClassName('cohortbatchday');
      let batchDaysLength = batchDays.length;
      document.querySelector('#batch_name').value = "";
      for(i=0;i<batchDaysLength;i++) {
        const currentItem = batchDays[i];
        if(currentItem.checked) {
            document.querySelector('#batch_name').value += currentItem.value + ',';          
        }
      } 
      let batchName = document.querySelector('#batch_name').value;
      batchName = batchName.substring(0, batchName.length - 1);
      document.querySelector('#batch_name').value = batchName;
    });
  });
  

</script>

@endsection('content')
