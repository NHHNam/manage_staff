<?php
//print_r($_GET)
    require_once('../config.php');
    $maTask = $_GET['maTask'];
    function get_list_file($maTask){
        $conn = open_database();
        $sql = "SELECT * FROM curFiles WHERE maTask = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $maTask);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }

        $result = $stmt->get_result();
        $data = array();
        while ($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return array('code'=>0, 'message'=>'Lấy dữ liệu thành công', 'data'=>$data);
    }

    $result = get_list_file($maTask);
    echo json_encode($result);
?>