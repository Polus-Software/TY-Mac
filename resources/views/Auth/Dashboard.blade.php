@extends('Layouts.Profile')
@section('content')
<nav class="navbar navbar-expand-sm bg-dark justify-content-end">
  <ul class="navbar-nav dashboard-navbar">
  @if($userType == 'content_creator')
    <li class="nav-item">
      <a class="nav-link" href="{{ route('manage-course-categories') }}">Manage Course Categories</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('manage-courses') }}">Manage Courses</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('edituser') }}"> Welcome {{Auth::user()->firstname}}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}">Logout</a>
    </li>
    @elseif($userType == 'admin')
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.viewall') }}">Manage Users</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('manage-course-categories') }}">Manage Course Categories</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('manage-instructors') }}">Manage Instructors</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('manage-creators') }}">Manage Content Creators</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('manage-courses') }}">Manage Courses</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('edituser') }}"> Welcome {{Auth::user()->firstname}}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}">logout</a>
    </li>
    @elseif($userType == 'instructor')
    <li class="nav-item">
      <a class="nav-link" href="{{ route('instructor-session-view') }}">View Scheduled Sessions</a>
    <li class="nav-item">
    <li class="nav-item">
      <a class="nav-link" href="#">Change Password</a>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('edituser') }}"> Welcome {{Auth::user()->firstname}}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}">logout</a>
    </li>
  @else
  <li class="nav-item">
      <a class="nav-link" href="{{ route('instructor-session-view') }}">Attend Session</a>
    <li class="nav-item">
    <li class="nav-item">
      <a class="nav-link" href="#">Change Password</a>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('edituser') }}"> Welcome {{Auth::user()->firstname}}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('student.courses.get') }}">courses</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}">logout</a>
    </li>
  @endif
  </ul>
</nav>
<div class="card-header"> Welcome {{Auth::user()->firstname}}</div>
<div class="card-body">
  @if (session('success'))
    <div class="alert alert-success" role="alert">
      {{ session('success') }}
    </div>
  @endif

@endsection