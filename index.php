<?php
    if(!isset($_SESSION)){
        session_start();
    }
    if(isset($_SESSION['user'])){
        header("location:home.php");
    }
    include_once("connection/connection.php");
    $con = connection();


    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sqlAccessId = "select * from user where username='$username' and password='$password'";
        $resultAccessId = $con->query($sqlAccessId) or die($con->error);
        $row = $resultAccessId->fetch_assoc();
        $rowCnt = $resultAccessId->num_rows;

        $accessId = $row['access_id'];
        $id = $row['id'];
        
        
        

        if($rowCnt>0 && $rowCnt<2){
            switch($accessId){
                case 0:
                    $_SESSION['user'] = $row['username'];
                    $_SESSION['access'] = $row['access_id'];
                    $_SESSION['id'] = $row['id'];
                    echo header("location:home.php");
                    break;
                case 1:
                    $sqlS = "select * from admin_list where id='$id'";
                    $resultS = $con->query($sqlS) or die($con->error);
                    $row = $resultS->fetch_assoc();
                    if($row['status'] == 'Active'){
                        $sqlAccess = "select * from user where username='$username' and password='$password'";
                        $resultAccess = $con->query($sqlAccess) or die($con->error);
                        $rowSession = $resultAccess->fetch_assoc();
                        $total_user = $resultAccess->num_rows;

                            if($total_user > 0 && $total_user < 2){
                                $_SESSION['user'] = $rowSession['username'];
                                $_SESSION['access'] = $rowSession['access_id'];
                                $_SESSION['id'] = $rowSession['id'];
                                echo header("location:home.php");
                            }
                        
                    }else{
                        echo "inactive";
                    }
                    
                    break;
                case 2:
                    $sqlS = "select * from teacher where id='$id'";
                    $resultS = $con->query($sqlS) or die($con->error);
                    $row = $resultS->fetch_assoc();
                    if($row['status'] == 'Active'){
                        $sqlAccess = "select * from user where username='$username' and password='$password'";
                        $resultAccess = $con->query($sqlAccess) or die($con->error);
                        $rowSession = $resultAccess->fetch_assoc();
                        $total_user = $resultAccess->num_rows;
                        
                            if($total_user > 0 && $total_user < 2){
                                $_SESSION['user'] = $rowSession['username'];
                                $_SESSION['access'] = $rowSession['access_id'];
                                $_SESSION['id'] = $rowSession['id'];
                                echo header("location:home.php");
                            }
                    }else{
                        echo "inactive";
                    }
                    break;
                case 3:
                    $_SESSION['user'] = $row['username'];
                    $_SESSION['access'] = $row['access_id'];
                    $_SESSION['id'] = $row['id'];
                    echo header("location:home.php");
                    break;
            }

        }else{
            echo "no id";
        }

        
        

        // u.username,u.password,u.access_id,u.id,al.status,t.status
        // $sql = "select *
        // from user as u,admin_list as al
        // where u.username='$username' and u.password='$password' and al.status='Active'";
        // $user= $con->query($sql) or die($con->error);
        // $row = $user->fetch_assoc();
        // $total_user = $user->num_rows;

        
        
        
        // if($total_user > 0 && $total_user < 2){
        //     $_SESSION['user'] = $row['username'];
        //     $_SESSION['access'] = $row['access_id'];
        //     $_SESSION['id'] = $row['id'];
        //     echo header("location:home.php");
        // }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    
    <div class="login-box">
    <h1>Online Student Management System</h1>
    <form action="" method="post">
        <div class="textbox">
            <input type="text" placeholder="Username" name="username">
        </div>

        <div class="textbox">
            <input type="password" placeholder="Password" name="password">
        </div>

    <input class="btn" type="submit" name="login" value="Sign In">
    </form>
    </div>

</body>
</html>