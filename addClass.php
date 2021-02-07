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

    if(isset($_GET['id']) && isset($_GET['status'])){
        $courseId = $_GET['id'];
        $courseStatus = $_GET['status'];

        if($courseStatus == "Deactivate"){
            $sqlCourse = "update subject set status='Inactive' where id=$courseId";
            $con->query($sqlCourse);
        }else if($courseStatus == "Activate"){
            $sqlCourse = "update subject set status='Active' where id=$courseId";
            $con->query($sqlCourse);
        }
        

    }

    if(isset($_POST['addClass'])){
        $year = $_POST['year'];
        $section = $_POST['section'];
        $course = $_POST['course'];
        $teacher = $_POST['teacher'];

        if($year != 0 && $section != 0 && $course != 0 && $teacher != 0){
            $sqlMaxId = "select max(id) as id from class";
            $resultMaxId = $con->query($sqlMaxId)or die($con->error);
            $rowMaxId = $resultMaxId->fetch_assoc();
            $rowMaxId = $rowMaxId['id'];
            $rowMaxId++;
           

            $sqlAddClass = "insert into class(id,year,section,course_id,teacher_id)value('$rowMaxId','$year','$section','$course','$teacher')";
            $con->query($sqlAddClass)or die($con->error);
        }else{
            echo "zero";
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


                            echo "<li id='toggle2'><a href='#'>学生<span class='fas fa-caret-down' id='arrow1'></span></a></li>";
                                echo "<li id='nested3'><a href='addStudent.php'>学生を追加</a></li>";

                            echo "<li><a  href='addCourse.php'>コースを追加</a></li>";
                            echo "<li><a href='#'>科目を追加</a></li>";
                            echo "<li><a class='activeLink' href='addClass.php'>クラスを追加</a></li>";
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

            <div class="main-containerCourse">
            <div class="addCourse">
                <button class="add-course-btn" onclick="ShowForm()">Add Class</button></br>
                <form action="addSubject.php" method="post">
                    
                </form>
                
              </div>
                    <table id="courseList">
                        <tr>
                            <th colspan="7" style="text-align:center;">
                            クラスのリスト</th>
                        </tr>
                        <tr>
                            <th>ID</th>
                            <th>Year</th>
                            <th>Section</th>
                            <th>コース</th>
                            <th>先生</th>
                            <th>アクティビティ</th>
                               
                            
                            
                        </tr>
                        <?php
                            $sqlCourse = "select t.id as teacher_id,c.id as class_id,ss.status_desc as status_desc,cs.section as section,co.name as name,t.last_name as last_name,t.first_name as first_name 
                            from class as c,student_status as ss,class_section as cs,course as co,teacher as t
                            where c.year = ss.id and c.section=cs.id and c.course_id=co.id and c.teacher_id=t.id";
                            $resultCourse = $con->query($sqlCourse) or die ($con->error);
                            $courseCnt = $resultCourse->num_rows;
                            $rowsCourse = $resultCourse->fetch_assoc();
                            $classTeacherId = $rowsCourse['teacher_id'];
                            


                            
                            //echo $teacherId;
                            
                            if($courseCnt == 0){
                                echo "<tr>";
                                    echo "<td colspan='5'>クラスがありません。</td>";
                                echo "</tr>";
                            }else{
                                do{
                                    echo "<tr>";

                                        echo "<td>{$rowsCourse['class_id']}</td>";
                                        echo "<td>{$rowsCourse['status_desc']}</td>";
                                        echo "<td>{$rowsCourse['section']}</td>";
                                        echo "<td>{$rowsCourse['name']}</td>";
                                        echo "<td>{$rowsCourse['last_name']} {$rowsCourse['first_name']}</td>";
                                        $classTeacherId = $rowsCourse['teacher_id'];
                                        echo "<select name='teacher'>";
                                        
                                        echo "<option value='0'>先生を選択</option>";
                                        /// update teacher selector
                                        $sqlUpdateTeacher = "select * from teacher";
                                        $resultUpdateTeacher = $con->query($sqlUpdateTeacher)or die($con->error);
                                        $rowUpdateTeacher = $resultUpdateTeacher->fetch_assoc();
                                        $teacherId = $rowUpdateTeacher['id'];
                                            do{
                                                
                                                    echo "<option>{$rowUpdateTeacher['id']}</option>";
                                                
                                            }while($rowUpdateTeacher = $resultUpdateTeacher->fetch_assoc());
                                        echo "</select>";
                                        
                                        
                                        echo "<td>";
                                        
                                        echo "</td>";



                                    //     $courseStatus = $rowsCourse['status'];
                                    //     $courseStatus = ($courseStatus == "Active" ? "Deactivate" : "Activate");
                                    // if($courseStatus == "Active"){
                                    //     echo "<td><button><a href='addSubject.php?id=" . $rowsCourse['id'] . "&status=" . $courseStatus . "'>$courseStatus</a></button></td>";
                                    // }else{
                                    //     echo "<td><button><a href='addSubject.php?id=" . $rowsCourse['id'] . "&status=" . $courseStatus . "'>$courseStatus</a></button></td>";
                                    // }
                                    
                                echo "</tr>";
                                }while($rowsCourse = $resultCourse->fetch_assoc());

                                

                                
                            }
                        ?>
                    </table>

                    <div class="add-course-form">
                    <a href="addClass.php"><button class="fas fa-times" id="times2""></button></a></br></br>

                    <table id="addCourseForm">
                        <form action="addClass.php" method="POST">
                            <tr>
                                <th>
                                    <label for="year" class="year">Year:</label>
                                </th>

                                <td>
                                    <select name="year" id="year" class="year">
                                        <option value="0">Select Year</option>
                                        <?php
                                            $sqlYear = "select * from student_status";
                                            $resultYear = $con->query($sqlYear) or die($con->error);
                                            $rowYear = $resultYear->fetch_assoc();

                                            do{
                                                if($rowYear['status_desc'] != "卒業者"){
                                                    echo "<option value=" .  $rowYear['id'] . ">{$rowYear['status_desc']}</option>";
                                                }
                                                
                                            }while($rowYear = $resultYear->fetch_assoc())

                                        ?>

                                    </select>
                                </td>
                                
                            </tr>
                                <th><label for="section" class="section">Section:</label></th>
                                <td>
                                    <select name="section" id="section" class="section">
                                    <option value="0">Select Section</option>
                                            <?php
                                                $sqlSection = "select * from class_section";
                                                $resultSection = $con->query($sqlSection)or die ($con->error);
                                                $rowSection = $resultSection->fetch_assoc();

                                                do{
                                                    echo "<option value=" . $rowSection['id'] . ">{$rowSection['section']}</option>";

                                                }while($rowSection = $resultSection->fetch_assoc());
                                            ?>

                                    </select>
                                </td>

                            <tr>
                                <th><label for="course" class="course">コース:</label></th>
                                <td>
                                    <select name="course" id="course" class="course">
                                        <option value="0">Select Course</option>

                                        <?php
                                            $sqlCourse = "select * from course";
                                            $resultCourse = $con->query($sqlCourse)or die($con->error);
                                            $rowCourse = $resultCourse->fetch_assoc();

                                            do{
                                                echo "<option value=" . $rowCourse['id'] . ">{$rowCourse['name']}</option>";    
                                            }while($rowCourse = $resultCourse->fetch_assoc());
                                            
                                        
                                        ?>
                                    </select>
                                </td>
                            </tr>


                            <tr>
                                <th><label for="teacher" class="teacher">先生:</label></th> 
                                <td>
                                    <select name="teacher" id="teacher" class="teacher">
                                            <option value="0">先生を選択</option>
                                            <?php
                                                $sqlTeacher = "select * from teacher where not status='Inactive'";
                                                $resultTeacher = $con->query($sqlTeacher)or die ($con->error);
                                                $rowTeacher = $resultTeacher->fetch_assoc();

                                                do{
                                                    echo "<option value=" . $rowTeacher['id'] . ">{$rowTeacher['last_name']} {$rowTeacher['first_name']}</option>";
                                                }while($rowTeacher = $resultTeacher->fetch_assoc());
                                            ?>
                                    </select>
                                </td>
                            </tr>

                            
                            
                            <tr>
                                <td></td>
                                <td><input type="button" onclick="reset()" value="Reset">&nbsp;&nbsp;
                                <input type="submit" name="addClass" value="Submit"></td>
                            </tr>
                            
                        </form>
                    </table>
                </div>
            </div>
            

        </div>
        <script type="text/javascript"  src="js/addSubject.js"></script>
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