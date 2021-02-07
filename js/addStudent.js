function ShowForm(){
    var addStdForm = document.getElementsByClassName("add-std-form");
    var stdList = document.getElementById("stdList");
    var addStd = document.getElementsByClassName("addStd");
    addStdForm[0].style.display = "block";
    stdList.style.display = "none";
    addStd[0].style.display = "none";
  }
  
  function hideForm(){
    var addStdForm = document.getElementsByClassName("add-std-form");
    var stdList = document.getElementById("stdList");
    var addStd = document.getElementsByClassName("addStd");
    document.getElementById("fn").value = "";
    document.getElementById("ln").value = "";
    document.getElementById("user").value = "";
    document.getElementById("pw").value = "";
    addStdForm[0].style.display = "none";
    stdList.style.display = "block";
    addStd[0].style.display = "block";
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