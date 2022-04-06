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
        $dieukien = "admin";
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
        $conn->close();
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

    function submit_task($maTask, $list, $comment,$time){
        $conn = open_database();
        $sql = "INSERT INTO submitTask(maTask, arrayFile, comment,dateTime) values(?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $maTask, $list, $comment, $time);

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

    function xin_nghi($username,$fname, $lname, $reason, $toDay, $fromDay, $maPB, $status){
        $conn = open_database();
        $numDay = get_number_day($toDay, $fromDay) + 1;
        $releaseDay = get_release_day($fname, $lname);
        $nameNv = $fname." ".$lname;

        if($numDay > $releaseDay){
            return array('code' => 2, 'message' =>'Số ngày bạn muốn nghỉ đã vượt qua số ngày cho phép');
        }

        $sql = "insert into report(username, name, reason, fromDay, toDay, songay, PB, status) values(?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssiss', $username, $nameNv, $reason, $fromDay, $toDay, $numDay, $maPB, $status);

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

    // manage Room

    function edit_room($id, $name_room, $destination_room){
        $conn = open_database();
        $sql = "UPDATE phongban set namePB = ?, destination = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $name_room, $destination_room, $id);
        if(!$stmt->execute()){
            return array('code' => 1, 'message' =>'cannot execute command');
        }
        return array('code'=>0,'message'=>'Sửa thông tin phòng ban thành công');
    }

    function check_before_add_room_by_name($name_room){
        $conn = open_database();
        $sql = "SELECT * FROM phongban WHERE namePB = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param('s', $name_room);

        if((!$stmt->execute())){
            return array('code' => 1, 'message' =>'cannot execute command');
        }

        $result = $stmt->get_result();

        if($result->num_rows > 0){
            return true;
        }
        return false;

    }

    function check_before_add_room_by_destination($destination){
        $conn = open_database();
        $sql1 = "SELECT * FROM phongban WHERE destination = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param('s', $destination);
        if((!$stmt1->execute())){
            return array('code' => 1, 'message' =>'cannot execute command');
        }
        $result1 = $stmt1->get_result();
        if($result1->num_rows > 0){
            return true;
        }
        return false;
    }

    function add_room($name_room, $destination_room){
        $conn = open_database();
        if(check_before_add_room_by_name($name_room) == true || check_before_add_room_by_destination($destination_room) == true){
            return array('code'=>2, 'message'=>'Thông tin nhập phòng mới đã tồn tại vui lòng xem lại và nhập thông tin khác');
        }
        $sql = "INSERT INTO phongban(namePB, destination) VALUES(?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $name_room, $destination_room);
        if(!$stmt->execute()){
            return array('code' => 1, 'message' =>'cannot execute command');
        }
        return array('code'=>0,'message'=>'Thêm phòng ban mới thành công');
    }

    // end manage Room

    // list staff

    function reset_pwd($id, $pwd){
        $conn = open_database();
        $hash = password_hash($pwd, PASSWORD_DEFAULT);
        $sql = "UPDATE user set pwd = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $hash, $id);
        if(!$stmt->execute()){
            return array('code' => 1, 'message' =>'cannot execute command');
        }
        return array('code'=>0, 'message'=>'Reset password thành công cho nhân viên '.$pwd);
    }

    // end list staff

    // manage task by manager

    function get_list_task_manager($pb){
        $conn = open_database();
        $sql = "SELECT * FROM task WHERE phongban = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $pb);
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

    function get_staff_by_manager($pb){
        $conn = open_database();
        $condition = "nhân viên";
        $sql = "SELECT * FROM user WHERE phongban = ? and chucvu = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $pb, $condition);
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

    function get_staff_by_admin(){
        $conn = open_database();
        $condition = "trưởng phòng";
        $sql = "SELECT * FROM user WHERE chucvu = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s',  $condition);
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

    function add_task_manager($sender, $receiver, $name, $desc, $deadline, $phongban){
        $conn = open_database();
        $maTask = time().uniqid();
        $status = "New";
        $evaluate = "";
        $comment = "";
        $sql = "INSERT INTO task(maTask, sender, receiver, nameTask, descTask, deadline, status, phongban, evaluate, comment) VALUES(?, ?, ?, ?, ?, ?,?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssssssss', $maTask, $sender, $receiver, $name, $desc, $deadline, $status, $phongban, $evaluate, $comment);
        if(!$stmt->execute()){
            return array('code' => 1, 'message' =>'cannot execute command');
        }
        return array('code'=>0, 'message'=>'Thêm task mới thành công');
    }

    function get_desc_task_edit($id){
        $conn = open_database();
        $sql = "SELECT * FROM task WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        if(!$stmt->execute()){
            return array('code' => 1, 'message' =>'cannot execute command');
        }
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        return $data['descTask'];
    }

    function edit_task_manager($id, $name_task, $desc, $receiver){
        $conn = open_database();
        $sql = "UPDATE task SET nameTask = ?, descTask = ?, receiver = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $name_task, $desc, $receiver, $id);
        if(!$stmt->execute()){
            return array('code' => 1, 'message' =>'cannot execute command');
        }
        return array('code'=>0, 'message'=>'Sửa task thành công');
    }

    function delete_task_manager($id){
        $conn = open_database();
        $sql = "DELETE FROM task WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        if(!$stmt->execute()){
            return array('code' => 1, 'message' =>'cannot execute command');
        }
        return array('code'=>0, 'message'=>'Xoá task thành công');
    }

    function evaluate_approve_task($maTask, $comment, $quality){
        $conn = open_database();
        $status = "Completed";
        $sql = "UPDATE task set status = ? ,evaluate = ?, comment = ? WHERE maTask = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $status,$quality, $comment, $maTask);
        if(!$stmt->execute()){
            return array('code' => 1, 'message' =>'cannot execute command');
        }
        return array('code'=>0, 'message'=>'Chấp nhận task thành công');
    }
    function evaluate_reject_task($maTask, $comment, $quality){
        $conn = open_database();
        $status = "Rejected";
        $sql = "UPDATE task set status = ? ,evaluate = ?, comment = ? WHERE maTask = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $status,$quality, $comment, $maTask);
        if(!$stmt->execute()){
            return array('code' => 1, 'message' =>'cannot execute command');
        }
        return array('code'=>0, 'message'=>'Từ chối task thành công');
    }
    // end manage task by manager

    // manage report by manager

    function get_report_manager($pb, $username){
        $conn = open_database();
        $sql = "SELECT u.firstName, u.lastName, u.username, u.tongngaynghi, u.chucvu, r.id, r.reason, r.fromDay, r.toDay, r.songay, r.status FROM report r, user u WHERE r.username = u.username and r.username = ? and PB = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $username, $pb);
        if(!$stmt->execute()){
            return array('code' => 1, 'message' =>'cannot execute command');
        }
        $result = $stmt->get_result();
        $data = array();
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return array('code'=>0, 'message'=>'', 'data'=>$data);
    }

    function get_report_admin($username){
        $conn = open_database();
        $sql = "SELECT u.firstName, u.lastName, u.username, u.tongngaynghi, u.chucvu, r.id, r.reason, r.fromDay, r.toDay, r.songay, r.status FROM report r, user u WHERE r.username = u.username and r.username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        if(!$stmt->execute()){
            return array('code' => 1, 'message' =>'cannot execute command');
        }
        $result = $stmt->get_result();
        $data = array();
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return array('code'=>0, 'message'=>'', 'data'=>$data);
    }

    function update_day_release($username, $numDay){
        $conn = open_database();
        $sql = "Update user set tongngaynghi = tongngaynghi + ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('is', $numDay, $username);

        if(!$stmt->execute()){
            return array('code' => 1, 'message' =>'cannot execute command');
        }
        $result = $stmt->get_result();
        return array('code'=>0,'message'=>'Update day');
    }

    function change_status_report($id, $status){
        $conn = open_database();
        $sql = "Update report set status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $status, $id);
        if(!$stmt->execute()){
            return array('code' => 1, 'message' =>'cannot execute command');
        }
        $result = $stmt->get_result();
        return array('code'=>0,'message'=>'Update day');
    }
    // end manage report by manager

    //Room staff

    function get_staff_by_room($PB){
        $conn = open_database();
        $sql = "SELECT * FROM user WHERE phongban = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $PB);
        if(!$stmt->execute()){
            return array('code' => 1, 'message' =>'cannot execute command');
        }

        $result = $stmt->get_result();
        $data = array();
        while ($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return array('code'=>0, 'message'=>'', 'data'=>$data);
    }

    function choose_manager($id, $duocnghi){
        $conn = open_database();
        $chucvu = "trưởng phòng";
        $sql = "update user set chucvu = ?, duocnghi = ? where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sii', $chucvu, $duocnghi, $id);

        if(!$stmt->execute()){
            return array('code'=>1, 'message'=>'cannot execute command');
        }
        return array('code'=>0, 'message'=>'Bổ nhiệm tổ trưởng thành công');
    }

    function reject_manager($duocnghi, $id){
        $conn = open_database();
        $chucvu = "nhân viên";
        $sql = "update user set chucvu = ?, duocnghi = ? where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sii', $chucvu, $duocnghi, $id);

        if(!$stmt->execute()){
            return array('code'=>1, 'message'=>'cannot execute command');
        }
        return array('code'=>0, 'message'=>'Huỷ bổ nhiệm tổ trưởng thành công');
    }

    function check_has_truong_phong($maPB){
        $conn = open_database();
        $chucvu = "trưởng phòng";
        $sql = "SELECT * FROM user n, phongban p WHERE n.phongban = p.namePB and p.namePB = ? and n.chucvu = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $maPB, $chucvu);

        if(!$stmt->execute()){
            return array('code' =>1, 'message' =>'Cannot execute query');
        }
        $result = $stmt->get_result();
        if($result->num_rows == 0){
            return false;
        }
        return true;
    }

    //End Room staff
?>