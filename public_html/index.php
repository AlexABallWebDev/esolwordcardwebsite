<?php
//make sure user is logged in. redirect to login page otherwise.
require('check-id.php');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ESOL Card Website - Home Page</title>

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
  crossorigin="anonymous">

  <link rel="stylesheet" href="style.css">

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="style.css">

</head>

<body>

  <?php include 'header.html'; ?>

  <div class="container">
    <div class="row">
      <?php include 'side-menu.php';?>
			<!-- changed from 8 to 12 -->
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="well">
					<?php
					if ($isAdmin)
					{
						require('instructor-index-main.html');
					}
					else
					{
						require('student-index-main.html');
					}
					?>
        </div>
      </div>
    </div>
  </div>
  <?php include 'footer.html'; ?>
</body>
</html>