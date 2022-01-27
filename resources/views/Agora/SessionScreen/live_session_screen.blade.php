<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Live Session</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
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
    left: 65.3rem;
    top: 5.15rem;
}

/* #back_to_course {
    border: 1px solid #6E7687;
    padding: 6px 25px;
    border-radius: 5px;
    font-size: 14px;
    font-family: 'Roboto', sans-serif;
    font-weight: bold;
    color: #414855;
} */

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
  font-family: 'Roboto', sans-serif;
  font-weight: bold;
  margin-top: 10px !important;
}
/* .row {
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
} */
/* .feedback-btn-container {
  display: -webkit-inline-box;
    padding: 23px 0rem 23px 21.7rem;
    width: 45rem;
    position: relative;
    left: -191px;
    top: -10px;
}
.back-to-course-btn {
    padding: 15px 3px;
} */

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


/* ul.nav.nav-tabs {
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
}  */
.tab-pane:not(.active) {
    display: none;
}       

.main-container {
    display: flex;
}
.tab-contents {
  position: relative;
    /* right: 0px; */
    width: 300px;
    /* height: 100%; */
    /* margin: 125px 10px 0px 10px; */
    border: 1px solid #e5e7eb;
    border-radius: 0 0 10px 10px;
    padding: 0;
    grid-row: span 2;
}

/* #positive {
  background-color: #F5F3FF !important;
  color: #74648C !important;
  border: 1px solid #74648C;
} */

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
  visibility : hidden !important;
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

/* Author tinu */
* {
  font-family: 'Roboto', sans-serif;
}
/* Utilities */
.font-lato {
  font-family: 'Lato', sans-serif !important;
}
.font-roboto {
  font-family: 'Roboto', sans-serif !important;
}
.think-fs--18 {
font-size: 18px;
}
.think-fs--16 {
font-size: 16px;
}
.think-fs--14{
font-size: 14px;
}
.think-color-dark {
  color: #2C3443 !important;
}
.think-color-light-dark {
  color: #6E7687;
}
.think-btn-secondary-outline-live.like-button {
	background-color: #F5F3FF !important;
	color: #74648C !important;
	border: 1px solid #E7D6FF !important;
}
.think-btn-secondary-outline-live.like-button:hover {
	background-color: #74648C !important;
	color: #fff !important;
	border: 1px solid #74648C !important;
}
.think-btn-secondary-outline-live.dislike-button {
	background-color: #ffefef !important;
	color: #a00 !important;
	border: 1px solid #ffefef !important;
}
.think-btn-secondary-outline-live.dislike-button:hover {
	background-color: #a00 !important;
	color: #fff !important;
	border: 1px solid #a00 !important;
}
.think-btn-secondary-outline-live {
    text-decoration: none !important;
    min-height: 38px;
    padding: 5px 25px;
    border: 1px solid #2c3443;
    font-size: 1rem !important;
    background-color: transparent !important;
    font-family: 'Lato', sans-serif !important;
    border-radius: 10px;
    display: inline-block;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    user-select: none;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.think-btn-secondary-outline-live:focus,
.think-btn-secondary-outline-live:hover,
.think-btn-secondary-outline-live:active,
.think-btn-secondary-outline-live:focus-visible {
    outline: 0;
    box-shadow: none;
    color: #2c3443 !important;
    /* border: none; */
}
.think-mr--15 { margin-right: 15px;}
/*  */
body {
	display: grid;
  background-color: #F1F2F6;
	width: min(95%, 1360px);
	margin-inline: auto;
	grid-gap: 1rem;
	grid-template-columns: 1fr 300px;
	grid-template-rows: auto 72px auto;
}
.think-cohort-actions-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #fff;
  padding: 15px 20px;
  border-radius: 10px;
  grid-column: 1;
  height: max-content;
}

.feedback-btn-container {
  display: flex;
}

.root-box {
  height: auto;
}
aside.layout-aside.big-class-aside {
	position: relative;
	left: 0;
	top: 0;
}
.layout.layout-row.horizontal {
  background-color: #fff;
}
.video-player.big-class-teacher {
	width: 100% !important;
	height: 38rem !important;
}
.video-wrap {
	height: 600px;
}

