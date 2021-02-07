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

    
    // $sqlId = "select * from student where id='$id'";
    // $sqlId = "select * from admin_list where id='$id'";
    // $sqlId = "select * from teacher where id='$id'";
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
    $rowUser = $userId->fetch_assoc();

    $activateId;
    $activateStatus;

    if(isset($_GET['id']) && isset($_GET['status'])){
      $activateId= $_GET['id'];
      $activateStatus = $_GET['status'];

      if($activateStatus == "Active"){
        $sqlStatus = "update teacher set status='Inactive' where id=$activateId";
        $con->query($sqlStatus);
      }else {
        $sqlStatus = "update teacher set status='Active' where id=$activateId";
        $con->query($sqlStatus);
      }

    }

    if(isset($_POST['addTeacher'])){
        $fn = $_POST['fname'];
        $ln = $_POST['lname'];
        $username = $_POST['username'];
        $pw = $_POST['pw'];
        $mobile = $_POST['mobile'];
        $age = $_POST{'age'};
        $address = $_POST['address'];
        $sex = $_POST['sex'];

        

        $sqlTeacher = "select max(id) as id from user where access_id=2";
        $result = $con->query($sqlTeacher) or die ($con->error);
        $row = $result->fetch_assoc();
        
        $rowIdYear = $row['id'];
        $rowIdYear = substr($rowIdYear,0,4);
        // echo $rowIdYear;

        $yearNow = date("Y");
        
        if($yearNow == $rowIdYear){
            $rowId = $row['id'];
            $rowId++;
            $sqlNewAdmin = "insert into user(id,username,password,access_id)values('$rowId','$username','$pw','2')";
            $sqlNewAdmin2 = "insert into teacher(id,last_name,first_name,status,age,address,sex,mobile)
            value('$rowId','$ln','$fn','Inactive','$age','$address','$sex','$mobile')";
            $con->query($sqlNewAdmin) or die ($con->error);
            $con->query($sqlNewAdmin2) or die ($con->error);

        }else if($yearNow > $rowIdYear){
            $newId = 1;
            $newId = sprintf("%03d", $newId);
            $newId = $yearNow . "" . $newId;
            $sqlNewStd = "insert into user(id,username,password,access_id)values('$newId','$username','$pw','2')";
            $sqlNewStd2 = "insert into teacher(id,last_name,first_name,status,age,address,sex,mobile)
            value('$newId','$ln','$fn','Inactive','$age','$address','$sex','$mobile')";
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
                    <div class="logo"><img src="img/<?php echo($access == 0 ? "0admin.jpg" :  $rowUser['profile']);?>" alt=""></div>
                    
                    <div class="myName">
                    <?php 
                        if($access == 0){
                            echo "Admin";
                        }else{
                            echo $rowUser['first_name'];
                        }
                    ?>
                    </div>
                    <div class="myName">
                    <?php 
                    if($access != 0){
                        echo $rowUser['last_name'];
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
                            echo "<li id='toggle1'><a href='#' class='activeLink'>先生<span class='fas fa-caret-down' id='arrow1'></span></a></li>";
                                echo "<li id='nested1'><a class='activeLink' href='addTeacher.php'>先生を追加</a></li>";


                            echo "<li id='toggle2'><a href='#'>学生<span class='fas fa-caret-down' id='arrow1'></span></a></li>";
                                echo "<li id='nested3'><a href='addStudent.php'>学生を追加</a></li>";

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

            <div class="main-containerTeacher">
            <div class="addTeacher">
                <button class="add-teacher-btn" onclick="ShowForm()">Add Teacher</button>
              </div>
                    <table id="teacherList">
                        <tr>
                            <th colspan="7" style="text-align:center;">アドミンのリスト</th>
                        </tr>
                        <tr>
                            <th>ID</th>
                            <th>ユーザー</th>
                            <th>パスワード</th>
                            <th>名前</th>
                            <th>ステータス</th>
                            <th>アクティブ化/非アクティブ</th>
                            <th>デリート</th>
                        </tr>
                        <?php
                        $sqlUser = "select u.id,u.username,u.password,t.last_name,t.first_name,t.profile,t.status,u.access_id
                        from user as u,teacher as t
                        where u.id=t.id and u.access_id=2";
                        $resultUser = $con->query($sqlUser) or die ($con->error);
                        $rowUser = $resultUser->fetch_assoc();
                        do{
                            echo "<tr>";
                            echo "<form method='post' action='AddTeacher.php'>";
                            echo "<td>{$rowUser['id']}</td>";
                            echo "<td>{$rowUser['username']}</td>";
                            echo "<td>{$rowUser['password']}</td>";
                            echo "<td>{$rowUser['last_name']} {$rowUser['first_name']}</td>";
                            $userStatus = $rowUser['status'];

                            // echo($access == 0 ? "0admin.jpg" :  $row['profile']);
                            $userStatus = ($userStatus == "Active" ? "Active" : "Inactive");

                            echo "<td>$userStatus</td>";



                            echo "<td>";
                            if($userStatus == "Active"){
                                echo "<button><a href='addTeacher.php?id=" . $rowUser['id'] . "&status=" . $userStatus . "'>Deactivate</a></button>";
                            }else{
                                echo "<button><a href='addTeacher.php?id=" . $rowUser['id'] . "&status=" . $userStatus . "'>Activate</a></button>";
                            }

                            echo "</td>";
                            echo "<td>asd</td>";
                            echo "</form>";
                            echo "</tr>";

                        }while($rowUser = $resultUser->fetch_assoc());
                        ?>
                    </table>

                    <div class="add-teacher-form">
                    <a href="addTeacher.php"><button class="fas fa-times" id="times2"></button></a></br></br>

                    <table id="addTeacherForm">
                        <form action="addTeacher.php" method="POST">
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
                                <input type="submit" name="addTeacher" value="Submit"></td>
                            </tr>
                            
                        </form>
                    </table>
                </div>
            </div>
            

        </div>
        <script type="text/javascript"  src="js/addTeacher.js"></script>
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