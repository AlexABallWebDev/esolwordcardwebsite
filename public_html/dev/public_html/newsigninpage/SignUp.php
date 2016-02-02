<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
$fName = '';
$lName = '';
$email = '';

require('signUpdata.php');


?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>ESOL Card Website - Sign Up Page</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<section id="main">
						<header>
							<span class="avatar"><img src="images/gr.jpg" alt="" /></span>
							<h1> Sign Up</h1>

						</header>

						<hr />

						<form method="post">
							<div class="field">
								<input type="text" name="fName" id="fName" placeholder="First Name" required="required" value="<?php
										print $fName;
										?>"/>
							</div>
							<div class="field">
								<input type="text" name="lName" id="lName" placeholder="Last Name" required="required" value="<?php
										print $lName;
										?>"/>
							</div>
							<div class="field">
								<input type="email" name="email" id="email" placeholder="Email" required="required" value="<?php
										print $email;
										?>"/>
							</div>
							<div class="field">
								<div class="select-wrapper">
									<select name="department" id="department">
										<option value="">Select Class</option>
										<option value="sales"> 8:00 AM </option>
										<option value="tech"> 9:00 AM </option>
										<option value="null"> 10:00 AM </option>
									</select>
								</div>
							</div>
							<div class="field">
								<input type="password" name="formPassword" id="upass" placeholder="Password" required="required" />
							</div>
							<!-- <div class="field">
								<input type="checkbox" id="human" name="human" /><label for="human">I'm a human</label>
							</div> -->
							<div class="field">
								<label>Are you a robot?</label>
								<input type="radio" id="robot_yes" name="robot" /><label for="robot_yes">Yes</label>
								<input type="radio" id="robot_no" name="robot" /><label for="robot_no">No</label>
							</div>
							<?php
							if (!$isValid)
							{
								foreach($errorLog as $message)
						    {
						      print $message;
						    }
							}
							?>
							<ul class="actions">
							<li><input type="submit" name="submitButton" value="submit"></li>
								<!-- <li><a href="../index.php" class="button">Get Started</a></li> -->
							</ul>
						</form>
						<hr />



				<!-- Footer -->
					<footer id="footer">

					</footer>

			</div>

		<!-- Scripts -->
			<!--[if lte IE 8]><script src="assets/js/respond.min.js"></script><![endif]-->
			<script>
				if ('addEventListener' in window) {
					window.addEventListener('load', function() { document.body.className = document.body.className.replace(/\bis-loading\b/, ''); });
					document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
				}
			</script>

	</body>
</html>
