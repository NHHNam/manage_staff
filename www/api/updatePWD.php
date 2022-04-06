<small>
  <a href="index.php" class="text-primary">Back</a>
</small>
<form method="post" class="shadow-none p-3 mb-5 bg-light rounded">
  <div class="form-group">
    <label>Password</label>
    <input class="form-control" value="<?php if(!empty($pwd)) echo $pwd; ?>" type="password" name="pwd" id="pwd">
  </div>

  <div class="form-group">
    <label>New Password</label>
    <input class="form-control" value="<?php if(!empty($newPWD)) echo $newPWD; ?>" type="password" name="newPWD" id="newPWD">
  </div>

  <div class="form-group">
    <label>Confirm Password</label>
    <input class="form-control" value="<?php if(!empty($confirmPWD)) echo $confirmPWD; ?>" type="password" name="confirmPWD" id="confirmPWD">
  </div>

  <input type="hidden" name="id" value="<?=$data['id']?>">

  <div class="form-group">
      <?php
      include("alert.php");
      ?>
  </div>


  <div class="form-group">
    <input class="form-control btn btn-primary" type="submit" value="Save" name="updatePWD" id="updatePWD">
  </div>
</form>