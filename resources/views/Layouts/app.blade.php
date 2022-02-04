<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:site" content="TY-Mac">
  <!--<meta property="og:type" content="website">
  <meta name="twitter:creator" id="twitter_creator" content="">
  <meta property="twitter:title" id="twitter_title" content="">
  <meta property="twitter:description" id="twitter_description" content="">
  <meta property="twitter:image" id="twitter_image" content="">
  <meta name="twitter:domain" content="https://enliltdev.fibiweb.com/">-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="{{ asset('/assets/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/styles_new.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/app.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/loginModal.css') }}">
  <link rel="icon" href="{{ asset('/assets/favicon.png') }}">
  @stack('styles')
  <title>TY- MAC</title>
</head>

<body>
  @include('header')
  @yield('content')
  @include('footer')
   <!-- BACK TO TOP BUTTON  -->
   <a href="#" class="shadow btn-primary rounded-circle back-to-top">
    <i class="fas fa-chevron-up"></i>
  </a>
@if(session()->has('message'))
<div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1031">
<div class="toast align-items-center text-white border-0 think-toast" role="alert" aria-live="assertive" aria-atomic="true" id="liveToast">
  <div class="d-flex">
    <div class="toast-body">
    {{ session()->get('message') }}
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>
</div>
@endif
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <script type="text/javascript" src="{{ asset('/assets/app.js') }}"></script>
  @stack('child-scripts')
</body>
</html>