.video-marquee-pin.big-class {
	position: relative;
	left: 0;
	top: 0;
}
/*  */
.layout.layout-row.horizontal 
.layout-content.column {
  height: 600px;
  overflow: hidden auto;
  order: 2;
}
div#animation-group {
  display: flex;
  flex-direction: column;
}
div#animation-group div.video-item:first-child {
padding-top: 2px
}
.video-player {
	height: 168px;
	width: 176px;
}
.board-section {
	position: relative;
	height: auto;
	top: 55px;
	margin: 0;
	width: 100%;
	z-index: 1;
	overflow: hidden;
}
.layout-aside {
	width: calc(100% - 180px) !important;
}
aside .video-wrap .bottom-left-info {
	bottom: 15px;
	left: 5px;
}
aside .video-wrap .bottom-left-info .username {
	font-size: 13px;
}
.layout-content .video-player .bottom-left-info {
	bottom: 7px;
	left: 0px;
}
/* ------------- */
/* Tabs */
.tab-contents {
  overflow-y: auto;
  background-color: #fff;
}
.tab-contents ul.nav {
  position: sticky;
  z-index: 2;
  top: 0;
  display: flex;
  background-color: #F5F3FF;
  padding: 0;
}
.tab-contents ul.nav li {
  width: 50%;
  font-size: 15px;
  font-weight: 400;
  color: #868E96;
  padding: 9px 15px;
  border-bottom: 2px solid #F8F7FC
}
.tab-contents ul.nav li.active {
  border-bottom: 2px solid #74648C;
}
.tab-contents ul.nav li a {
  color: #868E96;
}
.tab-contents ul.nav li.active a {
  color: #74648C;
  font-weight: 600;
}
.think-participant-container {
  padding: 5px 15px;
}
.think-participant-wrapper {
	display: flex;
  align-items: center
}
.think-participant-container span.think-participant-wrapper span.img-container{
  display: inline-block;
  position: relative;
}
.think-participant-name {
  margin-bottom: 3px;
  margin-left: 15px;
  font-size: 14px;
  font-weight: 500;
  color: #2C3443;
}

.think-online-status-light-container {
	display: inline-block;
	width: 10px;
	height: 10px;
	background-color: #e1e1e1;
	border-radius: 50%;
	position: absolute;
	right: -6px;
	bottom: 3px;
	outline: 2px solid #fff;
}
.online-status-green {
  background-color: #5CE300
}
/* --- */

/* Session Details */
.think-subtopics-wrapper {
	margin-bottom: 20px;
	padding: 20px 20px;
	border: 1px solid #e5e7eb;
	border-radius: 10px;
  background-color: #fff;
}
.think-content-styles {
  color: #6E7687;
  font-size: 16px;
  font-weight: 400px;
}

/*  */
#feedback-container {
  grid-column: span 2 !important;
}
/* Pin UI improvements */
.pin-right {
	right: 10px;
	bottom: 12px;
	position: sticky;
	display: block;
	margin-inline-start: auto;
}
.sender-can-hover:hover {
	background-color: #74648c;
}
.sender-can-hover:hover svg {
	color: #fff !important;
}
.sender-can-hover {
	background-color: #f5f3ff;
  transition: background-color 150ms ease-in
}
.sender-can-hover svg {
	color: #74648c;
}
/* Scrollbar customisation */
/* inside livestream */
.layout-content.column {
  scrollbar-width: thin;
  scrollbar-color: #74648c2b white;
}
.layout-content.column::-webkit-scrollbar {
  width: 5px;
}

.layout-content.column::-webkit-scrollbar-track {
  background: white;
}

.layout-content.column::-webkit-scrollbar-thumb {
  background-color: #74648c2b;
  border-radius: 20px; 
  /* border: 1px solid 74648c2b;  */
}
/* inside chat tab*/
.tab-contents {
  scrollbar-width: thin;
  scrollbar-color: #74648c2b white;
}
.tab-contents::-webkit-scrollbar {
  width: 5px;
}

.tab-contents::-webkit-scrollbar-track {
  background: white;
}

.tab-contents::-webkit-scrollbar-thumb {
  background-color: #74648c2b;
  border-radius: 20px; 
  /* border: 1px solid 74648c2b;  */
}
/*  */

.button-close-open {
	display: inline-block;
	width: max-content;
	height: max-content;
	background-color: #fff;
	display: inline-block;
	position: absolute;
	top: 9px;
	right: 125px;
  cursor: pointer;
  border-radius: 50%;
  padding: 2px;
}

