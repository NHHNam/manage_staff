<?php 
    $result3 = get_all_NV();
    if($result3['code'] == 0){
        $data = $result3['data'];
    }else{
        $error = $result3['message'];
    }

    // handle reset pwd user
    if (isset($_POST['reset_pwd'])){
//        print_r($_POST);
        $id_reset = $_POST['id-reset'];
        $pwd = $_POST['username-reset'];
        $resultReset = reset_pwd($id_reset, $pwd);
        if($resultReset['code'] == 0){
            $success = $resultReset['message'];
        }else{
            $error = $resultReset['message'];
        }
    }
?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Work Space</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
      <?php 
        $stt = 1;
        foreach($data as $a){

            ?>
                <tr>
                    <th scope="row"><?=$stt?></th>
                    <td><?=$a['firstName']?></td>
                    <td><?=$a['lastName']?></td>
                    <td><?=$a['phongban']?></td>
                    <td>
                        <p data-toggle="modal" data-target="#confirm-reset"
                           onclick="get_values_staff_reset(<?=$a['id']?>, '<?=$a['firstName']?>', '<?=$a['lastName']?>', '<?=$a['username']?>')"
                           class="btn btn-primary">Reset</p>
                    </td>
                </tr>        
            <?php
            $stt += 1;
        }
      ?>
    
  </tbody>
</table>
<?php
    include("../api/alert.php");
?>
<!-- Confirm reset pwd of staff -->
<div class="modal fade" id="confirm-reset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   Bạn có chắc là muốn reset password cho nhân viên <strong id="name_staff_reset">Nam</strong>
                    <input type="hidden" name="id-reset" id="id-reset">
                    <input type="hidden" name="username-reset" id="username-reset">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="reset_pwd" id="reset_pwd" class="btn btn-danger">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>