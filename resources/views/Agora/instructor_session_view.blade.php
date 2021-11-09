@extends('Layouts.Profile')
@section('content')

<div class="container">
  <div class="custom-container mx-auto border">
    <div class="row">                    
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:12em;">
          @csrf
              <button id="host-session" class="btn btn-primary">Host Session</button>
          </div>
      </div>
  </div>
</div>
<script>
    document.getElementById('host-session').addEventListener('click', function(event) {
        window.location.replace("/host-session");
    });
</script>
@endsection('content')