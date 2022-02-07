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
		<div class="row">
			<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mb-3">
				<form action="{{ route('admin.manager_reviews_filter') }}" enctype="multipart/form-data" method="GET" class="d-flex filter_table">
					@csrf
					<div class="col-md-4 m-lg-1">
						<input type="text" name="course" class="form-control" placeholder="Course Name" value="{{$course}}">
					</div>
					<div class="col-md-3 m-lg-1">
						<input type="text" name="comment" class="form-control" placeholder="Comment" value="{{$comment}}">
					</div>
					<div class="col-md-3 m-lg-1">
						<select name="rating" class="form-control">
							<option value="">Rating</option>
							<option value="1" @if($rating == '1') selected @endif>1</option>
							<option value="2" @if($rating == '2') selected @endif>2</option>
							<option value="3" @if($rating == '3') selected @endif>3</option>
							<option value="4" @if($rating == '4') selected @endif>4</option>
							<option value="5" @if($rating == '5') selected @endif>5</option>
						</select>
					</div>
					<div class="col-md-2 m-lg-1">
						<input type="submit" class="search form-control" value="Search">
					</div>
				</form>
			</div>
		</div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mb-3 table-responsive">
			<table class="table llp-table students_table reviews_table">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col" class="align-middle text-left">User</th>
						<th scope="col">Course</th>
						<th scope="col">Rating</th>
						<th scope="col">Comment</th>
						<th scope="col">Status</th>
						<th scope="col">Actions</th>
					</tr>
				</thead>
				<tbody>
					@php ($slno = 0)
					@if($totalCount > 0)
					@foreach($userfeedbacks as $userfeedback)
					@php ($slno = $slno + 1)
					<tr id="{{$userfeedback['id'] }}">
						<td>{{ $slno }}</td>
						<td id="username_{{$userfeedback['id'] }}">{{$userfeedback['user_name'] }}</td>
						<td>{{$userfeedback['course_name'] }}</td>
						<td class="align-middle text-center">{{$userfeedback['rating'] }}</td>
						<td >{{$userfeedback['firstpart'] }}@if($userfeedback['secondpart'] != '')<span class="more_content closed" id="more_content_{{$userfeedback['id'] }}">{{$userfeedback['secondpart'] }}</span><span id="dot_text_{{$userfeedback['id'] }}" class="dot_text">...</span><span class="dots closed" id="dots_{{$userfeedback['id'] }}" onclick='show_more({{$userfeedback['id'] }})'> More</span>
							@endif	
						</td>
						<td>
							@if($userfeedback['is_moderated'] == 1)
								<span class="badge rounded-pill bg-info text-dark bg-success" id="publish-badge-{{$userfeedback['id'] }}">Published</span>
							@else
								<span class="badge rounded-pill text-dark bg-warning" id="publish-badge-{{$userfeedback['id'] }}">Draft</span>
							@endif
						</td>
						<td>
							@if($userfeedback['is_moderated'] == 1)
								<a class="btn btn-primary d-block unpublish_btn" id="Publish_{{$userfeedback['id'] }}" data-moderated="{{$userfeedback['is_moderated']}}" data-id="{{$userfeedback['id'] }}" onClick="update_review_status('{{$userfeedback['id'] }}');" data-bs-toggle="modal" data-bs-target="#confirm_modal_unpublish">Unpublish</a>
							@else
								<a class="btn btn-primary d-block" id="Publish_{{$userfeedback['id'] }}" data-moderated="{{$userfeedback['is_moderated']}}" data-id="{{$userfeedback['id'] }}" onClick="update_review_status('{{$userfeedback['id'] }}');">Publish</a>
							@endif
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
<!-- New course modal -->
<div id="confirm_modal_unpublish" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="course_category" class="col-form-label">Are you sure want to Unpublish the comment made by the user '<span id="modal_user"></span>' ?</label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="unpublish" class="btn btn-primary" data-id="" onClick="update_review_status_as_unpublish();">Unpublish</button>
      </div>
    </div>
  </div>
</div>
<script>
function update_review_status(id){
	if(id == null) {
		return false;
	}
	else{
		let status = document.getElementById('Publish_'+id).getAttribute("data-moderated");
		if(status == 1){
			let username = document.getElementById('username_'+id).innerHTML;
			if(username){
				document.getElementById('modal_user').innerHTML = username;
				document.getElementById('unpublish').setAttribute("data-id",id);
			}
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
				  document.getElementById('Publish_'+id).setAttribute("data-moderated",1);
				  document.getElementById('Publish_'+id).setAttribute("data-bs-toggle",'modal');
				  document.getElementById('Publish_'+id).setAttribute("data-bs-target",'#confirm_modal_unpublish');
				} else {
				  document.getElementById('Publish_'+id).innerHTML = "Publish";
				  document.getElementById('publish-badge-'+id).innerHTML = "Draft"
				  document.getElementById('publish-badge-'+id).classList.remove('bg-success');
				  document.getElementById('publish-badge-'+id).classList.add('bg-warning');
				}
				//closeModal('confirm_modal_unpublish');
			});
		}
	}
}
function update_review_status_as_unpublish(){
	let id = document.getElementById('unpublish').getAttribute("data-id");
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
			  document.getElementById('Publish_'+id).setAttribute("data-moderated",1);
			} else {
			  document.getElementById('Publish_'+id).innerHTML = "Publish";
			  document.getElementById('publish-badge-'+id).innerHTML = "Draft"
			  document.getElementById('publish-badge-'+id).classList.remove('bg-success');
			  document.getElementById('publish-badge-'+id).classList.add('bg-warning');
			  document.getElementById('Publish_'+id).setAttribute("data-moderated",0);
			  document.getElementById('Publish_'+id).setAttribute("data-moderated",0);
			  document.getElementById('Publish_'+id).setAttribute("data-moderated",0);
			}
			document.getElementById('Publish_'+id).removeAttribute("data-bs-toggle");
			document.getElementById('Publish_'+id).removeAttribute("data-bs-target");
			closeModal('confirm_modal_unpublish');
		});
	}
}
function closeModal(modalId) {
    const truck_modal = document.querySelector('#' + modalId);
    const modal = bootstrap.Modal.getInstance(truck_modal);
    modal.hide();
  }
function show_more(element){
	if(document.getElementById('dots_'+element).classList.contains('open')){
		document.getElementById('dots_'+element).innerHTML = ' More';
		document.getElementById('dots_'+element).classList.remove('open');
        document.getElementById('dots_'+element).classList.add('closed');
		document.getElementById('more_content_'+element).classList.add('closed');
		document.getElementById('more_content_'+element).classList.remove('open');
		document.getElementById('dot_text_'+element).style.display = 'inline';
	}
	else{
		document.getElementById('dots_'+element).innerHTML = ' Less';
		document.getElementById('dots_'+element).classList.remove('closed');
        document.getElementById('dots_'+element).classList.add('open');
		document.getElementById('more_content_'+element).classList.add('open');
		document.getElementById('more_content_'+element).classList.remove('closed');
		document.getElementById('dot_text_'+element).style.display = 'none';
	}
	//document.getElementById('more_content_'+element).slideToggle();
}
</script>
<!-- container ends -->
@endsection('content')
