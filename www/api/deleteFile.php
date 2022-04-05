<?php 
    require_once('../config.php');
    $maTask = $_POST['maTask'];
    $id = $_POST['id'];
    $position = "../".$_POST['position'];
    if(unlink($position)){
        delete_file_pre_submit($maTask, $id);
    }
?>