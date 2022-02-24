@extends('Layouts.app')
@section('content')
<style>
.content-text {
  position: absolute;
    top: 30rem;
    left: 56rem;
    color: rgba(0,0,0,.125);
}
.content-col-div {
  margin-top: 25px;
  margin-left: 13px;
  width: 99.1%;
  padding: 25px 0px 25px 25px;
  border: 2px solid rgba(0,0,0,.125);
  border-radius: 10px;
}
.material_contents {
    border: 1px solid rgb(0 0 0 / 5%);
    padding: 10px 10px;
    margin: 5px 0px;
    border-radius: 5px;
    font-size: 14px;
    font-weight: 500;
    color: rgb(0 0 0 / 47%);
    cursor: pointer;
}
.material_contents.active {
    background-color: #f1eefd;
    color: #000;
}
.material_contents:hover {
    background-color: #f1eefd;
    color: #000;
}
span#ChromelessStatusBar\.LeftDock {
    display: none;
}
span#ChromelessStatusBar\.RightDock {
    display: none;
}
</style>
  <body>
    <input id="session_id" type="hidden" value="{{$session}}" />
    <input id="app_id" type="hidden" value="{{$appId}}" />
    <input id="token" type="hidden" value="{{$token}}" />
    <input id="uid" type="hidden" value="{{$uid}}" />
    <input id="start_time" type="hidden" value="{{$recStartTime}}" />
    <div class="container" style="margin-top:10rem;margin-bottom:5rem;">
      <div class="row" style="padding:35px;box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
        <div class="col-md-5 col-lg-5 col-5">
          <h2 style="text-decoration:underline;">Session: {{$topic}}</h2>
          <small>Course: {{$course}}</small>
          <video class="mt-4 w-100" id="video" controls style="height:30rem;border: 1px solid #e4e4e4;" autoplay></video>
        </div>
        <div class="col-md-7 col-lg-7 col-7" style="margin-top:5.9rem;border: 2px dashed rgba(0,0,0,.125);height:480px;">
        <h2 class="content-text" id="content-text">Content loads here</h2>
        <iframe id="course_content_iframe" src="" width="100%" height="475px" frameborder="0"></iframe>
        </div>
        <div class="col-md-12 col-lg-12 col-12 content-col-div">
          <div class="content-container">
            <h6>Course material</h6>
            @foreach($contents as $content)
                <li class="nav-item material_contents study_materials" data-href="{{ url('/') }}/storage/study_material/{{ $content['topicContentDoc'] }}">
                        {{ $content['topicContentTitle'] }}
                </li>
            @endforeach
          </div>
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

          document.getElementById('video').currentTime = document.getElementById('start_time').value;
        }
    });

      let materialsEle = document.getElementsByClassName('study_materials');
      let materialsCount = materialsEle.length;

      for(index = 0; index < materialsCount; index++) {
          materialsEle[index].addEventListener('click', function(event) {
              document.getElementById('content-text').style.display = "none";
              docUrl = this.getAttribute('data-href');
              let extension = get_url_extension(this.getAttribute('data-href'));
              
              if(extension == "pptx" || extension == "ppt" || extension == "doc" || extension == "docx") {
                document.getElementById('course_content_iframe').setAttribute('src', 'https://view.officeapps.live.com/op/embed.aspx?src=' + docUrl);
              } else if (extension == "pdf") {
                document.getElementById('course_content_iframe').setAttribute('src', docUrl + '#toolbar=0');
              }
              
              for(i=0;i<materialsCount;i++) {
                  materialsEle[i].classList.remove('active');
              }
              this.classList.add('active');
          });
      }
      
      function get_url_extension(url){
        return url.split(/[#?]/)[0].split('.').pop().trim();
      }
    
    </script>
  </body>
  @endsection('content')