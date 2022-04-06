<?php 
    require_once('../config.php');
    session_start();
    if(empty($_SESSION['username'])){
        header("Location: ../login.php");
    }

    $username = $_SESSION["username"];
    if($username != "admin"){
        header("Location: ../index.php");
    }
    // get info user
    $result = get_info($username);
    if($result['code'] == 0){
        $data = $result['data'];
    }
    //end get info user
    $order = "";
    if(isset($_GET['order'])){
        $order = $_GET['order'];
    }

    // print_r($_GET['order']);

    // get pb
    $result2 = get_pb();

    // add new staff
    $target_dir = "../images/";
    $success = "";
    $error = "";
    if(isset($_POST['addNV'])){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $birth = $_POST['birth'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $pwd = $_POST['username'];
        $phongban = $_POST['phongban'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $avatar = "images/".$_FILES['avatar']['name'];
        $target = $target_dir.$_FILES['avatar']['name'];
        if(move_uploaded_file($_FILES['avatar']['tmp_name'], $target)){
            $result1 = add_nv($username, $pwd, $fname, $lname, $birth, $email, $address, $phone, $phongban, $avatar, 15, 0);
            if($result1['code'] === 0){
                $success = $result1['message'];
            }else{
                $error = $result1['message'];
            }
        }else{
            $error = "Can not upload image";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/60364cba16.js" crossorigin="anonymous"></script>
    <script src="../js/script.js" defer></script>
    <style>
        .hero{
            margin: 50px;
        }
    </style>
</head>
<body>
    <?php 
        include("./nav.php");
    ?>
    <div class="container mt-5 mb-5">
        <?php 
            if($order == "manageStaff"){
                include("./manageStaff.php");
            }
            else if($order == "manageReport"){
                include("./manageReport.php");
            }else if($order == "addNV"){
                include("./addNV.php");
            }else if($order == "manageRoom"){
                include("./manageRoom.php");
            }else if($order == "staffRoom"){
                include("./staffRoom.php");
            }
            else{
                include("./listStaff.php");
            }
        ?>
    </div>

    <?php 
        include("./footer.php");
    ?>
</body>
</html>