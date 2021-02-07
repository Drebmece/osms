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
    $row = $userId->fetch_assoc();
    

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
                    <li><a class="activeLink" href="#">Dashboard</a></li>
                    <?php
                        if($access == 0){
                    ?>
                        <li><a  href="AddUser.php">ユーザーを追加</a></li>
                    <?php
                        }else if($access == 1){
                            echo "<li id='toggle1'><a href='#'>先生<span class='fas fa-caret-down' id='arrow1'></span></a></li>";
                                echo "<li id='nested1'><a  href='addTeacher.php'>先生を追加</a></li>";


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

            <div class="main-containers">
                <div class="dashRow">
                    <div class="dashCol">
                        <div class="dashStudent">
                            <img src="img/students.jpg">
                            
                            <?php
                                $sqlCountStd = "select * from student";
                                $resultSql = $con->query($sqlCountStd) or die($con->error);
                                $rowStd = $resultSql->num_rows;
                                echo "<span class='desc'>学生</br>$rowStd</span>";
                            ?>
                        </div>
                    </div>
                    <div class="dashCol">
                        <div class="dashTeacher">
                            <img src="img/teacher.jpg">
                            <?php
                                $sqlCountTeacher = "select * from teacher";
                                $resultTeacher = $con->query($sqlCountTeacher) or die($con->error);
                                $rowTeacher = $resultTeacher->num_rows;
                                echo "<span class='desc'>先生</br>$rowTeacher</span>";
                            ?>
                        </div>
                    </div>
                </div>

                <div class="dashRow">
                    <div class="dashCol">
                        <div class="dashFaculty">
                            <img src="img/faculty.jpg">
                            <?php
                                $sqlCountFaculty = "select * from admin_list";
                                $resultFaculty = $con->query($sqlCountFaculty) or die($con->error);
                                $rowFaculty = $resultFaculty->num_rows;
                                echo "<span class='desc'>事務員</br>$rowFaculty</span>";
                            ?>
                        </div>
                    </div>
                    <div class="dashCol">
                        <div class="dashCourse">
                            <img src="img/course.jpg">
                            <?php
                                $sqlCountCourse = "select * from course";
                                $resultCourse = $con->query($sqlCountCourse) or die($con->error);
                                $rowCourse = $resultCourse->num_rows;
                                echo "<span class='desc'>コース</br>$rowCourse</span>";
                            ?>
                        </div>
                    </div>
                </div>
                

                
            </div>
            

        </div>
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