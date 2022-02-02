<div class="think-nodata-box px-4 py-5 my-5 text-center mh-100">
    @if($notype === 'video')
    <img class="mb-3" src="/storage/icons/no_video.svg" alt="{{$message}}">
    @else
    <img class="mb-3" src="/storage/icons/no_data_available.svg" alt="{{$message}}">
    @endif
    <h4 class="fw-bold">{{$message}}</h4>
</div>