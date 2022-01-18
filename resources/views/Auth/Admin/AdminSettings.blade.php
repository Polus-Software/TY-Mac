@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')

<style>
.grow-wrap {
  /* easy way to plop the elements on top of each other and have them both sized based on the tallest one's height */
  display: grid;
}
.grow-wrap::after {
  /* Note the weird space! Needed to preventy jumpy behavior */
  content: attr(data-replicated-value) " ";

  /* This is how textarea text behaves */
  white-space: pre-wrap;

  /* Hidden from view, clicks, and screen readers */
  visibility: hidden;
}
.grow-wrap > textarea {
  /* You could leave this, but after a user resizes, then it ruins the auto sizing */
  resize: none;

  /* Firefox shows scrollbar on growth, you can hide like this. */
  overflow: hidden;
}
.grow-wrap > textarea,
.grow-wrap::after {
  /* Identical styling required!! */
  border: 1px solid black;
  padding: 0.5rem;
  font: inherit;

  /* Place on top of each other */
  grid-area: 1 / 1 / 2 / 2;
}
</style>
<!-- container -->
<div class="container llp-container">
  <div class="row">
    <div class="col-2 position-fixed">
      <!-- include sidebar here -->
      @include('Layouts.admin.sidebar')
    </div>
    <div class="col-9 ms-auto">
      <!-- main -->
      <main>
        
        <div class="row mt-4">
        <div class="col-6 col-sm-6 col-md-6 p-3">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
          <h3>Filter settings</h3>
        </div>
          @csrf
          @foreach($filters as $filter)
            <div class="form-check form-switch">
                <input class="form-check-input filter_switch" filter_id="{{$filter->id}}" type="checkbox" @if($filter->is_enabled == true) checked=checked @endif>
                <label class="form-check-label" for="flexSwitchCheckDefault">{{$filter->filter_name}}</label>
            </div>
          @endforeach
          </div>
        <!-- </div> -->

        
        <!-- <div class="row mt-4"> -->
          <div class="col-6 col-sm-6 col-md-6 p-3">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
          <h3>Recommendation engine settings</h3>
        </div>
            <div class="form-group">
              <label for="threshold">Threshold (In %) :</label>
              <input id="threshold" type="text" class="form-control mt-3" value="{{ $rec }}"/>
            </div>
          </div>
        </div>



        <div class="row mt-4">
          <div class="col-6 col-sm-6 col-md-6 p-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h3>Feedback survey questions</h3>
            </div>
            <div class="form-group">
              <label for="question_1">Question 1</label>
              <textarea id="question_1" type="text" class="form-control mt-3">{{ $f1Question }}</textarea>
              <label for="question_2">Question 2</label>
              <textarea id="question_2" type="text" class="form-control mt-3">{{ $f2Question }}</textarea>
              <!-- <button class="btn btn-secondary mt-3" id="survey-questions-save">Save</button>
              <label style="color:green;" id="survey-success-msg"></label> -->
            </div>
          </div>

          <div class="col-6 col-sm-6 col-md-6 p-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h3>Live session attendance settings</h3>
            </div>
            <div class="form-group">
              <label for="attendance">Minimum time required for attendance to be tracked (in %)</label>
              <input id="attendance" type="text" class="form-control mt-3" value="{{ $attendanceSetting }}"/>
              <!-- <button class="btn btn-secondary mt-3" id="survey-questions-save">Save</button>
              <label style="color:green;" id="survey-success-msg"></label> -->
            </div>
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
      let attendance = document.getElementById('attendance').value;
      let path = "{{ route('save-threshold')}}?threshold=" + threshold + "&feedback1=" + feedbackQues1 + "&feedback2=" + feedbackQues2 + "&attendance=" + attendance;
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
