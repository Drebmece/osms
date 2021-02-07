<?php
    if(!isset($_SESSION)){
        session_start();
    }
    require_once("CheckSession.php");
    
    include_once("connection/connection.php");
    $con = connection();

    $user = $_SESSION['user'];
    $access = $_SESSION['access'];
    $id = $_SESSION['id'];

    
    $sqlId;
    switch($access){
        case 0:
            $sqlId = "select * from user where id='$id'";
            break;

        case 1:
            $sqlId = "select * from admin_list where id='$id'";
            break;

        case 2:
            $sqlId = "select * from teacher where id='$id'";
            break;

        case 3:
            $sqlId = "select * from student where id='$id'";
            break;
        
        default:
            echo header("location:index.php");
            

    }

    $userId = $con->query($sqlId) or die ($con->error);
    $row = $userId->fetch_assoc();

    $activateId;
    $activateStatus;

    $stdYear;
    $noStdCmt;
    $stdStatus;
    if(!isset($_POST['year'])){
        $stdYear=1;
        $stdStatus="1年生";
    }else{
        $stdStatus = $_POST['year'];
    }
    if($stdStatus=="卒業者"){
        $stdStatus = "5";
    }
    switch($stdStatus){
        case 1:
            $stdYear = 1;
            $noStdCmt = "1年生がいません";
            break;
        case 2:
            $stdYear = 2;
            $noStdCmt = "2年生がいません";
            break;
        case 3:
            $stdYear = 3;
            $noStdCmt = "3年生がいません";
            break;
        case 4:
            $stdYear = 4;
            $noStdCmt = "4年生がいません";
            break;
        case 5:
            $stdYear = 5;
            $noStdCmt = "卒業者がいません";
            break;
    }

    $stdId;
    $stdStatus;
    if(isset($_GET['id']) || isset($_GET['status'])){
        $stdId = $_GET['id'];
        $stdStatus = $_GET['status'];
        $stdNewStatus = $stdStatus + 1;
        $sql = "update student set status=$stdNewStatus where id = $stdId";
        $con->query($sql) or die($con->error);
        $stdYear = $stdStatus;
    }
    
    if(isset($_POST['addStd'])){
        $fn = $_POST['fname'];
        $ln = $_POST['lname'];
        $username = $_POST['username'];
        $pw = $_POST['pw'];
        $mobile = $_POST['mobile'];
        $age = $_POST{'age'};
        $address = $_POST['address'];
        $sex = $_POST['sex'];

        

        $sqlStudent = "select max(id) as id from user where access_id=3";
        $result = $con->query($sqlStudent) or die ($con->error);
        $row = $result->fetch_assoc();
        
        $rowIdYear = $row['id'];
        $rowIdYear = substr($rowIdYear,0,4);
        // echo $rowIdYear;

        $yearNow = date("Y");
        
        if($yearNow == $rowIdYear){
            $rowId = $row['id'];
            $rowId++;
            $sqlNewStd = "insert into user(id,username,password,access_id)values('$rowId','$username','$pw','3')";
            $sqlNewStd2 = "insert into student(id,last_name,first_name,status,age,address,sex,mobile)
            value('$rowId','$ln','$fn','1','$age','$address','$sex','$mobile')";
            $con->query($sqlNewStd) or die ($con->error);
            $con->query($sqlNewStd2) or die ($con->error);

        }else if($yearNow > $rowIdYear){
            $newId = 1;
            $newId = sprintf("%04d", $newId);
            $newId = $yearNow . "" . $newId;
            $sqlNewStd = "insert into user(id,username,password,access_id)values('$newId','$username','$pw','3')";
            $sqlNewStd2 = "insert into student(id,last_name,first_name,status,age,address,sex,mobile)
            value('$newId','$ln','$fn','1','$age','$address','$sex','$mobile')";
            $con->query($sqlNewStd) or die ($con->error);
            $con->query($sqlNewStd2) or die ($con->error);
        }
    }


    
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css" <?php echo date('l jS \of F Y h:i:s A'); ?>/>
    <link rel="stylesheet" type="text/css" href="css/style.css?" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    
    
