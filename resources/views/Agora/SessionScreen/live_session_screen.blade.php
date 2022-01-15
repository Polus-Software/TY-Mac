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
    height: 67.5%;
    top: 55px;
    margin: 25px 0px 25px 175px;
    width: 106.5%;
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
    position: relative;
    left: -34.2em;
    top: 80px;
}
.layout {
    background: transparent;
}
.layout-aside {
    width: 54rem !important;
}

.video-player.big-class-teacher {
  width: 80% !important;
  height: 30rem !important;
}

.video-marquee-pin.big-class {
  position: relative;
  left: 54.3rem;
    width: 250px;
    top: 5.15rem;
}

#back_to_course {
    border: 1px solid #6E7687;
    padding: 6px 25px;
    border-radius: 5px;
    font-size: 14px;
    font-family: 'Roboto', sans-serif;
    font-weight: bold;
    color: #414855;
}

#show_video {
  border: 1px solid #6E7687;
    padding: 6px 25px;
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
.row {
    padding: 10px 10px 10px 181px;
    display: inline-flex;
    width: 57.95%;
    position: relative;
    top: -40rem;
    height: 600px;
}

.row1 {
    padding: 10px 10px 10px 175px;
    display: inline-flex;
    width: 100%;
    position: relative;
    top: -46rem;
}

.row2 {
    padding: 20px 20px 20px 20px;
    width: 45.5%;
    position: relative;
    top: -46rem;
    border-radius: 10px;
    margin-left: 180px;
    border: 1px solid #e5e7eb;
}
.col12 {
  display: -webkit-inline-box;
    padding: 23px 0rem 23px 21.7rem;
    width: 45rem;
    position: relative;
    left: -191px;
    top: -10px;
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
    top: 0px !important;
    width: 375px;
    height: 90vh;
    margin: 125px 10px 0px 10px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 10px;
}

.pin-right {
    right: -30em;
    bottom: 75px !important;
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

.nodisplay {
  display : none;
}

.course_contents_div {
  margin-bottom : 20px;
}

.course_contents {
    border: 1px solid #6E7687;
    padding: 3px 16px;
    border-radius: 5px;
    font-size: 14px;
    font-family: 'Roboto', sans-serif;
    font-weight: bold;
    background-color: #74648c !important;
    color: white !important;
    position: relative;
    right: -31.5rem;
}
.course_contents:hover {    
    color: #414855 !important;
    background-color: white !important;
    transition-duration: 0.2s;
}

.nodisplay {
  display:none;
}
  </style>

  <input id="session_hidden_id" type="hidden" value="{{ $session }}" />
  <input id="user_type" type="hidden" value="{{ $userType }}" />
  <div class="tab-container">
    <div id="root1"></div>

    <div class="tab-contents nodisplay">
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#participants">Participants List</a></li>
        <li><a data-toggle="tab" href="#chat">Chat</a></li>
      </ul>
      <div class="tab-content">
        <div id="participants" class="tab-pane fade in active">
        @foreach($participants as $participant)
        <p style="color:black;margin-top:5px;">{{ $participant }}</p>
        @endforeach
        </div>
        <div id="chat" class="tab-pane fade">
        <div id="chat_messages">
          <p>John Doe:<span> Hi, my name is John! :)</span></p>
          <p>Ashish Thoppil:<span> Hi, my name is Ashish</span></p>
          <p>Instructor:<span> Hello everyone!</span></p>
          <p>John Doe:<span> Nice to meet you all.</span></p>
        </div>
        <textarea id="live_chat_text" placeholder="Enter your message.."></textarea>
        <button id="send_live_message">Send</button>
        </div>
      </div>
    </div>
  </div>
<div id="feedback-container" class="nodisplay">
  @if($userType == 'student')
  <div class="row"></div>
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
  <div class="row">
      <iframe class="nodisplay" id="course_content_iframe" src="" width='100%' height='500px' frameborder='0'></iframe>
  </div>
  <div class="row1">
    <div class="col11">
      <button id="back_to_course">Back to course</button> <button class="nodisplay" id="show_video">Show video</button>
    </div>
  </div>
  <div class="row2" style="margin-bottom:20px;">
    <h6 class="notif-text">Session Info</h6>
    <hr>
    <p class="notif-text">{{ $topic_title }}</p>
    @csrf
    
    
    <div class="course_contents_div" data-id="1" style="margin-top:5px;"><i style="margin-right:10px;" class="thumbs fas fa-circle"></i><span>Content 1</span><button class="course_contents" href="/storage/content_documents/sample.pdf" data-id="1">Start</button></div>
    <div class="course_contents_div" data-id="2" style="margin-top:5px;"><i style="margin-right:10px;" class="thumbs fas fa-circle"></i><span>Content 2</span><button class="course_contents" href="https://scholar.harvard.edu/files/torman_personal/files/samplepptx.pptx" data-id="2">Start</button></div>
    <div class="course_contents_div" data-id="3" style="margin-top:5px;"><i style="margin-right:10px;" class="thumbs fas fa-circle"></i><span>Content 3</span><button class="course_contents" href="/storage/content_documents/sample.pdf" data-id="3">Start</button></div>
    
  </div>

