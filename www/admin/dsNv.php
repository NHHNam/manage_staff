<?php 
    $result3 = get_all_NV();
    if($result3['code'] == 0){
        $data = $result3['data'];
    }else{
        $error = $result3['message'];
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
                        <a href="" class="btn btn-primary">View</a>
                    </td>
                </tr>        
            <?php
            $stt += 1;
        }
      ?>
    
  </tbody>
</table>