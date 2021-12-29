<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Live Session</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://download.agora.io/edu-apaas/release/edu_sdk_1.1.5.10.js"></script>
</head>

<body>
  <style>
    #root1 {
      width: 100%;
      height: 100% !important;
    }

.chat-panel.chat-border {
    display: none;
}
.zoom-controller.zoom-position {
    display: none;
}
.board-section {
    position: relative;
    height: 70%;
    margin: 25px 0px 25px 175px;
    width: 52%;
    z-index: 1;
    overflow: hidden;
}
.whiteboard { 
    border: transparent;
    border-radius: 0px;
    background: white;
}
svg.svg-img.prefix-select {
    display: none;
}
svg.svg-img.prefix-clicker {
    display: none;
}
svg.svg-img.prefix-triangle-down.triangle-icon {
    display: none;
}
svg.svg-img.prefix-pen {
    display: none;
}
svg.svg-img.prefix-text {
    display: none;
}
svg.svg-img.prefix-eraser {
    display: none;
}
.circle-border {
    display: none;
}
svg.svg-img.prefix-blank-page {
    display: none;
}
svg.svg-img.prefix-hand {
    display: none;
}
svg.svg-img.prefix-cloud {
    display: none;
}
svg.svg-img.prefix-register {
    display: none;
}
svg.svg-img.prefix-tools {
    position: absolute;
    top: -90px;
}
.popover.expand-tools-popover.popover-placement-right {
    top: 130px !important;
}
.toolbar-position {
    max-height: 90px !important;
}


aside.layout-aside.big-class-aside {
    position: absolute;
    left: 175px;
    top: 80px;
}

.layout-aside {
    width: 60rem !important;
}

.video-player.big-class-teacher {
  width: 90% !important;
  height: 34rem !important;
}

.video-marquee-pin.big-class {
  position: relative;
    left: 65.3rem;
    top: 5.15rem;
}

#back_to_course {
  border: 1px solid #6E7687;
    padding: 7px 14px;
    border-radius: 5px;
    font-size: 14px;
    font-family: 'Roboto', sans-serif;
    font-weight: bold;
    color: #414855;
}

.notif-text{
  font-size: 14px;
  font-family: 'Roboto', sans-serif;
  font-weight: bold;
  color: #6E7687;
  margin-top: 10px !important;
}


.row1 {
    padding: 10px 10px 10px 175px;
    display: inline-flex;
    width: 61.75%;
    position: relative;
    top: -150px;
}
.row2 {
    padding: 10px 10px 10px 10px;
    width: 50.75%;
    position: relative;
    top: -150px;
    border-radius: 10px;
    margin-left: 180px;
    border: 1px solid #6E7687;
}
.col12 {
  display: -webkit-inline-box;
    padding: 23px 0rem 23px 21.7rem;
    width: 45rem;
}
.col11 {
    padding: 15px 3px;
}

.feedbackbtn {
  margin-left: 10px;
    border: 1px solid #6E7687;
    padding: 7px 15px;
    border-radius: 5px;
}

.thumbs {
  color: #6E7687;
}

/* Tabs CSS */


ul.nav.nav-tabs {
    clear: both;
}
ul.nav.nav-tabs li {
    list-style: none;
    float: left;
}   
.nav>li>a {
    position: relative;
    display: block;
    padding: 10px 15px;
}
    .nav {
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
}     
          .nav-tabs>li>a {
    margin-right: 2px;
    line-height: 1.42857143;
    border: 1px solid transparent;
    border-radius: 4px 4px 0 0;
}
.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
    color: #555;
    cursor: default;
    background-color: #fff;
    
    border: transparent;
    border-bottom: 1px solid #ddd;
}
.nav>li {
    position: relative;
    display: block;
}
.nav-tabs>li {
    float: left;
    margin-bottom: -1px;
}
.nav:after, .nav:before, .navbar-collapse:after, .navbar-collapse:before, .navbar-header:after, .navbar-header:before, .navbar:after, .navbar:before, .pager:after, .pager:before, .panel-body:after, .panel-body:before, .row:after, .row:before {
    display: table;
    content: " ";
}
.nav:after, .navbar-collapse:after, .navbar-header:after, .navbar:after, .pager:after, .panel-body:after, .row:after {
    clear: both;
}   
.nav-tabs {
  justify-content: center;
    display: flex;
} 
.tab-pane:not(.active) {
    display: none;
}       

.main-container {
    display: flex;
}
.tab-contents {
  position: absolute;
    right: 0px;
    width: 375px;
    height: 90vh;
    margin: 125px 10px 0px 10px;
    border: 1px solid #6E7687;
    border-radius: 10px;
    padding: 10px;
}

.pin-right {
  right: 470px !important;
}

#positive {
  background-color: #74648c !important;
  color: white !important;
}

svg.svg-img.prefix-record.can-hover {
  display:none;
}

svg.svg-img.prefix-more.can-hover {
    display: none;
}

.unclickable {
  display: none;
}

.pulsate {
  -webkit-animation: pulse 1.5s infinite;
}
  </style>
  <input id="session_hidden_id" type="hidden" value="{{ $session }}" />
  <div class="main-container">
  <div id="root1"></div>
    
  <div class="tab-contents">
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#participants">Participants</a></li>
    <li><a data-toggle="tab" href="#chat">Chat</a></li>
  </ul>
  <div class="tab-content">
    <div id="participants" class="tab-pane fade in active">
     <p>Participants list </p>
    </div>
    <div id="chat" class="tab-pane fade">
     <p> Chat screen </p>
    </div>
  </div>