.button-close-open:hover {
  background-color: #f0f0f7;
}
.button-close-open > img {
  width: 22px;
}
svg.svg-img.prefix-exit.can-hover {
    display: none;
}
.exit-button {
	display: inline-block;
	width: max-content;
	height: max-content;
	background-color: #fff;
	display: inline-block;
	position: absolute;
	top: 9px;
	right: 70px;
  cursor: pointer;
  border-radius: 50%;
  padding: 2px;
}
.exit-button:hover {
  background-color: #f0f0f7;
}
.exit-button > img {
  width: 22px;
}
.width--100 {
  width: 100% !important;
}
.display-none {
  display: none;
}
.think-position-relative {
  position: relative;
}
#chat {
  height: 100%;
}
.tab-content{
  height:100%;
}
.chat_text_box {
  border: 2px solid #d2dae2 !important;
    width: 100%;
    border-radius: 2px;
    bottom: 85.5px;
    position: absolute;
    padding: 10px 10px;
    height: 120px;
}
.chat_messages{
  height: 65%;
    padding: 10px 5px;
}

.chat-message-body {
  color: #6E7687;
}
/* Animation */

/* body:hover .button-anim {
      visibility: var(--card-property);
      animation-name: button-animation;
      animation-duration: 500ms;
      animation-delay: 5s;
      animation-timing-function: cubic-bezier(.24,.42,.3,2.98);
      animation-fill-mode: both;
    }

 @keyframes button-animation {
      0% {
        transform: translateY(0px);
      }
      100% {
        transform: translateY(1px);
      }
    } */

/*  */

div#chat_messages {
    padding: 10px;
}


textarea.feedback-text {
    width: 100%;
    border: 1px solid #a3a9b0 !important;
    height: 80px;
    border-radius: 4px;
}

.emoji-radio { 
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

/* IMAGE STYLES */
.emoji-radio + img {
  cursor: pointer;
  filter: grayscale(1);
}

.emoji-radio + img:hover {
  filter: none;
}

/* CHECKED STYLES */
.emoji-radio:checked + img {
  filter: none;
}


  .emoji-container {
    display: flex;
    margin-top: 10px;
  }
  .single-emoji {
    width: 25%;
  }
  .single-emoji img {
    display: initial;
  }
  .feedback-container {
    padding: 1.5rem 2.5rem;
text-align: center;
}
h1.feedback-title {
    font-size: 24px;
    font-weight: 600;
    font-family: 'Roboto', sans-serif;
    letter-spacing: 0.7px;
    color: #39414f;
    margin-bottom: 0px;
}

h4.feedback-sub-title {
    color: #a3a9b0;
}

h2.feedback-session-name {
    color: #39414f;
    margin-top: 20px;
    font-weight: 600;
}

h2.questions {
    color: #39414f;
    margin-top: 10px;
    font-weight: 600;
    padding-top: 20px;
}
button#feedback-submit {
    background-color: #2c3443;
    color: white;
    width: 100%;
    padding: 5px;
    border-radius: 5px;
    font-size: 13px;
    font-weight: 500;
}

  .feedback-modal {
    z-index: 9;
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    opacity: 0;
    visibility: hidden;
    transform: scale(1.1);
    transition: visibility 0s linear 0.25s, opacity 0.25s 0s, transform 0.25s;
}

.feedback-modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 1rem 1rem;
    width: 30rem;
    border-radius: 0.5rem;
}

.feedback-modal-close-button {
    float: right;
    width: 1.5rem;
    line-height: 1.5rem;
    text-align: center;
    cursor: pointer;
    font-size: 30px;
    border-radius: 0.25rem;
    color: #878f97;
}

.feedback-modal-close-button:hover {
    background-color: darkgray;
}

.feedback-modal-show-modal {
    opacity: 1;
    visibility: visible;
    transform: scale(1.0);
    transition: visibility 0s linear 0s, opacity 0.25s 0s, transform 0.25s;
}
.cabinet-item:nth-child(2) {
  display:none;
}

