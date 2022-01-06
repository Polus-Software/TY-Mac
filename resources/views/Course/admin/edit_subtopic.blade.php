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
    <div class="py-4">
            <h5>Course Title:<span> {{$course_title}}</span></h5>
            <hr class="my-4">
          </div>
      <!-- main -->
      <main>
      <div class="py-4">
          <ul class="nav nav-tabs llp-tabs">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('view-subtopics', ['course_id' => $course_id]) }}" style="text-decoration:none; color:inherit;">Subtopic list</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{{ route('create-subtopic', ['course_id' => $course_id]) }}" style="text-decoration:none; color:inherit;">New Subtopic</a>
          </li>
</ul>
        </div>
        <form action="{{ route('add-sub-topic') }}" class="row g-3 llp-form" method="POST">
          @csrf
          <input id="course_id" name="course_id" type="hidden" value="{{$course_id}}">
          
          <div class="row sub-topic-container">
            <input id="topic_count" name="topic_count" type="hidden" value="0">
          </div>
        <div class="row">
            <div class="col-12">
            <div id="add-sub-topic" class="mt-3"></div>
              <a class="btn btn-sm btn-outline-secondary" id="add_sub_topic_btn">Add a subtopic</a>
             
            </div>
      </div>
          
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
          <button class="btn btn-primary" type="submit">Save</button>
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

  const createNewElement = (el, classLists = [], attribs = {}, text ='') => {
    let tempEl ;
    if(el) tempEl = document.createElement(el);
    if(classLists){
      classLists.forEach((className)=> {
        tempEl.classList.add(className);
      });
    }
    if(typeof(attribs) !== 'undefined' && Array.isArray(attribs) && attribs.length>0) {
      attribs.forEach((attrs)=>{
        Object.keys(attrs).map(key=> {
          tempEl.setAttribute(`${key}`,`${attrs[key]}`);
        });
      });
    }
    if(text) tempEl.textContent = text;
    return tempEl;
  }
  
  document.querySelector('#add_sub_topic_btn').addEventListener('click', (e) => {
  e.preventDefault();
  const el = e.currentTarget;
  const subTopicContainerEl = document.querySelector('.sub-topic-container');
  subTopicContainerEl.appendChild(generateSubTopicHTML());
  document.getElementById('topic_count').value = parseInt(document.getElementById('topic_count').value)+1;
  sub_topic_count++;
  });

  const generateSubTopicHTML = () => {
    const cardEl = createNewElement('div', ['card', 'mb-3']);
    const cardbodyEl = createNewElement('div', ['card-body']);
    const cardtitleEl = createNewElement('h5', ['card-title'], [], 'Enter subtopic title');
    const topictitleEl = createNewElement('input', ['form-control'], [
      {"type": "text"}, {'name': `topic_title${sub_topic_count}`}, {'placeholder': 'Ex: Session 1 - Intro to G Suite & Google Drive'}
    ]);
    const innercardEl = createNewElement('div',['llpcard-inner', 'bg-light', 'mt-3', 'mb-3', 'p-3']);
    const contentCountEl = createNewElement('input', ['content_count'], [
      {'type': 'hidden'}, {'id': `content_count_topic_${sub_topic_count}`}, {'name': `content_count_topic_${sub_topic_count}`},{'value': 0}, {'rel': sub_topic_count}
    ]);
    const addContentContainerEl = createNewElement('div', ['row', 'content-container'], [
      {'id': `topic-${sub_topic_count}`}
    ]);
    const rowEl = createNewElement('div', ['row']);
    const colEl = createNewElement('div', ['col-12']);
    const addContentbtnEl = createNewElement('a', ['btn', 'btn-sm','me-2', 'btn-outline-secondary', `btn-sub-content`],[], 'Add content for sub-topic');
    addContentbtnEl.addEventListener('click', (e) => {
      const contentCountHiddenEl = e.currentTarget.parentElement.parentElement.parentElement.querySelector(`.content_count`);
      contentCountHiddenEl.value = parseInt(contentCountHiddenEl.value)+1;
      const topicNum = contentCountHiddenEl.getAttribute('rel');
      e.currentTarget.parentElement.parentElement.previousElementSibling.appendChild(generateContentHTML(topicNum, contentCountHiddenEl.value));
      content_count++;
    });
    const uploadContentbtnEl = createNewElement('a', ['btn', 'btn-sm', 'btn-outline-secondary'],[],'Upload audio/video');
    colEl.appendChild(addContentbtnEl);
    colEl.appendChild(uploadContentbtnEl);
    rowEl.appendChild(colEl);
    innercardEl.appendChild(contentCountEl);
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
  document.getElementById('topic_count').value = 1;
  sub_topic_count++;
}
generateSubTopicHTMLInitial();

  const generateContentHTML = (topicNum, contentCount) => {
    const contentContainerEl = createNewElement('div', ['card', 'card-body', 'mb-3']);
    const contentTitleEl = createNewElement('input', ['form-control', 'mb-3'], [
      {'type': 'text'},
      {'name': `content_title_${topicNum}_${contentCount}`},
      {'placeholder': 'Ex: What is Google Suite?'}
    ]);
    const addExternalLinkEl = createNewElement('div', ['add_external_link', 'mb-3']);
    const contentEl = createNewElement('div', ['row', 'p-2', 'flex-fill', 'bd-highlight']);
    const studyMaterialEl = createNewElement('div', ['col-lg-3'], [], 'Study material:');

    const uploadContainerEl = createNewElement('div', ['col-lg-5', 'col-12']);
    const uploadTextEl = createNewElement('label', [],[], 'Upload from device');
    const uploadFileEl = createNewElement('input', ['form-control'], [
      {'type': 'file'},
      {'name': `content_upload_${topicNum}_${contentCount}`}
    ]);
    const contentLinkContainerEl = createNewElement('div', ['col-lg-3', 'pt-4']);
    const externalLinkCountEl = createNewElement('input', ['externalLink_count'], [
      {'type': 'hidden'}, {'id': `externalLink_count_topic_${topicNum}_content_${contentCount}`},
      {'name': `externalLink_count_topic_${topicNum}_content_${contentCount}`},{'value': 0}
    ]);
    const contentLinkEl = createNewElement('a', ['btn', 'btn-sm', 'btn-outline-secondary'],[],'Add external link');
    contentLinkEl.addEventListener('click', (e) => {
    const linkCountHiddenEl = e.currentTarget.parentElement.parentElement.parentElement.querySelector('.externalLink_count');
    linkCountHiddenEl.value = parseInt(linkCountHiddenEl.value)+1;
    e.currentTarget.parentElement.parentElement.previousElementSibling.appendChild(generateExternalLinkHTML(topicNum, contentCount, linkCountHiddenEl.value));
    externallink_count++;
    });
    const removeContentContainerEl = createNewElement('div', ['col-lg-1', 'text-end']);
    const removeContentLinkEl = createNewElement('a');
    removeContentLinkEl.addEventListener('click', (e) => {
      e.currentTarget.parentElement.parentElement.parentElement.remove();
    });
    const removeIconEl = createNewElement('i', ['fas', 'fa-trash-alt']);
    removeContentLinkEl.appendChild(removeIconEl);
    removeContentContainerEl.appendChild(removeContentLinkEl);
    contentLinkContainerEl.appendChild(contentLinkEl);
    uploadContainerEl.appendChild(uploadTextEl);
    uploadContainerEl.appendChild(uploadFileEl);
    contentEl.appendChild(studyMaterialEl);
    contentEl.appendChild(uploadContainerEl);
    contentEl.appendChild(contentLinkContainerEl);
    contentEl.appendChild(removeContentContainerEl);
    contentContainerEl.appendChild(contentTitleEl);
    addExternalLinkEl.appendChild(externalLinkCountEl);
    contentContainerEl.appendChild(addExternalLinkEl);
    contentContainerEl.appendChild(contentEl);
    return contentContainerEl;
  }

  const generateExternalLinkHTML = (topicNum, contentCount, linkCount) => {
    const externalContainerEl = createNewElement('div', ['row', 'external-container', 'mb-3']);
    const labelContainerEl = createNewElement('div',['col-lg-4']);
    const labelEl = createNewElement('label', [], [], 'Add External Link');
    const divContainerEl = createNewElement('div', ['col-lg-8']);
    const inputEl = createNewElement('input', ['form-control'], [{'type': 'link'}, {'name': `external_topic${topicNum}_content_${contentCount}_link_${linkCount}`}]);
    divContainerEl.appendChild(inputEl);
    labelContainerEl.appendChild(labelEl);
    externalContainerEl.appendChild(labelContainerEl);
    externalContainerEl.appendChild(divContainerEl);
    return externalContainerEl;
  }

} 
  </script>

