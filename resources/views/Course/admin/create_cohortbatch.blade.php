@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<!-- container -->
<div class="container llp-container">
  <div class="row">
  <div class="col-2 position-fixed">
      <!-- include sidebar here -->
      @include('Course.admin.sidebar')
    </div>
    <div class="col-9 ms-auto">
      <!-- main -->
      <main>
      <div class="py-4">
          <h3>Course Title</h3>
          <hr class="my-4">
        </div>
      <div class="py-4">
        <ul class="nav nav-tabs llp-tabs">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('view_cohortbatches', ['course_id' => $course_id]) }}" style="text-decoration:none; color:inherit;">Cohort List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{{ route('create-cohortbatch', ['course_id' => $course_id]) }}" style="text-decoration:none; color:inherit;">New Cohort</a>
          </li>
        </ul>
      </div>
        
        <form action="{{ route('save-cohortbatch') }}" enctype="multipart/form-data" method="POST" class="row g-3 llp-form">
        @csrf
        <input id="course_id" name="course_id" type="hidden" value="{{$course_id}}">

          
          <div class="col-12">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="cohortbatch_title" value="">
            @if ($errors->has('cohortbatch_title'))
              <span class="text-danger">The batch title is required</span>
            @endif
          </div>
          <div class="col-md-6">
            <label for="level">Start date</label>
            <input type="text" class="form-control" id="title" name="cohortbatch_startdate" readonly>
            @if ($errors->has('cohortbatch_startdate'))
              <span class="text-danger">The batch start date is required</span>
            @endif
          </div>
          <div class="col-md-6">
          <label for="level">End date</label>
            <input type="text" class="form-control" id="title" name="cohortbatch_enddate" readonly>
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
          <div class="col-12" id="cohortbatchdaycontainer">
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
          
          <div class="col-md-3">
            <label for="duration">Start time</label>
            <input type="text" class="form-control" id="duration" name="cohortbatch_starttime" readonly>
            @if ($errors->has('cohortbatch_starttime'))
              <span class="text-danger">The batch start time is required</span>
            @endif
          </div>
          <div class="col-md-1">
            <select name="" id="" class="form-control mt-4">
              <option value="AM">AM</option>
              <option value="PM">PM</option>
            </select>
          </div>
          <div class="col-md-3">
            <label for="duration">End time</label>
            <input type="text" class="form-control" id="duration" name="cohortbatch_endtime" readonly>
            @if ($errors->has('cohortbatch_endtime'))
              <span class="text-danger">The batch end time is required</span>
            @endif
          </div>
          <div class="col-md-1">
            <select name="" id="" class="form-control mt-4">
              <option value="AM">AM</option>
              <option value="PM">PM</option>
            </select>
          </div>
          <div class="col-md-4">
            <label for="duration">Timezone</label>
            <select name="cohortbatch_timezone" class="form-control">
    <!-- include timezones here -->
              @include('Course.admin.timezones')
            </select>
            @if ($errors->has('cohortbatch_timezone'))
              <span class="text-danger">The time zone is required</span>
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
          <input class="btn btn-primary" id="save_course" type="submit" value="Save">
          </div>
        </form>
      </main>
    </div>
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