</head>
<body>

        <div class="wrapper">
        <input type="radio" name="same" id="r1">
        <input type="radio" name="same" id="r2">
            <div class="container">
                <label for="r1" class="fas fa-bars" id="bars"></label>
                <label for="r2" class="fas fa-times" id="times"></label>
                <div class="outer">
                    <div class="logo"><img src="img/<?php echo($access == 0 ? "0admin.jpg" :  $row['profile']);?>" alt=""></div>
                    
                    <div class="myName">
                    <?php 
                        if($access == 0){
                            echo "Admin";
                        }else{
                            echo $row['first_name'];
                        }
                    ?>
                    </div>
                    <div class="myName">
                    <?php 
                    if($access != 0){
                        echo $row['last_name'];
                    }
                    ?>
                    
                    </div>
                </div>

                <ul>
                    <li><a href="home.php">Dashboard</a></li>
                    <?php
                        if($access == 0){
                    ?>
                        <li><a  href="AddUser.php">ユーザーを追加</a></li>
                    <?php
                        }else if($access == 1){
                            echo "<li id='toggle1'><a href='#'>先生<span class='fas fa-caret-down' id='arrow1'></span></a></li>";
                                echo "<li id='nested1'><a  href='addTeacher.php'>先生を追加</a></li>";


                            echo "<li id='toggle2'><a href='#'  class='activeLink'>学生<span class='fas fa-caret-down' id='arrow1'></span></a></li>";
                                echo "<li id='nested3'><a class='activeLink' href='addStudent.php'>学生を追加</a></li>";

                            echo "<li><a  href='addCourse.php'>コースを追加</a></li>";
                            echo "<li><a href='addSubject.php'>科目を追加</a></li>";
                            echo "<li><a href='addClass.php'>クラスを追加</a></li>";
                        }
                    ?>
                    

                    <li id="toggle1"><a href="#">Category<span class="fas fa-caret-down" id="arrow1"></span></a></li>
                        <li id="nested1"><a href="#">HTML Tutorials</a></li>
                        <li id="nested2"><a href="#">CSS Tutorials</a></li>

                    <li id="toggle2"><a href="#">Features<span class="fas fa-caret-down" id="arrow2"></span></a></li>
                        <li id="nested3"><a href="#">Updates</a></li>
                        <li id="nested4"><a href="#">Older ver.</a></li>


                    <li><a href="#">Contacts</a></li>
                    <li><a href="#">learn More</a></li>
                    <li><a href="#">Feedback</a></li>
                    <li><a href="#">About</a></li>
                </ul>
                <ul class="logout">
                    <li><a href="LogOut.php">Log Out</a></li>
                </ul>
            </div>

            <div class="main-containerStd">
            <div class="addStd">
                <button class="add-std-btn" onclick="ShowForm()">Add Student</button></br>
                <form action="addStudent.php" method="post">
                    <input class="yearSelector" type="submit" value="1年生" name="year">
                    <input class="yearSelector" type="submit" value="2年生" name="year">
                    <input class="yearSelector" type="submit" value="3年生" name="year">
                    <input class="yearSelector" type="submit" value="4年生" name="year">
                    <input class="yearSelector" type="submit" value="卒業者" name="year">
                </form>
                
              </div>
                    <table id="stdList">
                        <tr>
                            <th colspan="7" style="text-align:center;">
                            <?php echo ($stdStatus == 5 ? "卒業した" : "$stdStatus"); ?>
                            学生のリスト</th>
                        </tr>
                        <tr>
                            <th>ID</th>
                            <th>ユーザー</th>
                            <th>パスワード</th>
                            <th>名前</th>
                            <th>ステータス</th>
                            <th>アクティビティ</th>
                               
                            
                            
                        </tr>
                        <?php
                        $sqlUser = "select u.id,u.username,u.password,s.last_name,S.first_name,s.profile,s.status,ss.status_desc,u.access_id
                        from user as u,student as s,student_status as ss
                        
                        where u.id=s.id and u.access_id=3 and s.status=ss.id and s.status=$stdYear";
                        $resultUser = $con->query($sqlUser) or die ($con->error);
                        $rowUser = $resultUser->fetch_assoc();
                        $resultCnt = $resultUser->num_rows;
                        

                        if($resultCnt == 0){
                            echo "<tr>";
                            echo "<td colspan='7'>$noStdCmt</td>";
                            echo "</tr>";
                        }else{
                        do{
                            echo "<tr>";
                            echo "<form method='post' action='AddStudent.php'>";
                            echo "<td>{$rowUser['id']}</td>";
                            echo "<td>{$rowUser['username']}</td>";
                            echo "<td>{$rowUser['password']}</td>";
                            echo "<td>{$rowUser['last_name']} {$rowUser['first_name']}</td>";
                            $userStatus = $rowUser['status_desc'];
                            
                            // echo($access == 0 ? "0admin.jpg" :  $row['profile']);
                            

                            echo "<td>$userStatus</td>";

                            $status = $rowUser['status'];
                            
                            echo "<td>";
                            switch($status){
                                case 1:
                                    $nextStatus = $status +1;
                                    echo "<button><a href='addStudent.php?id=" . $rowUser['id'] . "&status=" . $status . "'>$nextStatus 年生にする</a></button>";
                                    
                                    break;
                                case 2:
                                    $nextStatus = $status +1;
                                    echo "<button><a href='addStudent.php?id=" . $rowUser['id'] . "&status=" . $status . "'>$nextStatus 年生にする</a></button>";
                                    
                                    break;
                                case 3:
                                    $nextStatus = $status +1;
                                    echo "<button><a href='addStudent.php?id=" . $rowUser['id'] . "&status=" . $status . "'>$nextStatus 年生にする</a></button>";
                                    break;
                                case 4:
                                    
                                    echo "<button><a href='addStudent.php?id=" . $rowUser['id'] . "&status=" . $status . "'>卒業させる</a></button>";
                                    break;
                                case 5:
                                    echo "Marksheet/Attendance";
                                    break;
                            }


                            

                            echo "</td>";
                            echo "</form>";
                            echo "</tr>";

                        }while($rowUser = $resultUser->fetch_assoc());
                    }
                        ?>
                    </table>

                    <div class="add-std-form">
                    <a href="addStudent.php"><button class="fas fa-times" id="times2"></button></a></br></br>

                    <table id="addStdForm">
                        <form action="addStudent.php" method="POST">
                            <tr>
                                <th><label for="fn" class="firstName">First Name:</label></th>
                                <td><input type="text" id="fn" name="fname"></br></td>
                            </tr>
                            <tr>
                                <th><label for="ln" class="lastName">Last Name:</label></th>
                                <td><input type="text" id="ln" name="lname"><br></td>
                            </tr>
                            <tr>
                                <th><label for="address" class="address">Address:</label></th>
                                <td><input type="text" id="address" name="address"><br></td>
                            </tr>
                            <tr>
                                <th><label for="age" class="age">Age:</label></th>
                                <td><input type="text" id="age" name="age"><br></td>
                            </tr>
                            <tr>
                                <th><label for="age" class="sex">Sex:</label></th>
                                <td>
                                <input type="radio" name="sex" style="text-align:left;" id="age">
                                <label for="age" class="sex">Male</label>
                                <input type="radio" name="sex" id="age">
                                <label for="age" class="sex">Female</label>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="mobile" class="mobile">Mobile:</label></th>
                                <td><input type="text" id="mobile" name="mobile"><br></td>
                            </tr>
                            <tr>
                                <th><label for="user" class="username">Username:</label></th>
                                <td><input type="text" id="user" name="username"></br></td>
                            </tr>
                            <tr>
                                <th><label for="pw" class="pw">Password:</label></th>
                                <td><input type="text" id="pw" name="pw"><br></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="button" onclick="reset()" value="Reset">&nbsp;&nbsp;
                                <input type="submit" name="addStd" value="Submit"></td>
                            </tr>
                            
                        </form>
                    </table>
                </div>
            </div>
            

        </div>
        <script type="text/javascript"  src="js/addStudent.js"></script>
        <script type="text/javascript">
        let toggle1 = document.querySelector("#toggle1");
        let toggle2 = document.querySelector("#toggle2");
        let nested1 = document.querySelector("#nested1");
        let nested2 = document.querySelector("#nested2");
        let nested3 = document.querySelector("#nested3");
        let nested4 = document.querySelector("#nested4");
        let arrow1 = document.querySelector("#arrow1");
        let arrow2 = document.querySelector("#arrow2");

        toggle1.addEventListener('click',()=>{
            if(nested1.style.display == "block" || nested2.style.display == "block"){
                nested1.style.display = "none";
                nested2.style.display = "none";
                arrow1.style.transform = "rotate(0deg)";
                arrow1.style.color = "#fff";
                arrow1.style.textShadow = "none";
            }else{
                nested1.style.display = "block";
                nested2.style.display = "block";
                arrow1.style.transform = "rotate(180deg)";
                arrow1.style.color = "#12fff1";
                arrow1.style.textShadow = "0 0 5px #12fff1";
            }
        });

        toggle2.addEventListener('click',()=>{
            if(nested3.style.display == "block" || nested4.style.display == "block"){
                nested3.style.display = "none";
                nested4.style.display = "none";
                arrow2.style.transform = "rotate(0deg)";
                arrow2.style.color = "#fff";
                arrow2.style.textShadow = "none";
            }else{
                nested3.style.display = "block";
                nested4.style.display = "block";
                arrow2.style.transform = "rotate(180deg)";
                arrow2.style.color = "#12fff1";
                arrow2.style.textShadow = "0 0 5px #12fff1";
            }
        });


        
    </script>
</body>
</html>