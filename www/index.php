<?php 
    require_once('config.php');
    session_start();
    date_default_timezone_set('Asia/Ho_Chi_Minh'); // get date time of Viet Nam
    if(empty($_SESSION['username'])){
        header("Location: login.php");
    }
    $username = $_SESSION["username"];
    $phongban = $_SESSION['phongban'];
    if($username == "admin"){
        header("Location: admin/admin.php");
    }
    $order = "";
    if(isset($_GET["order"])){
        $order = $_GET['order']; // order for get method1
    }

    $error = "";
    $success = "";

    // get info user
    $result = get_info($username);
    if($result['code'] == 0){
        $data = $result['data'];
    }
    //end get info user
    
    // get task
    $result1 = get_task($data['firstName']." ".$data['lastName']);
    // end get task

    // get report
    $result2 = get_report($data['firstName'] . " ". $data['lastName']);
    // end get report

    // check truong phong
    $result3 = check_truong_phong($username);
    // print_r($result3);

    // update information user
    if(isset($_POST['updateInfo'])){
        $fName = $_POST['fName'];
        $lName = $_POST['lName'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phoneNumber = $_POST['phoneNumber'];
        $id = $_POST['id'];
        $birth = $_POST['birth'];
        $result4 = update_information_user($id, $fName, $lName, $birth, $email, $address, $phoneNumber);
        if($result4['code'] == 0){
            $success = $result4['message'];
        }else{
            $error = $result4['message'];
        }
    }

    // update password user
    if(isset($_POST['updatePWD'])){
        $pwd = $_POST['pwd'];
        $newPWD = $_POST['newPWD'];
        $confirmPWD = $_POST['confirmPWD'];
        $id = $_POST['id'];

        $result5 = update_password_user($id, $pwd, $newPWD, $confirmPWD);
        if($result5['code'] == 0){
            $success = $result5['message'];
        }else{
            $error = $result5['message'];
        }
    }

    // update avatar user
    if(isset($_POST['updateAvatar'])){
        $id = $_POST['id'];
        $avatar = "images/". $_FILES['avatar']['name'];
        if(move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar)){
            $result6 = update_avatar_user($id, $avatar);
            if($result6['code'] == 0){
                $success = $result6['message'];
            }else{
                $error = $result6['message'];
            }
        }else{  
            $error = "Không thể upload hình";
        }
      }
      // get information of task by maTask
    $maTask = "";
    $dataTask = "";
    if(isset($_GET['task'])){
        $maTask = $_GET['maTask'];
    }
    // handle start task


    // handle report
    if(isset($_POST['addReport'])){
//        print_r($_POST);
        $fromDay = $_POST['fromDay'];
        $toDay = $_POST['toDay'];
        $reason = $_POST['reason'];
        $PB = $_POST['PB'];
        $fName = $_POST['fName'];
        $lName = $_POST['lName'];
        $status = "Waiting";
        $username = $_POST['username'];

        $result_add_report = xin_nghi($username, $fName, $lName, $reason, $toDay, $fromDay, $PB, $status);
//        print_r($result_add_report);
        if ($result_add_report['code'] == 0){
            $success = $result_add_report['message'];
        }else{
            $error = $result_add_report['message'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Trang nhân viên</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/60364cba16.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php 
        if($result3){
            include("./api/sideBarTP.php");
        }else{
            include('./api/sidebar.php');
        }
    ?>
    <div class="container mt-5 mb-5">
    <?php 
        if($result3){
            if($order == "information"){
                // information page
                include("./api/information.php");
            }
            else if($order == "updateImage"){
                // update image page
                include("./api/updateImage.php");
            }
            else if($order == "updateInfo"){
                // update info page
                include("./api/updateInfo.php");
            }
            else if($order == "updatePassword"){
                // update password page
                include("./api/updatePWD.php");
            }
            else if($order == "manageReport"){
                // page manage Report
                include("./api/manageReport.php");
            }else if ($order == "manageTask"){
                // page manage Task
                include("./api/manageTask.php");
            }else if($order == "detailTask"){
                include("./api/detailTask.php");
            }else if($order == "report"){
                // report page
                include("./api/report.php");
            }
            else{
                // when first login go to the information page
                include("./api/information.php");
            }
        }else{
            if($order == "information"){
                // information page
                include("./api/information.php");
            }
            else if($order == "task"){
                // task page
                include("./api/task.php");
            }
            else if($order == "report"){
                // report page
                include("./api/report.php");
            }
            else if($order == "updateImage"){
                // update image page
                include("./api/updateImage.php");
            }
            else if($order == "updateInfo"){
                // update info page
                include("./api/updateInfo.php");
            }
            else if($order == "updatePassword"){
                // update password page
                include("./api/updatePWD.php");
            }else if($order == "detailTask"){
                include("./api/detailTask.php");
            }
            else{
                // when first login go to the information page
                include("./api/information.php");
            }
        }
    ?>
    </div>
    <?php 
        include("admin/footer.php");
    ?>
    <script src="js/script.js" defer></script>
    <script defer>
        $(document).ready(function ()  {
            let dulieu;
            const params = 'maTask='+encodeURI('<?=$dataTask['maTask']?>')
            $.get(`api/get-file.php?${params}`, function(data, status) {
                if(data.code == 0){
                    dulieu = data.data;
                    // console.log(dulieu);
                    for(let i = 0; i < dulieu.length; i++){
                        let tag = `
                         <li class="list-group-item">
                            ${split_name_file(dulieu[i].files)}
                            <?php
                                if(!$result3){
                                    ?>
                                        <p onclick="get_values_file('${split_name_file(dulieu[i].files)}',
                                        '<?=$dataTask['maTask']?>', ${dulieu[i].id}, '${dulieu[i].files}')"
                                       class="btn btn-danger"
                                       data-toggle="modal" data-target="#deleteFile">X
                                    </p>
                                    <?php
                                }
                            ?>

                          </li>
                    `;
                        $('#list').append(tag)
                    }
                }
            },"json");

            function split_name_file(name_file){
                const name_after = name_file.split("/")
                return name_after[1]
            }
        });
    </script>
</body>
</html>