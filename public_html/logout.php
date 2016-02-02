<?php
//start session so we can access the session array
session_start();

//clear the session array; with no user_id, the user is
//no longer logged in.
session_unset();

//destroy the session
session_destroy();

//redirect to the login page, where a user can sign in,
//or sign up (create account).
header('location: newsigninpage/Log.html');
?>