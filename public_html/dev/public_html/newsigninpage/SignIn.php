<?php
ini_set('displace_errors', 1);
error_reporting(E_ALL);

//start session so that the user can be signed in
session_start();

//admin user id
$admin = 69;

require ("../../secure-includes/db.php");

$email = '';
$password = '';

//if the login form is been submitted
if (isset ($_POST['submit']))
{
  $email = $_POST['email'];
  $password = $_POST['password'];

  if(empty($email))
  {
    $errors[] = 'Please enter your email.';
  }
  else
  {
    $e = mysqli_real_escape_string($cnxn, trim($email));
  }

  if(empty($password))
  {
    $errors[] = 'Please enter your password.';
  }
  else
  {
    $p = mysqli_real_escape_string($cnxn, trim($password));
  }

  if(empty($errors))
  {
    //retrieve the user id and name from email/pass combo
    $q = "SELECT user_id, first_name FROM users WHERE email='" . $e . "' AND password=SHA1('" . $p . "')";
    $r = @mysqli_query ($cnxn, $q);

    //print mysqli_connect_error();
    //Run the query.

    //check the result
    if (mysqli_num_rows($r)	== 1)
    {
      $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
      // return array(true, $row);
      $_SESSION['user_id'] = $row['user_id'];
			$userFound = true;

			//if is admin, set the session to reflect that this user is admin
			if ($_SESSION['user_id'] == $admin)
			{
				$_SESSION['admin'] = true;
			}
    }
    else
    {
      $errors[] = 'The email address and password entered do not match those on file.';
    }

		//if user was found and logged in, redirect
		if ($userFound && ($_SESSION['user_id'] == $admin))
		{
			//admin is redirected to the grade card table page.
			header("Location: ../grade-card-table.php");
		}
		else if ($userFound)
		{
			//print $_SESSION['user_id'];

			//normal user is sent to homepage.
			header("Location: ../index.php");
		}
  }

	//close database connection.
	mysqli_close($cnxn);
}

?>


<!DOCTYPE HTML>
<html>

<head>
	<title>ESOL Card Website - Sign In Page</title>
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
				<h1> Sign In</h1>

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

			<form method="post">
				<div class="field">
					<input type="email" name="email" id="email" placeholder="Email" value="<?php
							//make the email field sticky.
							//note: password is not sticky.
							print $email;
							?>" />
				</div>
				<div class="field">
					<input type="password" name="password" id="upass" placeholder="Password" />
				</div>
				<div class="field">
					<div class="select-wrapper">

					</div>
				</div>



	
      <ul class="actions">
        <li><a href="../index.php" class="button">Get Started</a></li>
          <hr />
        <li><a href="../SignUp.php" class="button">First Time User?</a></li>
        <li><a href="forgot-password.php" class="button">Forgot Password?</a></li>
      </ul>
    </form>
    <hr />


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
