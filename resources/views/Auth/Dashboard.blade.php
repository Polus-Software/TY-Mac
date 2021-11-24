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
      <!-- main -->
      <main>
        <div class="row mt-4">
          <div class="col-sm-3">
            <div class="card llp-countbox">
              <div class="card-body text-center">
                <h1 class="card-title">18</h5>
                  <p class="card-text">Course registered</p>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="card llp-countbox">
              <div class="card-body text-center">
                <h1 class="card-title">700</h5>
                  <p class="card-text">Total students joined</p>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="card llp-countbox">
              <div class="card-body text-center">
                <h1 class="card-title">08</h5>
                  <p class="card-text">Total instructor</p>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="card llp-countbox">
              <div class="card-body text-center">
                <h1 class="card-title">180</h5>
                  <p class="card-text">Total Live Hours</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h3>Upcoming cohorts</h3>
          </div>
          <table class="table llp-table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Instructor</th>
                <th scope="col">Participants</th>
                <th scope="col">Date/Time</th>
                <th scope="col" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>Otto</td>
                <td class="text-center"><i class="fas fa-ellipsis-v"></i></td>
              </tr>
              <tr>
                <td>1</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>Otto</td>
                <td class="text-center"><i class="fas fa-ellipsis-v"></i></td>
              </tr>
              <tr>
                <td>1</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>Otto</td>
                <td class="text-center"><i class="fas fa-ellipsis-v"></i></td>
              </tr>
              <tr>
                <td>1</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>Otto</td>
                <td class="text-center"><i class="fas fa-ellipsis-v"></i></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="row mt-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h3>Recent cohorts</h3>
          </div>
          <table class="table llp-table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Instructor</th>
                <th scope="col">Participants</th>
                <th scope="col">Date/Time</th>
                <th scope="col" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>Otto</td>
                <td class="text-center"><i class="fas fa-ellipsis-v"></i></td>
              </tr>
              <tr>
                <td>1</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>Otto</td>
                <td class="text-center"><i class="fas fa-ellipsis-v"></i></td>
              </tr>
              <tr>
                <td>1</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>Otto</td>
                <td class="text-center"><i class="fas fa-ellipsis-v"></i></td>
              </tr>
              <tr>
                <td>1</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>Otto</td>
                <td class="text-center"><i class="fas fa-ellipsis-v"></i></td>
              </tr>
            </tbody>
          </table>
        </div>
      </main>
      <!-- main ends -->

    </div>
  </div>
</div>
<!-- container ends -->
<!-- <div class="card-header"> Welcome {{Auth::user()->firstname}}</div> -->
<!-- <div class="card-body">
@if (session('success'))
<div class="alert alert-success" role="alert">
  {{ session('success') }}
</div>
@endif
</div> -->
@endsection
