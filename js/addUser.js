function ShowForm(){
  var addUserForm = document.getElementsByClassName("add-user-form");
  var adminList = document.getElementById("adminList");
  var addUser = document.getElementsByClassName("addUser");
  addUserForm[0].style.display = "block";
  adminList.style.display = "none";
  addUser[0].style.display = "none";
}

function hideForm(){
  var addUserForm = document.getElementsByClassName("add-user-form");
  var adminList = document.getElementById("adminList");
  var addUser = document.getElementsByClassName("addUser");
  document.getElementById("fn").value = "";
  document.getElementById("ln").value = "";
  document.getElementById("user").value = "";
  document.getElementById("pw").value = "";
  addUserForm[0].style.display = "none";
  adminList.style.display = "block";
  addUser[0].style.display = "block";
}

function reset(){
  document.getElementById("fn").value = "";
  document.getElementById("ln").value = "";
  document.getElementById("user").value = "";
  document.getElementById("pw").value = "";
}