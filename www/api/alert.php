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