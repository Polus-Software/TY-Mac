@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<!-- container -->
<div class="container-fluid llp-container">
  <div class="row">
  <div class="left_sidebar">
      <!-- include sidebar here -->
      @include('Layouts.admin.sidebar')
    </div>
    <div class="col-8 right_card_block">
      <!-- main -->
      <main>
        @csrf
        <section class="row g-3 llp-view">
        <div class="py-4"><h3 class="titles">Reviews</h3></div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mb-3 table-responsive">
			<table class="table llp-table students_table">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col" class="align-middle text-center">User</th>
						<th scope="col">Course</th>
						<th scope="col" class="align-middle text-center">Rating</th>
						<th scope="col" class="align-middle text-center">Comment</th>
						<th scope="col" class="align-middle text-center">Status</th>
						<th scope="col" class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody>
					@php ($slno = 0)
					@if(!empty($userfeedbacks))
					@foreach($userfeedbacks as $userfeedback)
					@php ($slno = $slno + 1)
					<tr id="{{$userfeedback['id'] }}">
						<td>{{ $slno }}</td>
						<td class="align-middle text-center">{{$userfeedback['user_name'] }}</td>
						<td>{{$userfeedback['course_name'] }}</td>
						<td>{{$userfeedback['rating'] }}</td>
						<td >{{$userfeedback['comment'] }}</td>
						<td class="align-middle text-center">
							@if($userfeedback['is_moderated'] == 1)
								<span class="badge rounded-pill bg-info text-dark bg-success" id="publish-badge-{{$userfeedback['id'] }}">Published</span>
							@else
								<span class="badge rounded-pill text-dark bg-warning" id="publish-badge-{{$userfeedback['id'] }}">Draft</span>
							@endif
						</td>
						<td class="align-middle text-center">
							<a class="btn btn-primary d-block" id="Publish_{{$userfeedback['id'] }}" data-id='{{$userfeedback['id'] }}' onClick="update_review_status('{{$userfeedback['id'] }}');">
								@if($userfeedback['is_moderated'] == 1)
									Draft
								@else
									Publish
								@endif
							</a>
						</td>
					</tr>
					@endforeach
					@else
						<tr>
							<td colspan="7"><h6 style="text-align:center;">No Reviews to show.</h6></td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="d-flex justify-content-end">
			{!! $userfeedbacks->links() !!}
		</div>
          </section>
      </main>
    </div>
	<div class="col-1"></div>
  </div>
</div>
<script>
function update_review_status(id){
	if(id == null) {
		return false;
	}
	else{
		let path = "{{ route('publish-review') }}?review_id=" + id
        fetch(path, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "X-CSRF-Token": document.querySelector('input[name=_token]').value
            },
           body: JSON.stringify({})
        }).then((response) => response.json()).then((data) => {
          if (data.status =='published'){
              document.getElementById('Publish_'+id).innerHTML = "Unpublish";
              document.getElementById('publish-badge-'+id).innerHTML = "Published"
              document.getElementById('publish-badge-'+id).classList.remove('bg-warning');
              document.getElementById('publish-badge-'+id).classList.add('bg-success');
            } else {
              document.getElementById('Publish_'+id).innerHTML = "Publish";
              document.getElementById('publish-badge-'+id).innerHTML = "Draft"
              document.getElementById('publish-badge-'+id).classList.remove('bg-success');
              document.getElementById('publish-badge-'+id).classList.add('bg-warning');
            }
        });
	}
}
  </script>
<!-- container ends -->
@endsection('content')
