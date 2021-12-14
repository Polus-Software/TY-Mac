@extends('Layouts.admin.master')
@section('content')

<section>
    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="card card-2 mb-3">
                    <div class="card-body">
                        <h5 class="card-title border-bottom pb-3">Course Content</h5>
                        @php ($slno = 0)
                        @foreach($courseContents as $courseContent)
                        @php ($slno = $slno + 1)
                        <h6 class="card-subtitle mt-3" id="{{$courseContent['topic_id']}}">Session {{$slno}} - {{$courseContent['topic_title']}}</h6>
                        <ul class="list-group list-group-flush border-bottom pb-3">
                            <li class="list-group-item">
                            @foreach($courseContent['contentsData'] as $content)
                                <ul>
                                    <div class="row">
                                        <div class="col-lg-8">
                                        <li id="{{$content['topic_content_id']}}">{{$content['topic_title']}}</li>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="{{ route('download-study-material', $content['topic_content_id']) }}" class="btn">Open content<i class="fas fa-download ps-2"></i></a>
                                        </div>
                                    </div>
                                </ul>
                                @endforeach
                            </li>
                        </ul>   
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection('content')