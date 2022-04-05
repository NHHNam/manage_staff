<?php 
    session_start();
    require_once('config.php');
    $error = "";
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $pwd = $_POST['pwd'];
        $result = login($username, $pwd);
        if($result['code']==0){
            $data = $result['data'];
            if($data['chucvu'] == "admin"){
                header('Location: ./admin/admin.php');
                $_SESSION['username'] = $username;
                exit();
            }else{
                header('Location: index.php');
                $_SESSION['username'] = $username;
                $_SESSION['phongban'] = $data['phongban'];
                exit();
            }
        }else{
            $error = $result['message'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Login</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://kit.fontawesome.com/60364cba16.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="wrapper">
        <form method="post">
            <div class="main">
                <div class="imgage-form">
                    <img src="images/1.jpg" alt="Image Background">
                </div>
                <div class="form-login">
                    <p class="saying">XIN CHÀO!</p>
                    <div class="form-control">
                        <input type="text" class="input-control" value="<?php if(!empty($username)) echo $username; ?>" name="username" placeholder="Nhập tên đăng nhập">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="form-control">
                        <input type="password" class="input-control" value="<?php if(!empty($pwd)) echo $pwd; ?>" name="pwd" placeholder="Nhập mật khẩu">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <?php 
                        if(!empty($error)){
                            ?>
                                <div id="errorsLogin" style="background-color: #D10000;color: white;font-size: 15px;padding: 10px; border-radius: 10px;">
                                    <?=$error?>
                                </div>
                            <?php
                        }
                    ?>
                    <input type="submit" name="login" class="btn" value="Đăng nhập">
                </div>
            </div>
        </form>
    </div>
</body>
</html>