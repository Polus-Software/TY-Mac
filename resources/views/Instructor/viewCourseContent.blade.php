@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')

<div class="container llp-container">
    <div class="col-2 position-fixed">
    @include('Layouts.admin.sidebar')
    </div>

    <div class="col-9 ms-auto">
        <div class="card card-2 mb-3">
            <div class="card-body">
                <h5 class="card-title border-bottom pb-3">Course Content</h5>
                @php ($slno = 0)
                @foreach($courseContents as $courseContent)
                @php ($slno = $slno + 1)
                <h6 class="card-subtitle mt-3" id="{{$courseContent['topic_id']}}">Session {{$slno}} - {{$courseContent['topic_title']}}</h6>
                <ul class="border-bottom list-group list-group-flush mt-3 pb-3">
                    @foreach($courseContent['contentsData'] as $content)
                            <div class="row">
                                <div class="col-lg-8">
                                <li class="ms-4 border-0" style="list-style:circle;" id="{{$content['topic_content_id']}}">{{$content['topic_title']}}</li>
                                </div>
                                <div class="col-lg-4">
                                    <a href="{{ route('download-study-material', $content['topic_content_id']) }}" class="btn">Open content<i class="fas fa-download ps-2"></i></a>
                                </div>
                            </div>
                    @endforeach
                </ul>   
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection('content')