iframe#course_content_iframe {
    width: 100%;
    position: absolute;
    height: 100%;
}
</style>

  <input id="session_hidden_id" type="hidden" value="{{ $session }}" />
  <input id="user_type" type="hidden" value="{{ $userType }}" />
  <input id="course_id" type="hidden" value="{{ $courseId }}" />
  <input id="graph_box" type="hidden" value="" />
  <input id="batchId" type="hidden" value="{{$batchId}}" />
  <!-- agora sdk -->
  
  <div class="tab-container think-position-relative">
  <span id="exit_session" class="exit-button nodisplay"><img src="/storage/icons/exit.svg" alt="error"></span>
  <span id="btnOpenClose" class="button-close-open nodisplay"><img src="/storage/icons/min_max__icon.svg" alt="error"></span>
    <div id="root1"></div>
  </div>
  <!-- chat UI -->
  <div class="tab-contents nodisplay">
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#participants">Participants</a></li>
        <li><a data-toggle="tab" href="#chat">Chat</a></li>
      </ul>
      <div class="tab-content">
        <div id="participants" class="tab-pane fade in active">
        @foreach($participants as $participant)
        <div class="think-participant-container">
          <span class="think-participant-wrapper">
            <span class="img-container">
              <img src="/storage/icons/placeholder-avatar.svg" alt="error">
              <span class="think-online-status-light-container online-status-green"></span>
            </span>
            <span class="think-participant-name">{{ $participant }}</span>
          </span>
        </div>
        @endforeach
        </div>
        <div id="chat" class="tab-pane fade">
          <div id="chat_messages"></div>
        <textarea id="chat_box" class="chat_text_box" placeholder="Hit enter to send.."></textarea>
        </div>
      </div>
    </div>
    <!-- Course action -->
    
    <div id="back_to_course_div" class="think-cohort-actions-container nodisplay">
      <button id="back_to_course" class="think-btn-secondary-outline-live">Back to course</button>
      @if($userType == 'instructor')
      <button style="margin-left:-29em;" id="close_content" content-id="" class="think-btn-secondary-outline-live nodisplay">Close content</button>
      <button id="offcanvasButton" class="think-btn-secondary-outline-live" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">View live feedbacks</button>
      @endif
      
      @if($userType == 'student')
      <div class="feedback-btn-container">
      <p class="notif-text think-mr--15 think-color-light-dark think-fs--14">Did you understand this topic?</p> 
      <button data-id="" class="think-btn-secondary-outline-live like-button think-mr--15 button-anim" id="positive">
        <i style="margin-right:10px;" class="fas fa-thumbs-up"></i>
        Yes 
      </button> 
      <script>
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
      document.getElementById('negative').classList.remove('pulsate');
      document.getElementById('positive').classList.remove('pulsate');

    });
});
        </script>
      <button class="think-btn-secondary-outline-live dislike-button" id="negative" data-id="">
        <i style="margin-right:10px;" class="fas fa-thumbs-down">
        </i>No
      </button>
      <script>
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
        document.getElementById('negative').classList.remove('pulsate');
        document.getElementById('positive').classList.remove('pulsate');
        
    });
  });
  </script>
    </div>
    @endif
  </div>
  
    <!-- Course details -->
<div id="feedback-container" class="nodisplay">
  @if($userType == 'student')
  <div class="row"></div>
 

  <div class="think-cohort-subtopics-container think-subtopics-wrapper" style="margin-bottom:20px;">
    <h6 class="notif-text think-color-dark think-fs--18">Session Info</h6>
    <hr>
    @csrf
    <p class="notif-text think-color-dark think-fs--16">{{ $topic_title }}</p>
    @foreach($contents as $content)
    <div href="{{ url('/') }}/storage/content_documents/{{ $content->document }}" id="thumbs_{{ $content->topic_content_id }}" class="think-content-styles"><i id="thumbs_i_{{ $content->topic_content_id }}" style="margin-right:10px;" class="thumbs far fa-circle"></i>{{ $content->topic_title }}</div>
    @endforeach
  </div>

  
  <div class="row" id="iframe_div">

      <iframe class="nodisplay" id="course_content_iframe" src="" width='100%' height='500px' frameborder='0'></iframe>
  </div>
  @elseif($userType == 'instructor')
  <div class="row" id="iframe_div">

      <iframe class="nodisplay" id="course_content_iframe" src="" width='100%' height='500px' frameborder='0'></iframe>
  </div>
  <div class="row2" style="margin-bottom:20px;background-color:white;padding:15px;">
    <h6 class="notif-text think-color-dark think-fs--18">Session Info</h6>
    <hr>
    <p class="notif-text think-color-dark think-fs--16">{{ $topic_title }}</p>
    @csrf
    <table>
    @foreach($contents as $content)
    <tr>
    <div class="course_contents_div" data-id="1" style="margin-top:5px;">
      <td><i style="margin-right:10px;" class="thumbs fas fa-circle"></i>
        <span id="content_title_{{ $content->topic_content_id }}">{{ $content->topic_title }}</span></td>
          <td><button class="course_contents" id="course_contents_{{ $content->topic_content_id }}" href="{{ url('/') }}/storage/content_documents/{{ $content->document }}" data-id="{{ $content->topic_content_id }}">
            Start
          </button></td>
    </div>
  </tr>
    @endforeach
  </table>
  </div>

