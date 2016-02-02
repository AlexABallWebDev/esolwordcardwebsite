<?php

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//make sure user is logged in. redirect to login page otherwise.
require('check-id.php');

//this is an admin page. make sure the user is an admin. if not, redirect to homepage.
if (!$isAdmin)
{
	header('location: index.php');
}

//get card data.
//first, the card to be displayed is found in the GET array.
//if not, an error is shown instead of card data.
$emptyCardError = false;
if (!isset($_GET['card_id']))
{
	$emptyCardError = true;
}
else
{
	//get database connection
	require('../secure-includes/db.php');
	
	//assign the card id to a variable
	$card_id = $_GET['card_id'];
	
	//if the card was graded, update the card in the database, then redirect to the card table page.
	if (isset($_POST['submit']))
	{
		//comment is allowed to be empty, and submitted grade defaults to zero.
		//these values (if any) just have to be cleaned (not much validation)
		$newComment = $_POST['newComment'];
		$newComment = mysqli_real_escape_string($cnxn, test_input($newComment));
		
		$newGrade = $_POST['newGrade'];
		$newGrade = mysqli_real_escape_string($cnxn, test_input($newGrade));
		
		//setup statement to update comment and grade
		$sql = "UPDATE cards SET comment = '$newComment', grade = $newGrade WHERE card_id = $card_id";
		
		//execute update
		$result = mysqli_query($cnxn, $sql);
		
		//if update failed, show an error. otherwise, redirect to card table page.
		if ($result)
		{
			//setup the sql statement
			$sql = "SELECT chapter  FROM cards WHERE card_id = $card_id";
			$result = mysqli_query($cnxn, $sql);
			if (mysqli_num_rows($result) != 1){
				//TODO: handle error !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			}else{
				$row = mysqli_fetch_array($result);
				$chapter = $row['chapter'];
				header("location: grade-card-table.php?chapter=" . $chapter . "");
			}
			
		}
		else
		{
			$failedToUpdate = true;
		}
	}
	
	//setup the sql statement
	$sql = "SELECT * FROM cards WHERE card_id = $card_id";
	
	//do not show cards that have been set to not visible ("deleted" cards)
	$sql = $sql . " AND is_visible = TRUE";
	
	//check database for card. if card not found, display an error.
	//otherwise, get the data for the card and set data to variables.
	$result = mysqli_query($cnxn, $sql);
	
	if (mysqli_num_rows($result) != 1) //note that because card_id is unique(primary key) there is either 1 or zero cards.
	{
		$emptyCardError = true;
	}
	else
	{
		$row = mysqli_fetch_array($result);
		
		//assign each column's data to a variable.
		
		//the user that owns this card
		$cardUser = $row['user_id'];
		
		//word data
		$cardWord = $row['word'];
		$cardPartOfSpeech = $row['part_of_speech'];
		$cardWordInUse = $row['word_in_use'];
		$cardChapter = $row['chapter'];
		$cardPageNumber = $row['page_number'];
		$cardDefinition = $row['definition'];
		$cardExampleSentence = $row['example_sentence'];
		
		//grade, comment, and date submitted data
		$cardGrade = $row['grade'];
		$cardComment = $row['comment'];
		$cardDateSubmitted = $row['timestamp'];
		
		//if cardGrade is -1, then the card is ungraded.
		if ($cardGrade == -1)
		{
			$ungradedCard = true;
			//the slider in the form goes from 0 to 3, so ungraded cards will be shown as 0 instead of -1.
			$cardGrade = 0;
		}
	}
	
	//close connection
	mysqli_close($cnxn);
}
?>
<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>ESOL Card Website - Grade Card</title>

    <link crossorigin="anonymous" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" rel="stylesheet">

    <link href="style.css" rel="stylesheet">

    <!-- jQuery (necessary for Bootstraps JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- jQuery card flip -->
    <script src="https://cdn.rawgit.com/nnattawat/flip/v1.0.17/dist/jquery.flip.min.js"></script>

    <script crossorigin="anonymous" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- custom javascript -->
    <script src="main.js"></script>

    <link href="style.css" rel="stylesheet">

  </head>
	<body>

    <?php include 'header.html'; ?>

    <div class="container">
      <div class="row">
        <?php include 'side-menu.php'; ?>
				<div class="col-xs-12 col-sm-12 col-md-12">
          <div class="well">
            <?php
						//if a card was supposed to be updated, but failed, show an error (but the card info should still display)
						if (isset($failedToUpdate))
						{
							print '<h1 class="form_error">There was an error updating the card. Try again.</h1>';
						}
						//if there is no card id in the url (GET) then display an error. we should only see this
						//if the admin fiddles with the url instead of using the table to access cards.
						if ($emptyCardError)
						{
							print '<h1 class="form_error">There is no card with this ID.</h1>';
						}
						//otherwise, show card information.
						else
						{
							require 'grade-card-main.php';
						}
						?>
					</div>
        </div>
      </div>
    </div>
		
		<?php include 'footer.html'; ?>
	</body>
</html>