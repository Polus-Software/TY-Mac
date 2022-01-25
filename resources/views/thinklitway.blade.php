@extends('Layouts.app')
@section('content')
<!-- top banner-->

<section id="home" class="intro-section">
  <div class="container">
    <div class="row align-items-center pb-5">
      <div class="col-md-6 intros text-start">
        <h3 class="think-way-title mt-1">Our unique teaching methodology <br>that makes learning any skill 
        <span class="fw-bold think-personalized-way-text d-inline-block">simple, interactive, & fun!
              <div class="think-personalized-way-underline"><img class="img-fluid mx-auto d-block" src="courselist/images/Under-line.png" alt="marketing illustration"></div>
            </span>
        </h3>        
        <div class="mt-5 mb-4 think-way-para">
          <p>The education experience has not changed in over a century. Even to this day, the way students learn is through the "one size fits all" model.</p>
          <p>However, this method of learning is no longer effective since every student learns differently.</p>
          <p>At ThinkLit, we believe the solution to this problem is to completely rethink how courses are taught hence The ThinkLit Way.</p>
        </div>
      </div>
      <div class="col-md-6 intros text-end">
        <div class="video-box">
          <img src="courselist/images/Right.svg" alt="Thinklit way" class="img-fluid">
        </div>
      </div>
    </div>
  </div>
</section>
@endsection('content')
