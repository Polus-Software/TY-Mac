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
</style>
@extends('Layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- sidebar -->
<section class="intro-section">
<div class="container mb-3">
<div class="row mb-2">
   <div class="col-lg-3 col-md-3 col-sm-3 col-12">
       <a href="/enrolled-course/{{$courseId}}"class="btn btn-dark w-100 backbtn"><i class="fas fa-arrow-left"></i> &nbsp;&nbsp;&nbsp;&nbsp;Back to my course</a>
   </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3 col-12">
        <div class="flex-column flex-shrink-0 studymaterial_sidebar">
        <ul class="nav nav-pills flex-column">
            <div class="row">
                <li class="nav-item">
                    <b style="color:#2C3443;">Course materials</b>
                    <hr style="color:rgba(0,0,0,.125);margin:10px 0px 0px 0px !important;">
                </li>
            </div>
            @foreach($topics as $topic)
            <div class="row mt-4">
            <li class="nav-item">
            <p class="link-dark studymaterial_topic text-center">
                {{ $topic['topicTitle'] }}</p>
            </li>
            @if($topic['attendanceStatus'])
                @foreach($topic['contents'] as $content)
                <li class="nav-item material_contents study_materials" data-href="{{ url('/') }}/storage/study_material/{{ $content['topicContentDoc'] }}">
                        {{ $content['topicContentTitle'] }}
                </li>
                @endforeach
            @else
            <li class="material_contents text-center pt-4">
                <i class="fas fa-paperclip"></i>
                <p>Attachment not available</p>
            </li>
            @endif
            </div>
            @endforeach
        </ul>
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-12">
        <iframe id="course_content_iframe" src="https://view.officeapps.live.com/op/embed.aspx?src=https://scholar.harvard.edu/files/torman_personal/files/samplepptx.pptx" width='100%' height='500px' frameborder='0'></iframe>
    </div>
</div>
</div>
</section>
<script>

    let materialsEle = document.getElementsByClassName('study_materials');
    let materialsCount = materialsEle.length;

    for(index = 0; index < materialsCount; index++) {
        materialsEle[index].addEventListener('click', function(event) {
            docUrl = this.getAttribute('data-href');

            let extension = get_url_extension(docUrl);
            
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
<!-- sidebar ends -->

@endsection('content')