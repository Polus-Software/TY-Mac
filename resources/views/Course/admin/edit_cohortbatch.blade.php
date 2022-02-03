@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
@php 
use App\Models\TimeZone;
@endphp
<!-- container -->
<div class="container-fluid llp-container">
  <div class="row">
  <div class="left_sidebar">
      <!-- include sidebar here -->
      @include('Course.admin.view.sidebar')
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
          <h3>Cohort Overview - </h3>
          <hr class="my-4">
        </div>
          <div class="col-12">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="cohortbatch_title" value="{{$cohortbatch->title}}">
            @if ($errors->has('cohortbatch_title'))
              <span class="text-danger">The batch title is required</span>
            @endif
          </div>
          <div class="col-12">
            <label for="batchname">Batchname</label>
            <input type="text" class="form-control" id="batchname" name="batchname" value="{{$cohortbatch->batchname}}">
            @if ($errors->has('batchname'))
              <span class="text-danger">The batch name is required</span>
            @endif
          </div>
         
          <div class="col-md-6">
            <label for="level">Start date</label>
            <input type="text" class="form-control" id="title" name="cohortbatch_startdate" readonly value="{{$cohortbatch->start_date}}">
            @if ($errors->has('cohortbatch_startdate'))
              <span class="text-danger">The batch start date is required</span>
            @endif
          </div>
          <div class="col-md-6">
          <label for="level">End date</label>
            <input type="text" class="form-control" id="title" name="cohortbatch_enddate" readonly value="{{$cohortbatch->end_date}}">
            @if ($errors->has('cohortbatch_enddate'))
              <span class="text-danger">The batch end date is required</span>
            @endif
          </div>
          <label for="batch">Batch</label>
          <input type="hidden" name="cohortbatch_batchname" id="batch_name" value="Daily">
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
          <div class="col-lg-3 col-md-3 col-sm-4 col-9">
            <label for="duration">Start time</label>
            @php 
             

              $offset = TimeZone::where('name', $cohortbatch->time_zone) ->value('offset');
          
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

            @endphp
            <input type="text" class="form-control" id="duration" name="cohortbatch_starttime" readonly value="{{$startTime}}">
            @if ($errors->has('cohortbatch_starttime'))
              <span class="text-danger">The batch start time is required</span>
            @endif
          </div>
          <div class="col-lg-1 col-md-1 col-sm-2 col-3">
            <select name="" id="" class="form-control mt-4">
              <option value="AM">AM</option>
              <option value="PM">PM</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-9">
            <label for="duration">End time</label>
            <input type="text" class="form-control" id="duration" name="cohortbatch_endtime" readonly value="{{$endTime}}">
            @if ($errors->has('cohortbatch_endtime'))
              <span class="text-danger">The batch end time is required</span>
            @endif
          </div>
          <div class="col-lg-1 col-md-1 col-sm-2 col-3">
            <select name="" id="" class="form-control mt-4">
              <option value="AM">AM</option>
              <option value="PM">PM</option>
            </select>
          </div>
          <div class="col-md-4">
            <label for="duration">Timezone</label>
            <select id="cohortbatch_timezone" name="cohortbatch_timezone" class="form-control" checked value="{{$cohortbatch->time_zone}}">
    <!-- include timezones here -->
              @include('Course.admin.timezones')
            </select>
            @if ($errors->has('cohortbatch_timezone'))
              <span class="text-danger">The time zone is required</span>
            @endif
          </div>
          <div class="col-md-3">
            <label for="students_count">No. of students</label>
            <input type="text" class="form-control" id="students_count" name="students_count" value="{{$cohortbatch->students_count}}">
            @if ($errors->has('students_count'))
              <span class="text-danger">Number of students in the batch is required</span>
            @endif
          </div>
          <div class="col-12">
            <label for="description">Notification</label>
            
            @foreach($notifications as $notification)
            <div class="form-check">
                <input type="checkbox" value="{{$notification->id}}" name="cohortbatch_notification" checked>
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
  let selectedTimeZone = document.getElementById('cohortbatch_timezone').getAttribute('value');
  document.getElementById('cohortbatch_timezone').value = selectedTimeZone;
  startdate = new dtsel.DTS('input[name="cohortbatch_startdate"]', {
    paddingX: 15, paddingY: 15
  });
  enddate = new dtsel.DTS('input[name="cohortbatch_enddate"]', {
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
      const currentItem = e.currentTarget;
        if(currentItem.checked) {
          customValue.push(currentItem.value);
        } else {
          if(customValue.indexOf(currentItem.value) != -1) {
            customValue.splice(customValue.indexOf(currentItem.value), 1);
          }

        }
        document.querySelector('#batch_name').value = customValue;
    });
  })

</script>

@endsection('content')
