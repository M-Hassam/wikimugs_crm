<form action="{{ route('file-import') }}" method="POST" enctype="multipart/form-data">
  <div class="custom-file">
  	@csrf
    <input type="file" class="custom-file-input" id="file" name="file">
    <label class="custom-file-label" for="customFile">Choose file</label>
  </div>
  <input type="submit" name="" value="upload">
</form>