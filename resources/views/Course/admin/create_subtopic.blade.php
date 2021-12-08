@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<!-- container -->
<div class="container llp-container">
  <div class="row">
  <div class="col-2 position-fixed">
      <!-- include sidebar here -->
      @include('Course.admin.sidebar')
    </div>
    <div class="col-9 ms-auto">
      <!-- main -->
      <main>
        
        <form action="{{ route('add-sub-topic') }}" class="row g-3 llp-form" method="POST">
          @csrf
          <div class="py-4">
            <h4>Course Title:<span>Lorem ipsum dolor sit amet</span></h4>
            <hr class="my-4">
          </div>
          <div class="row sub-topic-container">
          <!-- sub topic -->
          <!-- <div class="card mb-3">
          <div class="card-body">
          <h5 class="card-title">Enter subtopic title</h5>
          <input type="text" class="form-control" id="title" name="topic_title" placeholder="Ex: Session 1 - Intro to G Suite & Google Drive">
          <div class="llpcard-inner bg-light mt-3 mb-3 p-3">
          <div id="add-content"></div>
          <div class="row">
          <div class="col-12">
          <a class="btn btn-sm btn-outline-secondary btn-sub-content" id="add_content_btn">Add content for sub-topic</a>
          <a class="btn btn-sm btn-outline-secondary" id="upload_audio_video">Upload audio/video</a>
          </div>
          </div>
          </div>
          </div>
          </div> -->
          <!-- sub topic ends-->
          </div>
      <!-- <div class="row">
        <div class="col-12">
      
        </div>
      </div> -->
        <div class="row">
            <div class="col-12">
            <div id="add-sub-topic" class="mt-3"></div>
              <a class="btn btn-sm btn-outline-secondary" id="add_sub_topic_btn">Add a subtopic</a>
             
            </div>
      </div>
          
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
          <button class="btn btn-primary" type="submit">Save</button>
          <!-- <span id="test_span"></span> -->
          </div>
        </form>
      </main>
    </div>
  </div>
