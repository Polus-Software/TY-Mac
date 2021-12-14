@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<!-- container -->




<div class="container llp-container">
  <div class="row">
    <div class="col-2 position-fixed">
    @include('Layouts.admin.sidebar')
    </div>

    <div class="col-9 ms-auto">
      <main>
      <div class="row mt-4">
          <table class="table llp-table">
            <thead>
              <tr>
                <th scope="col">Slno.</th>
                <th scope="col">Course Title</th>
                <th scope="col">Course Category</th>
                <th scope="col">Description</th>
                <th scope="col">Next Cohort</th>
                <th scope="col">No of Students Enrolled</th>
                <th scope="col" class="text-center">View Student List</th>
                <th scope="col" class="text-center">View Course Content</th>
               
              </tr>
            </thead>
            <tbody id="assigned_course_tbody">
              @php ($slno = 0)
              @foreach($assignedCourseData as $assignedCourse)
              @php ($slno = $slno + 1)
              <tr id="{{ $assignedCourse['id'] }}">
                <th class="align-middle" scope="row">{{ $slno }}</th>
                <td class="align-middle">{{ $assignedCourse['course_title'] }}</td>
                <td class="align-middle">{{ $assignedCourse['category'] }}</td>
                <td class="align-middle">{{ $assignedCourse['description'] }}</td>
                <td class="align-middle">next cohort</td>
                <td class="align-middle">{{ $assignedCourse['enrolled_course_count'] }}</td>
                <td class="align-middle text-center">
                <a href="{{ route('student-list', $assignedCourse['id']) }}" title="view-student-list">
                  <i class="fas fa-eye"></i>
                  </a>
                </td>
                <td class="align-middle text-center">
                <a href="{{ route('view-course-content', $assignedCourse['id'] ) }}" title="view-course-content">
                  <i class="fas fa-eye"></i>
                  </a>
                </td>

                
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
</div>