<?php
//this script checks if the user is an admin

//admin user id
$admin = 69;

//user defaults to not an admin
$isAdmin = false;

//if the user is an admin, set $isAdmin to true.
if ((isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $admin)))
{
	$isAdmin = true;
}