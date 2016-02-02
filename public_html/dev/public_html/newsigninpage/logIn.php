<?php
//loginproc.php
ini_set('displace_errors', 1);
error_reporting(E_ALL);

require ("../../secure-includes/db.php");

// if(isset($users[$email]) AND $users[$email] == $password)

  //if the login form is been submitted
  if (isset ($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Check if email or password are blank
    if($email == "" or $password == "") {
      header("LocationL Login.php?pass=no");
    }
    //remove password so it doenst save it as a cookie
    //Check if email exists and password is correct
    if(isset($users[$email]) and $users[$email] == $password)
    {
      //see if remember is checked
      if(isset($_POST['remember']))
      {
        //set cookies for one week
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
      }
      else
      {
        //set temporary cookies
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
      }
      //redirect the user to the Admin page
      header("Location: ../index.php");
    }
    else {
      //destory the cookies
      $_SESSION["email"];
      $_SESSION["password"];
      header("Location: login.php?pass=no");
    }


  }



 ?>