@endif

<!-- <button class="trigger">Click here to trigger the modal!</button> -->
<div class="feedback-modal">
    <div class="feedback-modal-content">
        <span class="feedback-modal-close-button">&times;</span>
        <div class="feedback-container">
          <h1 class="feedback-title">It's Feedback Time!</h1>
          <h4 class="feedback-sub-title">Tell us about your live cohort experience</h4>
          <h2 class="feedback-session-name">Live Session - {{ $topic_title }}</h2>
          <h2 class="feedback-question-1 questions">{{  $feedbackQ1 }}</h2>
          <form action="{{ route('submit-feedback') }}" method="POST">
          @csrf
          <input type="hidden" name="live_session_id" id="live_session_id" value="{{ $session }}"/>
          <input type="hidden" name="student_id" id="student_id" value="{{ $userId }}"/>
          <input type="hidden" name="course_id" id="course_id" value="{{ $courseId }}"/>
          <input id="timer" name="timer" type="hidden" value="" />
          <div class="emoji-container">
            <div class="single-emoji">
              <label>
              <input name="question1" class="emoji-radio" type="radio" name="test" value="0">
              <img src="/storage/icons/Disappointed.svg">
            </label>
            </div>
            <div class="single-emoji">
            <label>
              <input name="question1" class="emoji-radio" type="radio" name="test" value="1">
              <img src="/storage/icons/Confused.svg">
            </label>
            </div>
            <div class="single-emoji">
            <label>
              <input name="question1" class="emoji-radio" type="radio" name="test" value="2">
              <img src="/storage/icons/Satisfied.svg">
            </label>
            </div>
            <div class="single-emoji">
            <label>
              <input name="question1" class="emoji-radio" type="radio" name="test" value="3">
              <img src="/storage/icons/Awesome.svg">
            </label>
            </div>
          </div>
          <h2 class="feedback-question-2 questions">{{  $feedbackQ2 }}</h2>
          <div class="emoji-container">
            <div class="single-emoji">
              <label>
              <input name="question2" class="emoji-radio" type="radio" name="test" value="0">
              <img src="/storage/icons/Disappointed.svg">
            </label>
            </div>
            <div class="single-emoji">
            <label>
              <input name="question2" class="emoji-radio" type="radio" name="test" value="1">
              <img src="/storage/icons/Confused.svg">
            </label>
            </div>
            <div class="single-emoji">
            <label>
              <input name="question2" class="emoji-radio" type="radio" name="test" value="2">
              <img src="/storage/icons/Satisfied.svg">
            </label>
            </div>
            <div class="single-emoji">
            <label>
              <input name="question2" class="emoji-radio" type="radio" name="test" value="3">
              <img src="/storage/icons/Awesome.svg">
            </label>
            </div>
          </div>
          <h2 class="feedback-question-3 questions">{{  $feedbackQ3 }}</h2>
          <div class="emoji-container">
            <div class="single-emoji">
              <label>
              <input name="question3" class="emoji-radio" type="radio" name="test" value="0">
              <img src="/storage/icons/Disappointed.svg">
            </label>
            </div>
            <div class="single-emoji">
            <label>
              <input name="question3" class="emoji-radio" type="radio" name="test" value="1">
              <img src="/storage/icons/Confused.svg">
            </label>
            </div>
            <div class="single-emoji">
            <label>
              <input name="question3" class="emoji-radio" type="radio" name="test" value="2">
              <img src="/storage/icons/Satisfied.svg">
            </label>
            </div>
            <div class="single-emoji">
            <label>
              <input name="question3" class="emoji-radio" type="radio" name="test" value="3">
              <img src="/storage/icons/Awesome.svg">
            </label>
            </div>
          </div>
          <h2 class="other-feedbacks questions">Any other feedback?</h2>
          <textarea name="other_feedbacks" class="feedback-text"></textarea><br>
          <button type="submit" class="feedback-submit" id="feedback-submit">Submit</button>
        </form>
        </div>
    </div>
