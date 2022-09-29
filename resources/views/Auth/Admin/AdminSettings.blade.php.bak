@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<style>
  #snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #74648C;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}
</style>
<div id="snackbar"></div>
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
                  <small><i class="fa fa-info-circle"></i> If a live session topic has 5 subcontents and a students gives 3 negative and 2 positive
                votes out of the 5, then the percentage of negative votes is calculated and compared with the recommendation threshold value. If it is less than
               the threshold value, then only the subcontents with the negative votes are recommended. If the percentage is higher than threshold then all the subcontents
               in that live session are recommended to the student. the same goes for the instructor as well.</thead> </small>
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
              <div class="mb-3">
                <label for="question_1">Question 1</label>
                <textarea id="question_1" type="text" class="form-control mt-3">{{ $f1Question }}</textarea>
              </div>
              <div class="mb-3">
                <label for="question_2">Question 2</label>
                <textarea id="question_2" type="text" class="form-control mt-3">{{ $f2Question }}</textarea>
              </div>
              <div class="">
                <label for="question_3">Question 3</label>
                <textarea id="question_3" type="text" class="form-control mt-3">{{ $f3Question }}</textarea>
              </div>
              
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
            document.getElementById('snackbar').innerHTML = data.message;
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
          } else {
            document.getElementById('snackbar').innerHTML = data.message;
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
          }
        });
  });
  
</script>

@endsection('content')