</div>
  </div>
  
  @if($userType == 'student')
  <div class="row1">
    <div class="col11">
      <button id="back_to_course">Back to course</button>
    </div>
    <div class="col12">
      <p class="notif-text">Did you understand this topic?</p> <button data-id="" class="feedbackbtn" id="positive" style="font-size: 14px;font-family: 'Roboto', sans-serif;font-weight: bold;color: #6E7687;"><i style="margin-right:10px;" class="fas fa-thumbs-up"></i>Yes <span id="positive_count"></span></button> <button class="feedbackbtn" id="negative" style="font-size: 14px;font-family: 'Roboto', sans-serif;font-weight: bold;color: #6E7687;" data-id=""><i style="margin-right:10px;" class="fas fa-thumbs-down"></i>No<span id="negative_count"></span></button>
    </div>
  </div>
  <div class="row2" style="margin-bottom:20px;">
    <h6 class="notif-text">Session Info</h6>
    <hr>
    @csrf
    <p class="notif-text">{{ $topic_title }}</p>
    @foreach($contents as $content)
    <div style="margin-top:5px;"><i style="margin-right:10px;" class="thumbs fas fa-thumbs-up"></i>{{ $content->topic_title }}</div>
    @endforeach
  </div>
  @elseif($userType == 'instructor')
  <div class="row1">
    <div class="col11">
      <button id="back_to_course">Back to course</button>
    </div>
  </div>
  <div class="row2" style="margin-bottom:20px;">
    <h6 class="notif-text">Session Info</h6>
    <hr>
    <p class="notif-text">{{ $topic_title }}</p>
    @csrf
    @foreach($contents as $content)
    <div data-id="{{ $content->topic_content_id }}" class="course_contents" style="margin-top:5px;"><i style="margin-right:10px;" class="thumbs fas fa-thumbs-up"></i><a href="/storage/content_documents/sample.pdf" target="_blank" data-id="{{ $content->topic_content_id }}">{{ $content->topic_title }}</a></div>
    @endforeach
  </div>
@endif
  <script type="text/javascript">
        
        let session = document.getElementById('session_hidden_id').value;
        
        let path = "/generate-token/" + session;
        fetch(path, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
        }).then((response) => response.json()).then((data) => {
            AgoraEduSDK.config({
           // Here pass in the Agora App ID you have got
           appId: data.appId,
           })
    AgoraEduSDK.launch(
      document.querySelector("#root1"), {
        // Here pass in the RTM token you have generated
        rtmToken: data.token,
        // The user ID must be the same as the one you used for generating the RTM token
        userUuid: data.uid,
        userName: data.rolename,
        roomUuid: data.roomid,
        roomName: data.channel,
        roleType: data.role,
        roomType: 2,
        pretest: true,
        language: "en",
        startTime: new Date().getTime(),
        duration: data.duration,
        courseWareList: [],
        listener: (evt) => {
          console.log("evt", evt)
        }
      }
    )

        });


 jQuery(document).ready(function(){

//    jQuery('.course_contents').addClass('unclickable');
// document.getElementsByClassName('course_contents')[0].classList.remove("unclickable");

 jQuery(".nav-tabs li.active").click(); 
 jQuery(".nav-tabs li").click(function(e){
      e.preventDefault();
      jQuery(".nav-tabs li").removeClass('active');
      jQuery(this).addClass('active');
      let tid=  jQuery(this).find('a').attr('href');
      console.log("ID:"+tid);
      jQuery('.tab-pane').removeClass('active in');
      jQuery(tid).addClass('active in');
  });
});

setInterval(function () {
  let session = document.getElementById('session_hidden_id').value;
    let path = "{{ route('get-push-record') }}?session=" + session;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
    }).then((response) => response.json()).then((data) => {
      if(data.content_id != null) {
      document.getElementById('positive').setAttribute('data-id', data.content_id);
      document.getElementById('positive').classList.add('pulsate');
      document.getElementById('negative').setAttribute('data-id', data.content_id);
      document.getElementById('negative').classList.add('pulsate');
      }
    });
  }, 2000);

let contentEle = document.getElementsByClassName('course_contents');
length = contentEle.length;

for(index = 0; index < length;index++) {
    contentEle[index].addEventListener('click', function(event) {
        // this.classList.add('unclickable');
        // console.log(this.nextElementSibling.classList);
        // this.nextSibling.classList.replace("unclickable", "");
    let topicContentId = this.getAttribute('data-id');
    let path = "{{ route('push-live-record') }}?content_id=" + topicContentId;
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


document.getElementById('positive').addEventListener('click', function(event) {

  let content = this.getAttribute('data-id');
  let path = "{{ route('push-feedbacks') }}?content_id=" + content + "&type=positive";
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
        document.getElementById('positive_count').innerHTML = "(" + data.positive + ")";
        document.getElementById('negative_count').innerHTML = "(" + data.negative + ")";
    });
});

document.getElementById('negative').addEventListener('click', function(event) {

let content = this.getAttribute('data-id');
let path = "{{ route('push-feedbacks') }}?content_id=" + content + "&type=negative";
  fetch(path, {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      "X-CSRF-Token": document.querySelector('input[name=_token]').value
    },
    body: JSON.stringify({})
  }).then((response) => response.json()).then((data) => {
    document.getElementById('positive_count').innerHTML = "(" + data.positive + ")";
    document.getElementById('negative_count').innerHTML = "(" + data.negative + ")";
  });
});

    

  </script>
</body>

</html>

