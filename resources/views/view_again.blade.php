@extends('Layouts.app')
@section('content')

  <body>
    <input id="session_id" type="hidden" value="{{$session}}" />
    <input id="app_id" type="hidden" value="{{$appId}}" />
    <input id="token" type="hidden" value="{{$token}}" />
    <input id="uid" type="hidden" value="{{$uid}}" />
    <div class="container" style="margin-top:10rem;margin-bottom:5rem;">
      <div class="row" style="padding:35px;box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
        <div class="col-md-8 col-lg-8 col-8 m-auto">
          <h2 style="text-decoration:underline;">Session: {{$topic}}</h2>
          <small>Course: {{$course}}</small>
          <video class="mt-4 w-100" id="video" controls style="height:30rem;border: 1px solid #e4e4e4;" autoplay></video>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="{{ asset('/assets/hls.min.js') }}"></script>
    <script>
    let roomId = document.getElementById('session_id').value;
    let appId = document.getElementById('app_id').value;
    let token = document.getElementById('token').value;
    let uid = document.getElementById('uid').value;


    let getRecordPath = "https://api.agora.io/edu/apps/"+appId+"/v2/rooms/"+roomId+"/records";
    fetch(getRecordPath, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'retryTimeout': 60, 
        'mode': 'no-cors',
        'x-agora-token':token,
        'x-agora-uid':uid
      },
    }).then((response) => response.json()).then((fdata) => {
      console.log(fdata.data.list[0]);
        if(fdata.data.list[0].roomUuid == roomId) {
          let url = fdata.data.list[0].url;
          console.log(url);
          ((source) => {
            if (typeof Hls == "undefined") return console.error("HLS Not Found");
            if (!document.querySelector("video")) return;
            var hls = new Hls();
            hls.loadSource(source);
            hls.attachMedia(document.querySelector("video"));
          })(url);
        }
    });
      
    </script>
  </body>
  @endsection('content')