</div>
<!-- container ends -->
@endsection('content')
<script>
window.onload = function(event) {
  let sub_topic_count = 1;
  let content_count = 1;
  let externallink_count = 1;
  
  document.querySelector('#add_sub_topic_btn').addEventListener('click', (e) => {
  e.preventDefault();
  const el = e.currentTarget;
  const subTopicContainerEl = document.querySelector('.sub-topic-container');
  subTopicContainerEl.appendChild(generateSubTopicHTML());
  sub_topic_count++;
  });

  const generateSubTopicHTML = () => {
    const cardEl = document.createElement('div');
    cardEl.classList.add('card', 'mb-3');
    const cardbodyEl = document.createElement('div');
    cardbodyEl.classList.add('card-body');
    const cardtitleEl = document.createElement('h5');
    cardtitleEl.classList.add('card-title');
    cardtitleEl.textContent = 'Enter subtopic title';
    const topictitleEl = document.createElement('input');
    topictitleEl.classList.add('form-control');
    topictitleEl.setAttribute('type', 'text');
    topictitleEl.setAttribute('name', `topic_title${sub_topic_count}`);
    topictitleEl.setAttribute('placeholder', 'Ex: Session 1 - Intro to G Suite & Google Drive');
    const innercardEl = document.createElement('div');
    innercardEl.classList.add('llpcard-inner', 'bg-light', 'mt-3', 'mb-3', 'p-3');
    const addContentContainerEl = document.createElement('div');
    addContentContainerEl.classList.add('row', 'content-container');
    const rowEl = document.createElement('div');
    rowEl.classList.add('row');
    const colEl = document.createElement('div');
    colEl.classList.add('col-12');
    const addContentbtnEl = document.createElement('a');
    addContentbtnEl.classList.add('btn', 'btn-sm', 'btn-outline-secondary', `btn-sub-content`);
    addContentbtnEl.textContent = 'Add content for sub-topic';
    addContentbtnEl.addEventListener('click', (e) => {
      e.currentTarget.parentElement.parentElement.previousElementSibling.appendChild(generateContentHTML());
      content_count++;
    });
    const uploadContentbtnEl = document.createElement('a');
    uploadContentbtnEl.classList.add('btn', 'btn-sm', 'btn-outline-secondary');
    uploadContentbtnEl.textContent = 'Upload audio/video';
    colEl.appendChild(addContentbtnEl);
    colEl.appendChild(uploadContentbtnEl);
    rowEl.appendChild(colEl);
    innercardEl.appendChild(addContentContainerEl);
    innercardEl.appendChild(rowEl);
    cardbodyEl.appendChild(cardtitleEl);
    cardbodyEl.appendChild(topictitleEl);
    cardbodyEl.appendChild(innercardEl);
    cardEl.appendChild(cardbodyEl);
    return cardEl;
  }
const generateSubTopicHTMLInitial = () => {
  const subTopicContainerEl = document.querySelector('.sub-topic-container');
  subTopicContainerEl.appendChild(generateSubTopicHTML());
  sub_topic_count++;
}
generateSubTopicHTMLInitial();

  const generateContentHTML = () => {
    const contentContainerEl = document.createElement('div');
    contentContainerEl.classList.add('card', 'card-body', 'mb-3');
    const contnetTitleEl = document.createElement('input');
    contnetTitleEl.classList.add('form-control', 'mb-3');
    contnetTitleEl.setAttribute('type', 'text');
    contnetTitleEl.setAttribute('name', `content-title_${sub_topic_count}_${content_count}`);
    contnetTitleEl.setAttribute('placeholder', 'Ex: What is Google Suite?');
    const addExternalLinkEl = document.createElement('div');
    addExternalLinkEl.classList.add('add_external_link', 'mb-3');
    const contentEl = document.createElement('div');
    contentEl.classList.add('row', 'p-2', 'flex-fill', 'bd-highlight');
    const studyMaterialEl = document.createElement('div');
    studyMaterialEl.classList.add('col-lg-3');
    studyMaterialEl.textContent = 'Study material:';
    const uploadContainerEl = document.createElement('div');
    uploadContainerEl.classList.add('col-lg-5', 'col-12');
    const uploadTextEl = document.createElement('label');
    uploadTextEl.textContent = 'Upload from device';
    const uploadFileEl = document.createElement('input');
    uploadFileEl.classList.add('form-control');
    uploadFileEl.setAttribute('type', 'file');
    uploadFileEl.setAttribute('name', `upload_sub_topic_content_${sub_topic_count}_${content_count}`);
    const contentLinkContainerEl = document.createElement('div');
    contentLinkContainerEl.classList.add('col-lg-3', 'pt-4');
    const contentLinkEl = document.createElement('a');
    contentLinkEl.classList.add('btn', 'btn-sm', 'btn-outline-secondary');
    contentLinkEl.setAttribute('name', `upload_sub_topic_content_${sub_topic_count}_${content_count}`);
    contentLinkEl.textContent = 'Add external link';
    contentLinkEl.addEventListener('click', (e) => {
    e.currentTarget.parentElement.parentElement.previousElementSibling.appendChild(generateExternalLinkHTML());
    externallink_count++;
    });
    const removeContentContainerEl = document.createElement('div');
    removeContentContainerEl.classList.add('col-lg-1', 'text-end');
    const removeContentLinkEl = document.createElement('a');
    removeContentLinkEl.setAttribute('name', `upload_sub_topic_content_${sub_topic_count}_${content_count}`);
    removeContentLinkEl.addEventListener('click', (e) => {
      e.currentTarget.parentElement.parentElement.parentElement.remove();
    });
    const removeIconEl = document.createElement('i');
    removeIconEl.classList.add('fas', 'fa-trash-alt');
    removeContentLinkEl.appendChild(removeIconEl);
    removeContentContainerEl.appendChild(removeContentLinkEl);
    contentLinkContainerEl.appendChild(contentLinkEl);
    uploadContainerEl.appendChild(uploadTextEl);
    uploadContainerEl.appendChild(uploadFileEl);
    contentContainerEl.appendChild(contnetTitleEl);
    contentContainerEl.appendChild(addExternalLinkEl);
    contentEl.appendChild(studyMaterialEl);
    contentEl.appendChild(uploadContainerEl);
    contentEl.appendChild(contentLinkContainerEl);
    contentEl.appendChild(removeContentContainerEl);
    contentContainerEl.appendChild(contnetTitleEl);
    contentContainerEl.appendChild(addExternalLinkEl);
    contentContainerEl.appendChild(contentEl);
    return contentContainerEl;
  }

  const generateExternalLinkHTML = () => {
    const externalContainerEl = document.createElement('div');
    externalContainerEl.classList.add('row', 'external-container', 'mb-3');
    const labelContainerEl = document.createElement('div');
    labelContainerEl.classList.add('col-lg-4');
    const labelEl = document.createElement('label');
    labelEl.textContent = 'Add External Link';
    const divContainerEl = document.createElement('div');
    divContainerEl.classList.add('col-lg-8');
    const inputEl = document.createElement('input');
    inputEl.setAttribute('type', 'link');
    inputEl.setAttribute('name', `add_external_link_${sub_topic_count}_${content_count}_${externallink_count}`);
    inputEl.classList.add('form-control');
    divContainerEl.appendChild(inputEl);
    labelContainerEl.appendChild(labelEl);
    externalContainerEl.appendChild(labelContainerEl);
    externalContainerEl.appendChild(divContainerEl);
    return externalContainerEl;
  }

} 
  </script>


