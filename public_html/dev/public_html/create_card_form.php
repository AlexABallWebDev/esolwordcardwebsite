<?php
//make sure user is logged in. redirect to login page otherwise.
require('check-id.php');

$submitted = false;
$updating = isset($_GET['card_id']) ? true : false;
//checking if the form was submitted
if (isset($_POST['submit']))
{
	$submitted = true;
	//checking if it was submitted
	//completely and correctly.
	if (//chapter validation
			!empty($_POST['chapter'])
			&& ($_POST['chapter'] != 0)
			&& is_numeric($_POST['chapter'])
			&& !($_POST['chapter'] > 12 || $_POST['chapter'] < 0)
			//word validation
			&& !empty($_POST['word'])
			//part of speech validation
			&& !((is_numeric($_POST['speech']) && $_POST['speech'] == 0))
			&& ($_POST['speech'] == 'Verb' || $_POST['speech'] == 'Noun' || $_POST['speech'] == 'Adjective')
			//word in use validation
			&& !empty($_POST['wordInUse'])
			//page number validation
			&& !empty($_POST['page'])
			&& is_numeric($_POST['page'])
			//definition validation
			&& !empty($_POST['definition'])
			//example sentence validation
			&& !empty($_POST['exampleSentence']))
	{
		//add card to the database
					
		//first create a connection to the database
		require('../secure-includes/db.php');
		//for now, card grade starts at -1 to mark that a card has not been graded yet.
		$grade = -1;
		require('../secure-includes/add-card-to-database.php');
		
		header('Location: http://anarchy.greenrivertech.net/student_review_cards.php');
	}
	else
	{
		$successful_submission = false;
	}
}

//check if cards is being updated
if ($updating)
{
	//print "<h1>Updaintg</h1>";
	//get database connection
	require('../secure-includes/db.php');
	
	//assign the card id to a variable
	$card_id = $_GET['card_id'];
	
	//setup the sql statement
	$sql = "SELECT * FROM cards WHERE card_id = $card_id";
	
	//do not show cards that have been set to not visible ("deleted" cards)
	$sql = $sql . " AND is_visible = TRUE";
	
	$result = mysqli_query($cnxn, $sql);
	
	if (mysqli_num_rows($result) != 1) //note that because card_id is unique(primary key) there is either 1 or zero cards.
	{
		print "Error fetching card!";
		die();
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
	
}else{
 //print "<h1>Not Updaintg</h1>";
}

//if the title has not been set, then 
if (!isset($title))
{
	$title = "ESOL Card Website - Create a Card";
}
?>
<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print $title; ?></title>

    <link crossorigin="anonymous" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" rel="stylesheet">

    <link href="style.css" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		
		<!-- jQuery card flip -->
		<script src="https://cdn.rawgit.com/nnattawat/flip/v1.0.17/dist/jquery.flip.min.js"></script>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

    <script crossorigin="anonymous" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    
    <!-- custom functionality -->
  <script src="main.js"></script>

    <link href="style.css" rel="stylesheet">

  </head>

  <body>

    <?php /*include 'header.html';*/ ?>

    <div class="container">
      <div class="row">
        <?php include 'side-menu.php';?>
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="well">
            <?php
						//display the form if no successful submission has been made to this page.
						require('create_card_main.php');
						?>
          </div>
        </div>
      </div>
    </div>

    <?php /*include 'footer-pushed.html';*/ ?>
    
  </body>
</html>