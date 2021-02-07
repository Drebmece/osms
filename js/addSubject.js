function ShowForm(){
    var addCourseForm = document.getElementsByClassName("add-course-form");
    var courseList = document.getElementById("courseList");
    var addCourse = document.getElementsByClassName("addCourse");
    addCourseForm[0].style.display = "block";
    courseList.style.display = "none";
    addCourse[0].style.display = "none";
  }
  
  function hideForm(){
    var addCourseForm = document.getElementsByClassName("add-course-form");
    var courseList = document.getElementById("courseList");
    var addCourse = document.getElementsByClassName("addCourse");
    document.getElementById("course").value = "";
    document.getElementById("courseName").value = "";
    
    addCourseForm[0].style.display = "none";
    courseList.style.display = "block";
    addCourse[0].style.display = "block";
  }
  
  function reset(){
    document.getElementById("course").value = "";
    document.getElementById("courseName").value = "";
    
  }