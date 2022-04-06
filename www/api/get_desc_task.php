<?php
    require_once("../config.php");
    if(isset($_POST['id'])){
        $id = $_POST['id'];
    }
    $result = get_desc_task_edit($id);
    $data = array('code'=>'0', 'data'=>$result);
    echo json_encode($data);
?>