<?php
    //make sure user is logged in. redirect to login page otherwise.
    require('check-id.php');
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ESOL Card Website - Change Password</title>

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
  
  <?php
    
    //get all form values
    $user_id = $_SESSION['user_id'];
    $currentPass    = isset($_POST['currentPass'])  ? $_POST['currentPass'] : "";
    $newPass        = isset($_POST['newPass'])      ? $_POST['newPass']     : "";
    $reNewPass      = isset($_POST['reNewPass'])    ? $_POST['reNewPass']   : "";
    
    //delare errors placeholder
    $errors = array();
    //placeholder for successful password update
    $success = false;
    
    //check if data has been submitted
    if(isset($_POST['submit'])){
        
        //get database connection
        require('../secure-includes/db.php');
        
        //check if current password matches
        $sql = "SELECT * FROM users WHERE user_id = " . $user_id . ";";
        
        $result = @mysqli_query($cnxn, $sql);
        
        //make sure only one user gets returned
        if (mysqli_num_rows($result) != 1)
        {
            array_push($errors, "Error: Invalid User ID!");
            //die();
        }
        else
        {
            $row = mysqli_fetch_array($result);
            
            //review all value in user row
            $first_name = $row['first_name'];
            $last_name  = $row['last_name'];
            $email      = $row['email'];
            $password   = $row['password'];
            
            if($password == sha1($currentPass)){
                //change if new password matches
                if($newPass == $reNewPass){
                    //update with password
                    $sql = "UPDATE users SET user_id = " . $user_id . ", first_name = '" . $first_name . "', last_name = '" . $last_name . "', email = '" . $email . "', password = '" . sha1($newPass) . "' WHERE user_id = " . $user_id;
                    
                    //execute update
                    $result = @mysqli_query($cnxn, $sql);
                    
                    //if update failed, show an error. otherwise, redirect to card table page.
                    if ($result)
                    {
                        $success = true;
                        $currentPass = "";
                        $newPass = "";
                        $reNewPass = "";
                    }
                    else
                    {
                        array_push($errors, "Error: Failed to update password!");
                    }
                }else{
                    array_push($errors, "Error: New passwords do not match!");
                }
            }else{
                array_push($errors, "Error: Incorrect current password!");
            }
        }
        //close connection
        mysqli_close($cnxn);
    }
  ?>

<div class="container">
	<div class="row">
		<?php include 'side-menu.php';?>
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="well">
									<?php
											//display any errors that might have occured
											foreach ($errors as $error){
													echo "<h3 style='color:red'>$error</h3>";
											}
											if($success){
													echo "<h3 style='color:green'>Your password has been successfully updated!</h3>";
											}
									?>
				<h1>Change Password</h1>
				<div class="row row-centered">
					<div class="col-xs-12 col-md-6 col-centered card-container">
						<form accept-charset="UTF-8" action="<?php print $_SERVER["PHP_SELF"]; ?>" method="post">
							<div class='form-row'>
								<div class='col-xs-12 form-group required'>
									<label class='control-label'>Current password</label>
									<input class='form-control' size='4' type='password' value="<?php print $currentPass; ?>" name="currentPass">
								</div>
							</div>
							<div class='form-row'>
								<div class='col-xs-12 form-group required'>
									<label class='control-label'>New password</label>
									<input autocomplete='off' class='form-control card-number' size='20' type='password' value="<?php print $newPass; ?>" name="newPass">
								</div>
							</div>
							 <div class='form-row'>
								<div class='col-xs-12 form-group required'>
									<label class='control-label'>Repeat new password</label>
									<input autocomplete='off' class='form-control' size='20' type='password' value="<?php print $reNewPass; ?>" name="reNewPass">
								</div>
							</div>    
						 
							<div class='form-row'>
								<div class='col-md-12 form-group'>
									<button class='form-control btn btn-primary submit-button' type='submit' name="submit">Change password</button>                
								</div>
							</div>
						</form>    
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
  <?php include 'footer.html'; ?>
</body>
</html>