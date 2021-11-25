<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-6">
            <form action="" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="question" class="col-form-label">Question</label>
            <textarea class="form-control" id="assignment_question"></textarea>
          </div>
          <div class="mb-3">
            <label for="files" class="col-form-label">Upload material (if any)</label>
            <input type="file" name="files" id="files">
          </div>
        </form>
           
        </div>
    </div>
</div>