function ShowForm(){
    var addTeacherForm = document.getElementsByClassName("add-teacher-form");
    var teacherList = document.getElementById("teacherList");
    var addTeacher = document.getElementsByClassName("addTeacher");
    addTeacherForm[0].style.display = "block";
    teacherList.style.display = "none";
    addTeacher[0].style.display = "none";
  }
  
  function hideForm(){
    var addTeacherForm = document.getElementsByClassName("add-teacher-form");
    var teacherList = document.getElementById("teacherList");
    var addTeacher = document.getElementsByClassName("addTeacher");
    document.getElementById("fn").value = "";
    document.getElementById("ln").value = "";
    document.getElementById("user").value = "";
    document.getElementById("pw").value = "";
    addTeacherForm[0].style.display = "none";
    teacherList.style.display = "block";
    addTeacher[0].style.display = "block";
  }
  
  function reset(){
    document.getElementById("fn").value = "";
    document.getElementById("ln").value = "";
    document.getElementById("user").value = "";
    document.getElementById("pw").value = "";
    document.getElementById("mobile").value = "";
    document.getElementById("address").value = "";
    document.getElementById("age").value = "";

  }