</div>
</div>



<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel" style="visibility:hidden;">
  <div class="offcanvas-header">
    <button id="offcanvasClose" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close">x</button>
  </div>
  <div class="offcanvas-container">
     <div class="students-list">
     <table class="table llp-table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col" colspan="2">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col" style="text-align:center;">Likes</th>
                <th scope="col" style="text-align:center;">Dislikes</th>
                <th scope="col" style="text-align:center;">Understood</th>
              </tr>
            </thead>
            <tbody id="live_chart_table_body">
              <tr>
                <td colspan="6"><h5>No records yet</h5></td>
              </tr>
            </tbody>
          </table>
     </div>
     <div id="graph">
     </div>
  </div>
</div>
<style>
.llp-table {
    border: 1px solid #ddd;
}

.llp-table i {
    color: var(--main-title-color);
    margin-right: .5rem;
}

.llp-table a {
    text-decoration: none;
}

.llp-table th {
  padding: 10px 10px;
  width: 110px;
}
.llp-table tr {
border: 1px solid #ddd;
}
.llp-table td {
    padding: 10px 10px;
    width: 110px;
    color: #868E96;
}
.table>:not(:first-child) {
    border-top: none;
}
.students-list {
    width: 50%;
    text-align: -webkit-center;
    padding: 20px 20px;
}
div#graph {
  width: 50%;
    text-align: -webkit-center;
    padding: 20px 20px;
}
.offcanvas-bottom {
    right: 0;
    left: 0;
    height: 75vh;
    max-height: 100%;
    border-top: 1px solid rgba(0,0,0,.2);
    transform: translateY(100%);
    width: 100%;
    display: flex;
}
.offcanvas {
    position: fixed;
    bottom: 0;
    z-index: 1045;
    display: flex;
    flex-direction: column;
    max-width: 100%;
    visibility: hidden;
    background-color: #fff;
    background-clip: padding-box;
    outline: 0;
    transition: transform .3s ease-in-out;
}

.offcanvas-header {
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1rem;
}

.offcanvas-title {
    margin-bottom: 0;
    line-height: 1.5;
}

.offcanvas-body {
    flex-grow: 1;
    padding: 1rem 1rem;
    overflow-y: auto;
}

.offcanvas.show {
    transform: none;
}

.offcanvas-header .btn-close {
    padding: 0.5rem 0.5rem;
    margin-top: -0.5rem;
    margin-right: -0.5rem;
    margin-bottom: -0.5rem;
    font-size: 30px;
    float: right;
}

.offcanvas-container {
    display: flex;
    height: 100%;
}

.text-reset {
    --bs-text-opacity: 1;
    color: inherit!important;
}
.btn-close {
    box-sizing: content-box;
    width: 1em;
    height: 1em;
    padding: 0.25em 0.25em;
    color: #000;
    background: transparent url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e) center/1em auto no-repeat;
    border: 0;
    border-radius: 0.25rem;
    opacity: .5;
    cursor: pointer;
    appearance: none !important;
}
</style>
  <script type="text/javascript">
    let presentingFlag = 0;
    $('#offcanvasClose').click(function(){
      $('#offcanvasBottom').removeClass('show');
      $('#offcanvasBottom').css('visibility', 'hidden');
    });
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






document.getElementById('chat_box').addEventListener('keyup', function(e) {
  let message = document.getElementById('chat_box').value;
  message = message.trim();
    if(e.which == 13 && message != "") {
      let message = document.getElementById('chat_box').value;
      let sessionId = document.getElementById('session_hidden_id').value;
      let path = "{{ route('save-session-chat') }}?session=" + sessionId + "&message=" + message;
      fetch(path, {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          "X-CSRF-Token": document.querySelector('input[name=_token]').value
        },
      }).then((response) => response.json()).then((data) => {
        document.getElementById('chat_box').value = "";
      });
    }
});

document.getElementById('back_to_course').addEventListener('click', function(){
  let course_id = document.getElementById('course_id').value;
  location.replace("/enrolled-course/" + course_id);
});
  
      
let timer = 0;

