<?php

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//start session so that user can be logged in when they finish creating an account.
session_start();

//connection to database
require '../../secure-includes/db.php';

$isValid = true;
$errorLog = array();

if(isset($_POST['submitButton']))
{
  if(!empty($_POST['fName'])) {
    $fName = $_POST['fName'];
    $fName = test_input($_POST['fName']);
  } else {
    $errorLog[] = "<p class='form_error'>Please enter your first name!</p>";
    $isValid = false;
  }
  if(!empty($_POST['lName'])) {
    $lName = $_POST['lName'];
    $lName = test_input($_POST['lName']);
  } else {
    $errorLog[] =  "<p class='form_error'>Please enter your last name!</p>";
    $isValid = false;
  }

  if(!empty($_POST['email'])) {
    $email = $_POST['email'];
    $email = test_input($_POST['email']);
  } else {
    $errorLog[] =  "<p class='form_error'>Please enter your email!</p>";
    $isValid = false;
  }

  if(!empty($_POST['formPassword'])) {
    $formPassword = $_POST['formPassword'];
    $formPassword = test_input($_POST['formPassword']);
  } else {
    $errorLog[] =  "<p class='form_error'>Please enter your Password!</p>";
    $isValid = false;
  }
	
	//to protect the website, only humans can create accounts.
	if(empty($_POST['robot']) || $_POST['robot'] != 'no') {
    $errorLog[] =  "<p class='form_error'>You must not be a robot to continue.</p>";
    $isValid = false;
  }
  
	//if data is valid so far, check if email is in use.
	if ($isValid)
	{
		
		
		//clean email to be checked
		$email = mysqli_real_escape_string($cnxn, $email);
    
    $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
    $result = @mysqli_query($cnxn, $sql);
    
    //if the user already exsists, dont create a new user!
    if (mysqli_num_rows($result) >= 1){
    	$errorLog[] =  "<p class='form_error'>Email aready exists!</p>";
    	$isValid = false;
    }
	}

	//finally, if data is still valid then add new user to database.
  if($isValid) {
    //further clean data to be entered into the database
		$fName = mysqli_real_escape_string($cnxn, $fName);
		$lName = mysqli_real_escape_string($cnxn, $lName);
		$formPassword = mysqli_real_escape_string($cnxn, $formPassword);
		
    //we create a database object $dbh and a query, $sql, to query insert the database
    $sql="INSERT INTO users (first_name, last_name, email, password)
    VALUES ('$fName', '$lName', '$email', SHA1('$formPassword'))";
    //Preparing the statement
    $result = @mysqli_query($cnxn, $sql);
    if($result){
			//get their new user_id (causing them to be logged in) and redirect to the homepage
			$_SESSION['user_id'] = @mysqli_insert_id($cnxn);
      header('location: ../index.php');
    } else {
      echo "<p>Error " . mysqli_error($cnxn) . "</p>";
    }
  }
	
	//close database connection.
	mysqli_close($cnxn);
}