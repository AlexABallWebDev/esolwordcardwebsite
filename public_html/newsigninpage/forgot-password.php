<?php
ini_set('displace_errors', 1);
error_reporting(E_ALL);

require ("../../secure-includes/db.php");

$email = '';

//user is assumed to have not been found.
$userFound = false;

//if the form has been submitted
if (isset($_POST['submit']))
{
  $email = $_POST['email'];

  if(empty($email))
  {
    $errors[] = 'Please enter your email.';
  }
  else
  {
    $e = mysqli_real_escape_string($cnxn, trim($email));
  }
	
  if(empty($errors))
  {
    //check if a user exists with the given email
    $q = "SELECT user_id FROM users WHERE email='" . $e . "'";
    $r = @mysqli_query ($cnxn, $q);

    //print mysqli_connect_error();
    //Run the query.

    //check the result
    if (mysqli_num_rows($r)	== 1)
    {
			//we know an account with this email exists. Generate a new password.
			$newPassword = substr(md5(uniqid(rand(),1)), 3, 10);
			
			//update the database with the new password.
			$q = "UPDATE users SET password = SHA1('$newPassword') WHERE email='" . $e . "'";
			$r = @mysqli_query ($cnxn, $q);
			
			//if the password was successfully updated, send email
			if (mysqli_affected_rows($cnxn) == 1)
			{
				//send an email with the new password. 
				$successfulEmail = false;
				$emailBody = 'Your password for the ESOL card website has been reset.' . "\n\n" .
							'You can change your password after logging into the ESOL card website by clicking' . "\n" .
							'the "Change Password" link in the sidebar on the left side of the page.' . "\n\n" .
							"Your new password is: $newPassword";
				$emailSubject = 'Password Reset for ESOL card website';
				$emailFrom = 'do-not-reply@ESOL-Admin.net';
				mail($e, $emailSubject, $emailBody, "From:$emailFrom");
				$userFound = true;
			}
			else
			{
				$errors[] = 'Error resetting password. Contact your instructor for more information.';
			}
    }
    else
    {
      $errors[] = 'The email address entered does not match any email address on file.';
    }
  }
	
	//close database connection.
	mysqli_close($cnxn);
}

?>


<!DOCTYPE HTML>
<html>

<head>
	<title>ESOL Card Website - Forgot Password Page</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!--[if lte IE 8]><script src="assets/js/html5shiv.js"></script><![endif]-->
	<link rel="stylesheet" href="assets/css/main.css" />
	<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	<noscript>
		<link rel="stylesheet" href="assets/css/noscript.css" />
	</noscript>
</head>

<body class="is-loading">

	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Main -->
		<section id="main">
			<header>
				<span class="avatar">
					<img src="images/gr.jpg" alt="" />
				</span>
				<h1> Reset Password</h1>

			</header>

      <?php
      if(isset($errors) && !empty($errors))
      {
         echo '<h1>Error!</h1><p class="form_error">The following error(s) occurred:<br />';
         foreach ($errors as $msg)
         {
           echo " - $msg<br />\n";
         }
         echo '</p><p>Please try again.</p>';
      }
      ?>
			<hr />
			
			<?php
				//if user not found (or form has not been submitted or errors occurred) show form
				if (!$userFound)
				{
					print '<form method="post">
						<div class="field">
							<label for="email">Enter your email address:</label>
							<input type="email" name="email" id="email" placeholder="Email" value="' . $email . '" />
						</div>
						<div class="field">
							<div class="select-wrapper">
		
							</div>
						</div>
		
						<ul class="actions">
							<li><button class="button" type="submit" name="submit">Submit</button></li>
							<hr />
							<li><a href="Log.html" class="button">Back to login page</a></li>
						</ul>
					</form>
					<hr />';
				}
				//user was found, display message telling them to check their email for a new password
				else
				{
					print '<p>Your password has been reset. Check your email for your new password.</p>';
					print '<ul class="actions">
									<li><a href="Log.html" class="button">Back to login page</a></li>
								</ul>';
				}
			?>


			<!-- Scripts -->
			<!--[if lte IE 8]><script src="assets/js/respond.min.js"></script><![endif]-->
			<script>
				if ('addEventListener' in window) {
					window.addEventListener('load', function() {
						document.body.className = document.body.className.replace(/\bis-loading\b/, '');
					});
					document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
				}
			</script>

</body>

</html>
