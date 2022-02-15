<style>
.studymaterial_sidebar {
    padding: 20px 20px;
    display: block !important;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: 10px;
}
span#SlideLabel-Medium14 span {
    color: #2C3443;
}
.studymaterial_topic {
    color: #2C3443;
    font-size: 14px;
    font-weight: 600;
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
a#ChromelessStatusBar\.Options-Small14 {
    display: none;
}
.cui-statusbar {
    height: 22px;
    background-color: #f7c649;
    border-top: 1px solid #f7c649;
}
.backbtn {
    font-size:12px !important;
}
.backbtn:hover {
    background-color : transparent !important;
    color: black !important;
}
.chat-message-body {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}
.participant-name {
    display: inline-block;
    font-size: 12px;
}
.participant-msg {
    display: inline-block;
    padding: 7px 15px;
    background: #fff;
    border-radius: 0 10px 10px 10px;
    border: 1px solid #eeedf0;
    max-width: 85%;
    width: max-content;
}
.same_user {
	align-items: flex-end;
}
.same_user .participant-msg {
    border-radius: 10px 0 10px 10px;
    background: #f8f7fc;
}
.chat_body {
    overflow:auto;
    padding: 1rem 2rem 0rem 2rem;
}
.chat_body::-webkit-scrollbar {
    width: 10px;
}
 
.chat_body::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 2px rgba(0,0,0,0.3);
}
 
.chat_body::-webkit-scrollbar-thumb {
  background-color: #e0e0e0;
    outline: 1px solid white;
}
</style>
@extends('Layouts.app')
@section('content')
<!-- sidebar -->
<input type="hidden" id="course_id" value="{{$courseId}}" />
<input type="hidden" id="student_id" value="{{$studentId}}" />
<input type="hidden" id="instructor_id" value="{{$instructorId}}" />
<section class="intro-section" style="height: auto;padding-top: 100px;">
<div class="container mb-3">
<div class="row mb-2">
   <div class="col-lg-2 col-md-2 col-sm-2 col-12">
       <a href="/enrolled-course/{{$courseId}}"class="btn btn-dark w-100 backbtn"><i class="fas fa-arrow-left"></i> &nbsp;&nbsp;&nbsp;&nbsp;Back to my course</a>
   </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="flex-column flex-shrink-0 studymaterial_sidebar" style="height:calc(100vh - (100px + 194px));">
        <ul class="nav nav-pills flex-column">
            <div class="row">
                <li class="nav-item">
                    <b style="color:#2C3443;">Chat</b>
                    <hr style="color:rgba(0,0,0,.125);margin:10px 0px 0px 0px !important;">
                </li>
            </div>
        </ul>
            <div class="chat_body w-100" style="height:90%;" id="chat_body">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        @csrf
        <textarea id="chat_box" class="form-control mt-2 rounded" rows="4" placeholder="Type and press enter to send your message."></textarea>
    </div>
</div>
</div>
</section>
<script>

setInterval(function() {
      let courseId = document.getElementById('course_id').value;
      let studentId = document.getElementById('student_id').value;
      let instructorId = document.getElementById('instructor_id').value;

      let chatPath = "{{ route('get-general-chat') }}?courseId=" + courseId + "&studentId=" + studentId + "&instructorId=" + instructorId;
      fetch(chatPath, {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          "X-CSRF-Token": document.querySelector('input[name=_token]').value
        },
      }).then((response) => response.json()).then((data) => {
        document.getElementById('chat_body').innerHTML = data.html;
      });
  }, 1000);

  document.getElementById('chat_box').addEventListener('keyup', function(e) {
  let message = document.getElementById('chat_box').value;
  message = message.trim();
    if(e.which == 13 && message != "") {
      let message = document.getElementById('chat_box').value;
      document.getElementById('chat_box').value = "";
      let courseId = document.getElementById('course_id').value;
      let studentId = document.getElementById('student_id').value;
      let instructorId = document.getElementById('instructor_id').value;

      let path = "{{ route('save-general-chat') }}?courseId=" + courseId + "&studentId=" + studentId + "&instructorId=" + instructorId + "&message=" + message;
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
});

</script>
<!-- sidebar ends -->

@endsection('content')