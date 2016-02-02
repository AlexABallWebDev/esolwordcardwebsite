<?php
//this script checks the database for a user_id and that
//matches the user_id in the session global array. if a matching
//user_id is not found, then the user is redirected to the login/signup page.

//start session
session_start();

//if the user is logged on, check the user_id in the database
if (isset($_SESSION['user_id']))
{
	//get the user_id
	$checkLoggedUser = $_SESSION['user_id'];
	//get a connection to the database
	require('../secure-includes/db.php');
	
	//select user_id that matches the one supplied by the session array
	$sql = ('SELECT user_id FROM users WHERE user_id = ' . $checkLoggedUser);
	$result = @mysqli_query($cnxn, $sql);
	
	//if there is 1 result in the $result, then the user
	//appears to be correctly logged in. therefore, if there is NOT 1 result,
	//then the user needs to be redirected to the login/signup page.
	if (mysqli_num_rows($result) != 1)
	{
		header('location: newsigninpage/Log.html');
	}
	
	//check if user is admin. if they are, $isAdmin is true. otherwise false.
	require('check-admin-id.php');
	
	//close connection so that it does not just stay open for pages that do not
	//need a connection to the database.
	mysqli_close($cnxn);
}
//if the user is not logged in, redirect to login/signup page.
else
{
	header('location: newsigninpage/Log.html');
}