@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
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
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
          <h3>Filter settings</h3>
        </div>
        <div class="row mt-4">
        <div class="col-4 col-sm-4 col-md-4 p-3">
          @csrf
          @foreach($filters as $filter)
            <div class="form-check form-switch">
                <input class="form-check-input filter_switch" filter_id="{{$filter->id}}" type="checkbox" @if($filter->is_enabled == true) checked=checked @endif>
                <label class="form-check-label" for="flexSwitchCheckDefault">{{$filter->filter_name}}</label>
            </div>
          @endforeach
          </div>
        </div>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
          <h3>Recommendation engine settings</h3>
        </div>
        <div class="row mt-4">
          <div class="col-2 col-sm-2 col-md-2 p-3">
            <div class="form-group">
              <label for="threshold">Threshold (In %) :</label>
              <input id="threshold" type="text" class="form-control mt-3" />
              <button class="btn btn-secondary mt-2" id="threshold-save">Save</button>
              <label style="color:green;" id="threshold-success-msg"></label>
            </div>
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
      let path = "{{ route('save-threshold')}}?value=" + threshold;
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
