<small>
  <a href="index.php" class="text-primary">Back</a>
</small>
<form class="shadow-none p-3 mb-5 bg-light rounded" method="post" enctype="multipart/form-data">

  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text">Upload</span>
    </div>
    <div class="custom-file">
      <input type="file" class="custom-file-input" name="avatar" accept="image/png, image/gif, image/jpeg, image/webp" id="inputGroupFile01">
      <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
    </div>
  </div>

  <input type="hidden" name="id" value="<?=$data['id']?>">

  <div class="form-group">
    <?php 
      if(!empty($success)){
        ?>
          <div class="form-control alert alert-success"><?=$success?></div>
        <?php
      }else if(!empty($error)){
        ?>
          <div class="form-control alert alert-danger"><?=$error?></div>
        <?php
      }
    ?>
  </div>

  <div class="form-group">
    <input type="submit" value="Save" name="updateAvatar" class="btn btn-primary form-control">
  </div>
</form>