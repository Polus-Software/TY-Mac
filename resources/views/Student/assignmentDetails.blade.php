@extends('Layouts.enrollCourse')
@section('content')
<section>
    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card card-1 mb-3">
                    <div class="card-body">
                        <h3 class="card-title border-bottom pb-2 text-capitalize">
                         @foreach($assignments as $assignment)
                            {{$assignment['assignment_title']}}
                        @endforeach</h3>

                        <h5 class="card-subtitle mt-3 pb-2 text-capitalize">Instructions</h5>
                        <p class="card-text">
                        @foreach($assignments as $assignment)
                            {{$assignment['assignment_description']}}
                        @endforeach</p>
                        <h5 class="card-subtitle mt-3 pb-2">Additional references</h5>
                        <div class="row border-bottom ">
                            <div class="col-lg-6 col-sm-6 col-12">
                            <p> @foreach($assignments as $assignment)
                                {{$assignment['document']}}
                                @endforeach
                            </p>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12 mb-3">@foreach($assignments as $assignment)
                            <a href="{{ route('download.assignment', $assignment['id'] ) }}" class="btn">Download now
                                <i class="fas fa-download ps-2"></i></a>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                        @foreach($assignments as $assignment)
                            <h3 class="card-title pb-2 text-capitalize">Submit Your Answer</h3>
                            <form action="{{ route('submit.assignment') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-lg-6 col-sm-6 col-12 mb-3">
                                    <input type="hidden" name="topic_assignment_id" value="{{$assignment['id']}}">
                                    <input type="file" class="form-control" name="assignment_answer">
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <button type="submit" class="btn" id="submit-assignment">Submit Assignment</button>
                                </div>
                            </form>  
                            @endforeach 
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection('content')