<?php 
    define('host', 'mysql-server');
    define('username', 'root');
    define('password', 'root');
    define('db','quanlynhanvien');

    function split_file_name($fileName){
        $newName = explode('/',$fileName);
        return $newName[1];
    }

    function open_database(){
        $conn = mysqli_connect(host, username, password, db);
        if($conn->connect_error){
            die("Error connecting to database");
        }
        return $conn;
    }

    function check_match_password($id, $password){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $conn = open_database();
        $sql = "SELECT * FROM user WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        if($result->num_rows == 0){
            return array('code' => 2, 'message' => 'User are not exist');
        }
        $hash_password = $data['pwd'];
        if(!password_verify($password, $hash_password)){
            return false; // password không khớp
        }else{
            return true;
        }
    }

    function convert_day($day){
        return date("d/m/Y", strtotime($day));
    }

    function check_truong_phong($username){
        $conn = open_database();
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        if($data['chucvu'] == "trưởng phòng"){
            return true;
        }else{
            return false;
        }
    }

    function return_error_can_not_execute(){
        return array('code' => 1, 'message' => "Can't execute the command");
    }

    function login($username, $password){
        $conn = open_database();
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        if($result->num_rows == 0){
            return array('code' => 2, 'message' => 'User are not exist');
        }
        $hash_password = $data['pwd'];
        if(!password_verify($password, $hash_password)){
            return array('code' => 2, 'message' => 'Password or Username is not exits'); // password không khớp
        }
        return array('code' => 0, 'message'=>'','data' => $data);
    }
    
    function get_info($username){
        $conn = open_database();
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }
        $result = $stmt->get_result();
        if($result->num_rows == 0){
            return array('code' => 2, 'message' => 'User are not exist');
        }
        $data = $result->fetch_assoc();
        return array('code' => 0, 'message' =>'', 'data' => $data);
    }
    
    function get_task($username){
        $conn = open_database();
        $sql = "Select * from task WHERE receiver = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }
        $result = $stmt->get_result();
        if($result->num_rows == 0){
            return array('code'=>2, 'message'=>'Không có công việc nào được giao');
        }
        while ($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return array('code'=>0, 'message'=>'', 'data'=>$data);
    }

    function get_report($username){
        $conn = open_database();
        $sql = "Select * from report WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }
        $result = $stmt->get_result();
        if($result->num_rows == 0){
            return array('code'=>2, 'message'=>'Không có công việc nào được giao');
        }
        while ($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return array('code'=>0, 'message'=>'', 'data'=>$data);
    }

    function get_pb(){
        $conn = open_database();
        $sql = "SELECT * FROM phongban";
        $stmt = $conn->prepare($sql);
        
        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }

        $result = $stmt->get_result();
        if($result->num_rows == 0){
            return array('code' => 2, 'message' => 'Phongban is empty!');
        }
        
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return array('code' =>0, 'message'=>'', 'data'=>$data);
    }

    function add_nv($username, $pwd, $fname, $lname, $birth, $email, $address, $phone, $phongban, $image, $duocnghi, $tongngaynghi){
        $chucvu = "nhân viên";
        $hash = password_hash($pwd, PASSWORD_DEFAULT);
        $conn = open_database();
        $sql = "INSERT INTO user(username, pwd, firstName, lastName, birth, email, address, phonenumber, chucvu, phongban, image, duocnghi, tongngaynghi) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssssssssii', $username, $hash, $fname, $lname, $birth, $email, $address, $phone, $chucvu, $phongban, $image, $duocnghi, $tongngaynghi);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }
        return array('code' =>0, 'message'=>'Thêm nhân viên thành công');
    }

    function get_all_NV(){
        $dieukien = "Giám đốc";
        $conn = open_database();
        $sql = "SELECT * FROM user WHERE phongban != ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $dieukien);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }
        $result = $stmt->get_result();
        if($result->num_rows == 0){
            return array('code' => 2, 'message' => 'No employee in list');
        }
        $data = array();
        while ($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return array('code' => 0, 'message' => '', 'data' => $data);
    }

    function update_information_user($id, $firstname, $lastname, $birth, $email, $address, $phoneNumber){
        $conn = open_database();
        $sql = "UPDATE user set firstName = ?, lastName = ?, email = ?, address = ?, phonenumber = ?, birth = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssssi', $firstname, $lastname, $email, $address, $phoneNumber, $birth, $id);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }
        return array('code' => 0, 'message'=>'Thay đổi thành công');
    }

    function update_password_user($id, $oldpwd, $newpwd, $cpwd){
        $conn = open_database();
        if(check_match_password($id, $oldpwd) === false){
            return array('code' => 2, 'message'=>'Mật khẩu cũ nhập vào sai vui lòng nhập lại');
        }else if($cpwd !== $newpwd){
            return array('code' => 2, 'message'=>'Mật khẩu mới và mật khẩu xác nhận không trùng với nhau');
        }
        $hash = password_hash($newpwd, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET pwd = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $hash, $id);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }
        return array('code' => 0, 'message'=>'Thay đổi mật khẩu thành công');
    }

    function update_avatar_user($id, $avatar){
        $conn = open_database();
        $sql = "UPDATE user SET image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $avatar, $id);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }
        return array('code' => 0, 'message'=>'Thay đổi hình đại diện thành công');
    }

    function get_information_task_by_maTask($maTask){
        $conn = open_database();
        $sql = "SELECT * FROM task WHERE maTask = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $maTask);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }
        $result = $stmt->get_result();

        if($result->num_rows == 0){
            return array('code' => 2, 'message' => 'Không có dữ liệu về mã task này');
        }

        $data = $result->fetch_assoc();
        return array('code' => 0, 'message' =>'', 'data' => $data);
    }

    function add_curr_files($maTask, $files){
        $conn = open_database();
        $sql = "INSERT INTO curFiles(maTask, files) VALUES(?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $maTask, $files);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }
    }

    function get_curr_files($maTask){
        $conn = open_database();
        $sql = "SELECT * FROM curFiles WHERE maTask = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $maTask);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }
        $result = $stmt->get_result();
        $data = array();
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return array('code' =>0, 'message'=>'', 'data'=>$data);
    }

    function delete_file_pre_submit($maTask, $id){
        $conn = open_database();
        $sql = "DELETE FROM curFiles WHERE maTask = ? and id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $maTask, $id);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }

        return array('code' =>0, 'message'=>'Đã xoá file thành công');
    }

    function get_file_by_id($id){
        $conn = open_database();
        $sql = "SELECT * FROM curFiles WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        return array('code' => 0, 'message' =>'', 'data' => $data);
    }

    function submit_task($maTask, $list, $time){
        $conn = open_database();
        $sql = "INSERT INTO submitTask(maTask, arrayFile, dateTime) values(?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $maTask, $list, $time);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }

        return array('code'=>0, 'message' => 'Nộp task thành công');
    }

    function change_status_task($status, $maTask){
        $conn = open_database();
        $sql = "UPDATE task SET status = ? WHERE maTask = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $status,$maTask);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }
    }

    function get_history_submit($maTask){
        $conn = open_database();
        $sql = "SELECT * FROM submitTask WHERE maTask = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $maTask);

        if(!$stmt->execute()){
            return return_error_can_not_execute();
        }
        $result = $stmt->get_result();
        $data = array();
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return array('code' =>0, 'message'=>'', 'data'=>$data);
    }

    // function of report
    function get_number_day($toDay, $fromDay){
        $conn = open_database();
        $sql = "SELECT DATEDIFF(?, ?) as numDay";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $toDay, $fromDay);
        $stmt->execute();
        $result = $stmt->get_result();
        $dataNumDay = $result->fetch_assoc();
        return $dataNumDay['numDay'];
    }

    function get_release_day($fname, $lname){
        $conn = open_database();
        $sql = "select * from user where firstName = ? and lastName = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $fname, $lname);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $releaseDay = $data['duocnghi'] - $data['tongngaynghi'];
        return $releaseDay;
    }

    function xin_nghi($fname, $lname, $reason, $toDay, $fromDay, $maPB, $status){
        $conn = open_database();
        $numDay = get_number_day($toDay, $fromDay) + 1;
        $releaseDay = get_release_day($fname, $lname);
        $nameNv = $fname." ".$lname;

        if($numDay > $releaseDay){
            return array('code' => 2, 'message' =>'Số ngày bạn muốn nghỉ đã vượt qua số ngày cho phép');
        }

        $sql = "insert into report(name, reason, fromDay, toDay, songay, PB, status) values(?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssiss', $nameNv, $reason, $fromDay, $toDay, $numDay, $maPB, $status);

        if(!$stmt->execute()){
            return array('code' => 1, 'message' =>'cannot execute command');
        }

        return array('code' => 0, 'message' =>'Xin nghỉ phép thành công');
    }

    function check_report($fname, $lname){
        $nameNV = $fname . " " .$lname;
        $conn = open_database();
        $sql = "SELECT * FROM report WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $nameNV);
        if(!$stmt->execute()){
            return array('code' => 1, 'message' =>'cannot execute command');
        }
        $result = $stmt->get_result();
        $data = array();
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return array('code' =>0, 'message'=>'', 'data'=>$data);
    }
    // end function of report
?>