$(document).ready(function(){
  var start = new Date;
  let sessionId = document.getElementById('session_hidden_id').value;
  setInterval(function() {
      timer = Math.round((new Date - start) / 1000);
      document.getElementById('timer').value = timer;
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

      let chatPath = "{{ route('get-session-chat') }}?sessionId=" + sessionId;
      fetch(chatPath, {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          "X-CSRF-Token": document.querySelector('input[name=_token]').value
        },
      }).then((response) => response.json()).then((data) => {
        document.getElementById('chat_messages').innerHTML = data.html;
      });

  }, 1000);
});

window.addEventListener("beforeunload", function (e) {
  var confirmationMessage = "Are you sure you want to exit?";
  let sessionId = document.getElementById('session_hidden_id').value;
  let userType = document.getElementById('user_type').value;
  let timer = document.getElementById('timer').value;

  if(userType == "student") {
    
    let path = "{{ route('student-exit') }}?session=" + sessionId + "&timer=" + timer;
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

$(document).on('click', '.cabinet-item', function(e) {
    $('.screen-share-player-container').appendTo('.big-class-teacher');
    $('#stop_sharing').removeClass('nodisplay');
});


$(document).on('click', '.btn:contains("Finish")', function() {
    $('.tab-contents').removeClass('nodisplay');
    $('#feedback-container').removeClass('nodisplay');
    $('#back_to_course_div').removeClass('nodisplay');
    $('#btnOpenClose').removeClass('nodisplay');
    $('#exit_session').removeClass('nodisplay');
});



document.getElementById('exit_session').addEventListener('click', function(e) {
  let sessionId = document.getElementById('session_hidden_id').value;
  let userType = document.getElementById('user_type').value;
  let course_id = document.getElementById('course_id').value;
  let batchId = document.getElementById('batchId').value;
  
  if(userType == "student") {
    
  const modal = document.querySelector(".feedback-modal");
const closeButton = document.querySelector(".feedback-modal-close-button");

function toggleModal() {
    modal.classList.toggle("feedback-modal-show-modal");
}

function windowOnClick(event) {
    if (event.target === modal) {
        toggleModal();
    }
}

closeButton.addEventListener("click", toggleModal);
window.addEventListener("click", windowOnClick);
toggleModal();
    
  } else {
    location.replace("/enrolled-course/" + course_id + "?batchId=" + batchId);
  }
});

jQuery(".nav-tabs li").click(function(e) {
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
    let userType = document.getElementById('user_type').value;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
    }).then((response) => response.json()).then((data) => {
      if(userType == 'student') {
        if(data.presentingContentId) {
        if(presentingFlag != data.presentingContentId) {
          presentingFlag = data.presentingContentId;
        $('#course_content_iframe').appendTo('.big-class-teacher');
        document.getElementById('course_content_iframe').classList.remove('nodisplay');
        let docUrl = document.getElementById('thumbs_'+data.presentingContentId).getAttribute('href');
        document.getElementById('course_content_iframe').setAttribute('src', 'https://view.officeapps.live.com/op/embed.aspx?src=' + docUrl);
        }
        
      } else {
        document.getElementById('course_content_iframe').classList.add('nodisplay');
      }
      }
      
      if(data.content_id != null && data.flag == 0) {
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
      if(document.getElementById('user_type').value == "Instructor") {
        document.getElementsByClassName('board-section')[0].classList.add('nodisplay');
      }
      if(extension == "pdf") {
        $('#course_content_iframe').appendTo('.big-class-teacher');
        document.getElementById('course_content_iframe').classList.remove('nodisplay');
        let docUrl = this.getAttribute('href');
        document.getElementById('course_content_iframe').setAttribute('src', docUrl);
        
      } else if (extension == "pptx") {
        $('#course_content_iframe').appendTo('.big-class-teacher');
        document.getElementById('course_content_iframe').classList.remove('nodisplay');
        document.getElementById('close_content').classList.remove('nodisplay');
        let docUrl = this.getAttribute('href');
        document.getElementById('course_content_iframe').setAttribute('src', 'https://view.officeapps.live.com/op/embed.aspx?src=' + docUrl);
      }
      let topicContentId = this.getAttribute('data-id');
      let path = "{{ route('push-live-record') }}?content_id=" + topicContentId;
      document.getElementById('close_content').classList.remove('nodisplay');
      document.getElementById('close_content').setAttribute('content-id', topicContentId);
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

document.getElementById('close_content').addEventListener('click', function(e) {
    document.getElementById('close_content').classList.add('nodisplay');
    document.getElementById('course_content_iframe').classList.add('nodisplay');
    let topicContentId = document.getElementById('close_content').getAttribute('content-id');
    document.getElementById('course_contents_' + topicContentId).classList.add('nodisplay');
    document.getElementById('content_title_' + topicContentId).style.color = "#bdbebe";
      let path = "{{ route('stop-presenting') }}?content_id=" + topicContentId;
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


<!-- // instructor screen's width adjusting functionality  //-->
  <script>
toggleFlag = true;

let buttonOpenClose = document.getElementById('btnOpenClose');
buttonOpenClose.addEventListener('click', () => {
  let asideElement = document.querySelector('.layout-aside');

  if(toggleFlag) {
    asideElement.classList.add('width--100');
  } else {
    asideElement.classList.remove('width--100');
  }
  toggleFlag = !toggleFlag;
});

</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    

    $('#offcanvasButton').click(function(){
        $('#offcanvasBottom').addClass('show');
        $('#offcanvasBottom').css('visibility', 'visible');

        let sessionId = document.getElementById('session_hidden_id').value;
        let path = "{{ route('get-session-chart') }}?session=" + sessionId;
        fetch(path, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            "X-CSRF-Token": document.querySelector('input[name=_token]').value
          },
        }).then((response) => response.json()).then((data) => {
          
            document.getElementById('live_chart_table_body').innerHTML = data.html;

            google.charts.load('current', {
              'packages': ['bar']
            });
            google.charts.setOnLoadCallback(function() {
              drawChart(data.graphData);
            });

            function drawChart(graph) {
              if(graph.length == 1) {
                var gdata = google.visualization.arrayToDataTable([
                    ['Sub content', 'Likes', 'Dislikes'], graph[0]
              ]);

              } else if(graph.length == 2) {
                var gdata = google.visualization.arrayToDataTable([
                    ['Sub content', 'Likes', 'Dislikes'], graph[0], graph[1]
              ]);
                
              } else if(graph.length == 3) {
                var gdata = google.visualization.arrayToDataTable([
                    ['Sub content', 'Likes', 'Dislikes'], graph[0], graph[1], graph[2]
              ]);

              } else if(graph.length == 4) {
                var gdata = google.visualization.arrayToDataTable([
                    ['Sub content', 'Likes', 'Dislikes'], graph[0], graph[1], graph[2], graph[3]
              ]);

              } else if(graph.length == 5) {
                var gdata = google.visualization.arrayToDataTable([
                    ['Sub content', 'Likes', 'Dislikes'], graph[0], graph[1], graph[2], graph[3], graph[4]
              ]);

              } else if(graph.length == 6) {
                var gdata = google.visualization.arrayToDataTable([
                    ['Sub content', 'Likes', 'Dislikes'], graph[0], graph[1], graph[2], graph[3], graph[4], graph[5]
              ]);

              } else if(graph.length == 7) {
                var gdata = google.visualization.arrayToDataTable([
                    ['Sub content', 'Likes', 'Dislikes'], graph[0], graph[1], graph[2], graph[3], graph[4], graph[5], graph[6]
              ]);

              } else if(graph.length == 8) {
                var gdata = google.visualization.arrayToDataTable([
                    ['Sub content', 'Likes', 'Dislikes'], graph[0], graph[1], graph[2], graph[3], graph[4], graph[5], graph[6], graph[7]
              ]);

              } else if(graph.length == 9) {
                var gdata = google.visualization.arrayToDataTable([
                    ['Sub content', 'Likes', 'Dislikes'], graph[0], graph[1], graph[2], graph[3], graph[4], graph[5], graph[6], graph[7], graph[8]
              ]);

              } else if(graph.length == 10) {
                var gdata = google.visualization.arrayToDataTable([
                    ['Sub content', 'Likes', 'Dislikes'], graph[0], graph[1], graph[2], graph[3], graph[4], graph[5], graph[6], graph[7], graph[8], graph[9]
              ]);

              }
                

                var options = {
                    chart: {
                        title: 'Participant Activities',
                        subtitle: '',
                        width: 600,
                        height: 400
                    },
                    colors: ['#A26B05','#F5BC29']
                };

                var chart = new google.charts.Bar(document.getElementById('graph'));

                chart.draw(gdata, google.charts.Bar.convertOptions(options));
              }
        });

    });

  </script>
</body>

</html>

