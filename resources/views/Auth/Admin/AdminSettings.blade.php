@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')

<!-- container -->
<div class="container-fluid llp-container">
  <div class="row">
    <div class="left_sidebar">
      <!-- include sidebar here -->
      @include('Layouts.admin.sidebar')
    </div>
    <div class="col-8 right_card_block">
      <!-- main -->
      <main>
        
        <div class="row mt-4">
        

        <div class="col-6 col-sm-6 col-md-6 p-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 titles_outer">
                <h3 class="titles">Live session attendance settings</h3>
            </div>
            <div class="form-group">
              <label for="attendance">Minimum time required for attendance to be tracked (in %)</label>
              <input id="attendance" type="text" class="form-control mt-3" value="{{ $attendanceSetting }}"/>
              <div class="info-text mt-2">
                  <small><i class="fa fa-info-circle"></i> If a scheduled live session has a duration of 1 hour and this setting is set to 50%, then if a student
                that attends the live session decides to drop off before the 30 minute mark, then that student is marked as absent, since 30 minutes is 50% of an hour.</small>
              </div>
              <!-- <button class="btn btn-secondary mt-3" id="survey-questions-save">Save</button>
              <label style="color:green;" id="survey-success-msg"></label> -->
            </div>
          </div>
        <!-- </div> -->

        
        <!-- <div class="row mt-4"> -->
          <div class="col-6 col-sm-6 col-md-6 p-3">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 titles_outer">
          <h3 class="titles">Recommendation engine settings</h3>
        </div>
            <div class="form-group">
              <label for="threshold">Threshold (In %) :</label>
              <input id="threshold" type="text" class="form-control mt-3" value="{{ $rec }}"/>
              <div class="info-text mt-2">
                  <small><i class="fa fa-info-circle"></i> Threshold percentage is used to determine which contents under a subtopic
                are to be recommended to a student. If the percentage of the number of dislikes given by a student to contents within a subtopic out of 
              all the contents in the subtopic, exceeds the threshold value, then all the contents are recommended to the student. If the percentage is less than 
            the threshold, then only the contents that received the negative feedbacks are recommended to that particular student.</thead> </small>
              </div>
              
            </div>
          </div>
        </div>



        <div class="row mt-4">
          <div class="col-6 col-sm-6 col-md-6 p-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 titles_outer">
                <h3 class="titles">Feedback survey questions</h3>
            </div>
            <div class="form-group">
              <label for="question_1">Question 1</label>
              <textarea id="question_1" type="text" class="form-control mt-3">{{ $f1Question }}</textarea>
              <label for="question_2">Question 2</label>
              <textarea id="question_2" type="text" class="form-control mt-3">{{ $f2Question }}</textarea>
              <label for="question_3">Question 3</label>
              <textarea id="question_3" type="text" class="form-control mt-3">{{ $f3Question }}</textarea>
              <!-- <button class="btn btn-secondary mt-3" id="survey-questions-save">Save</button>
              <label style="color:green;" id="survey-success-msg"></label> -->
            </div>
          </div>

          <div class="col-6 col-sm-6 col-md-6 p-3">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 titles_outer">
          <h3 class="titles">Filter settings</h3>
        </div>
          @csrf
          @foreach($filters as $filter)
            <div class="form-check form-switch">
                <input class="form-check-input filter_switch" filter_id="{{$filter->id}}" type="checkbox" @if($filter->is_enabled == true) checked=checked @endif>
                <label class="form-check-label" for="flexSwitchCheckDefault">{{$filter->filter_name}}</label>
            </div>
          @endforeach
        </div>

        </div>

        <div class="row mt-4">
        <div class="col-10 col-sm-10 col-md-10 p-3 float-end">
                
          </div>
          <div class="col-2 col-sm-2 col-md-2 p-3">
                <label style="color:green;" id="threshold-success-msg"></label> 
                <button class="btn btn-secondary mt-2 w-100" id="threshold-save">Save</button>
          </div>
        </div>
      </main>
      <!-- main ends -->

    </div>
	<div class="col-1"></div>
  </div>
</div>
<!-- container ends -->



<script>
  let filter_switch = document.getElementsByClassName('filter_switch');
  for(var index = 0; index < filter_switch.length; index++) {
    filter_switch[index].addEventListener('change', function(event) {
        let filter = this.getAttribute('filter_id');
        let isEnabled = this.checked;
        let path = "{{ route('change-filter-status')}}?filter_id=" + filter + "&is_enabled=" + isEnabled;
        fetch(path, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            "X-CSRF-Token": document.querySelector('input[name=_token]').value
        },
        body: JSON.stringify({})
        }).then((response) => response.json()).then((data) => {
          
        });
    });
  }

  document.getElementById('threshold-save').addEventListener('click', function(event) {
      let threshold = document.getElementById('threshold').value;
      let feedbackQues1 = document.getElementById('question_1').value;
      let feedbackQues2 = document.getElementById('question_2').value;
      let feedbackQues3 = document.getElementById('question_3').value;
      let attendance = document.getElementById('attendance').value;
      let path = "{{ route('save-threshold')}}?threshold=" + threshold + "&feedback1=" + feedbackQues1 + "&feedback2=" + feedbackQues2 + "&feedback3=" + feedbackQues3 + "&attendance=" + attendance;
        fetch(path, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            "X-CSRF-Token": document.querySelector('input[name=_token]').value
        },
        body: JSON.stringify({})
        }).then((response) => response.json()).then((data) => {
          if(data.status == "success") {
              document.getElementById('threshold-success-msg').innerHTML = data.message;
          } else {
            document.getElementById('threshold-success-msg').innerHTML = data.message;
          }
        });
  });
  
</script>

@endsection('content')