@endif
</div>
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
          if(data.rolename == "Instructor") {
              document.getElementById('user_type').value = data.rolename;
          }
          
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
        }
      }
    )

        });
        
let timer = 0;

$(document).ready(function(){
  var start = new Date;
  let sessionId = document.getElementById('session_hidden_id').value;
  setInterval(function() {
      timer = Math.round((new Date - start) / 1000);
      let path = "{{ route('get-attendance-list') }}?session=" + sessionId;
      fetch(path, {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          "X-CSRF-Token": document.querySelector('input[name=_token]').value
        },
      }).then((response) => response.json()).then((data) => {
        document.getElementById("participants").innerHTML = data.html;
      });
  }, 1000);
});

$(document).on('click', '.btn:contains("Finish")', function() {
    $('.tab-contents').removeClass('nodisplay');
    $('#feedback-container').removeClass('nodisplay');
});
$(document).on('click', '.btn:contains("Confirm")', function() {
  let sessionId = document.getElementById('session_hidden_id').value;
  let userType = document.getElementById('user_type').value;

  if(userType == "student") {
    let path = "{{ route('student-exit') }}?sessionId=" + sessionId + "&timer=" + timer;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
    }).then((response) => response.json()).then((data) => {
      window.location.replace("/enrolled-course/" + data.course_id);
    });
  }
});


window.addEventListener("beforeunload", function (e) {
  var confirmationMessage = "Are you sure you want to exit?";
  let sessionId = document.getElementById('session_hidden_id').value;
  let userType = document.getElementById('user_type').value;

  if(userType == "student") {
    let path = "{{ route('student-exit') }}?sessionId=" + sessionId + "&timer=" + timer;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
    }).then((response) => response.json()).then((data) => {

    });
  }
  (e || window.event).returnValue = confirmationMessage; //Gecko + IE
  return confirmationMessage;                            //Webkit, Safari, Chrome
});



jQuery(".nav-tabs li").click(function(e){
      e.preventDefault();
      jQuery(".nav-tabs li").removeClass('active');
      jQuery(this).addClass('active');
      let tid=  jQuery(this).find('a').attr('href');
      console.log("ID:"+tid);
      jQuery('.tab-pane').removeClass('active in');
      jQuery(tid).addClass('active in');
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
  
if(document.getElementById('show_video')) {
  document.getElementById('show_video').addEventListener('click', function(event){
    document.getElementById('course_content_iframe').classList.add('nodisplay');
    document.getElementById('show_video').classList.add('nodisplay'); 
  });
}
  

let contentEle = document.getElementsByClassName('course_contents');
length = contentEle.length;

for(index = 0; index < length;index++) {
  
    contentEle[index].addEventListener('click', function(event) {
    let extension = get_url_extension(this.getAttribute('href'));
    console.log(document.getElementById('user_type').value == "Instructor");
    if(document.getElementById('user_type').value == "Instructor") {
      document.getElementsByClassName('board-section')[0].classList.add('nodisplay');
    }
    if(extension == "pdf") {
      document.getElementById('course_content_iframe').classList.remove('nodisplay');
      document.getElementById('show_video').classList.remove('nodisplay');
      document.getElementById('course_content_iframe').setAttribute('src', this.getAttribute('href'));
    } else if (extension == "pptx") {
      document.getElementById('course_content_iframe').classList.remove('nodisplay');
      document.getElementById('show_video').classList.remove('nodisplay');
      
      
      document.getElementById('course_content_iframe').setAttribute('src', 'https://view.officeapps.live.com/op/embed.aspx?src=https://scholar.harvard.edu/files/torman_personal/files/samplepptx.pptx');
    }
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
  });
});

function get_url_extension(url){
    return url.split(/[#?]/)[0].split('.').pop().trim();
}

  </script>
</body>

</html>

