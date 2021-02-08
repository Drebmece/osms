<?php
    function connection(){
        $host = "us-cdbr-east-03.cleardb.com";
        $username = "b50ec2bbe411a1";
        $password = "1ddadeb2";
        $db = "heroku_e0ea59585257e47";

        $con = new mysqli($host,$username,$password,$db);

        if($con->connect_error){
            echo $con->connect_error;
        }else{
            return $con;
        }
    }
?>