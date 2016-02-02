<?php
//make sure user is logged in. redirect to login page otherwise.
require('check-id.php');

//the footer needs to be fixed unless there are enough
//cards on the screen to make it look normal otherwise.
//this variable decides which footer is used.
$pushFooter = false;
?>
<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>ESOL Card Website - Test Yourself</title>

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
    <?php
      	include 'side-menu.php';
        
        //create a connection to the database
	    require('../secure-includes/db.php');
        
        //Get the SID from the URL, if there is one
        $card_id = $_GET['card_id'];
        $user_id = $_SESSION['user_id'];
        
        $id_present = !empty($card_id);
        
        //if no id was specifed, reset the session card array.
        if(!$id_present){
          unset($_SESSION['card_array']);
        }
        
        //Get all the SIDs from the database
        $query = "SELECT card_id FROM cards WHERE user_id = '$user_id'";
        $result = mysqli_query($cnxn, $query);
        
        //check is card array has been set
        if(!isset($_SESSION['card_array'])){
          //Copy the SIDs into an array
          foreach ($result as $row) {
            $cards[] = $row['card_id'];
          }
          shuffle($cards);
          $_SESSION['card_array'] = $cards;
          //print_r($cards);
        } else {
          $cards = $_SESSION['card_array'];
          //print_r($cards);
        }
        
        //Define query to retrieve a student from the database
        $query = "SELECT * FROM cards WHERE user_id = '$user_id'";
        
        //If there's a SID, append it to the query
        if ($id_present) {
          $query .= " AND card_id = '$card_id'";
        }else if (isset($cards)){
          $query .= " AND card_id = " . $cards[0];
        }
        
        //Execute the query
        $result = mysqli_query($cnxn, $query);
        $row = mysqli_fetch_array($result);
        
        
         
        $card_id = $row['card_id'];
		$word = $row['word'];
        $word_in_use = str_ireplace($word, "<a href='http://dictionary.reference.com/browse/$word?s=t' target='_blank'><u>" . $word . "</u></a>", $row['word_in_use']);
		$example_sentence = str_ireplace($word, "<a href='http://dictionary.reference.com/browse/$word?s=t' target='_blank'><u>" . $word . "</u></a>", $row['example_sentence']);
        $part_of_speech = $row['part_of_speech'];
        $chapter = $row['chapter'];
        $pg = $row['page_number'];
        $definition = $row['definition'];
        $grade = $row['grade'];
        $comment = $row['comment'];

        //Get index of current student
        $currentIdx = empty($card_id) ? 0 : array_search($card_id, $cards);
        
        //Determine next student
        $nextIdx = $currentIdx < sizeof($cards) ? $currentIdx + 1 : null;
        $next =  $nextIdx == null ? null : $cards[$nextIdx];
      
        
        //Determine previous student
        $prevIdx = $currentIdx > 0 ? $currentIdx - 1 : $currentIdx;
        $prev = $cards[$prevIdx];
        if($currentIdx == 0){
           $prev = null;
        }
        
	?>
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="well">
            <h1>Test Yourself Page</h1>
            <div class="row row-centered">
              <?php

				//if the number of cards that will be shown is 3 or more,
				//then we need to use the pushed footer.
				if (mysqli_num_rows($result) >= 3)
				{
					$pushFooter = true;
				}


					echo "<div class='col-xs-12 col-sm-6 card-container col-centered'>";
					echo "<div class='card card-block'>";
					echo "<div class='front'>";

					echo "<p class='card-text'><strong>Word</strong>: " . $word . "</p></a>";


					echo "<p class='card-text'><strong>Part of Speech</strong>: " . $part_of_speech . "</p>";
					echo "<p class='card-text'><strong>Word in use</strong>: " . $word_in_use . "</p>";
					echo "<p class='card-text small-info pull-right'>Chapter " . $chapter . " - pg." . $pg . "</p>";

					echo "</div>";
					echo "<div class='back'>";
					echo "<p class='card-text'><strong>Definition</strong>: " . $definition . "</p>";
					echo "<p class='card-text'><strong>Example Sentence</strong>: " . $example_sentence . "</p>";

					echo "</div>";
					echo "</div>";
					echo "</div>";

                mysqli_close($cnxn);
              ?>
            </div>
            <div class="row row-centered">
              <div class="col-xs-6 col-centered">
                <form class="form-horizontal" method="get">
                  <fieldset>
                  <!-- Buttons -->
                  <div class="form-group">
                    <div class="col-xs-12">
                      <?php
                     	//echo "<h1>" . $previous . "</h1>";
                        if($prev != null)
                        {
                          echo "<button name='card_id' value='$prev' class='btn btn-primary pull-left'>Previous Card</button>";
                        }
                        if($next != null)
                        {
                          echo "<button name='card_id'  value='$next' class='btn btn-primary pull-right'>Next Card</button>";
                        }
                      ?>
                    </div>
                  </div>
                  </fieldset>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php /*
		//if the footer needs to be pushed (3 or more cards shown) then load the pushed footer.
		if($pushFooter)
		{
			include 'footer-pushed.html';
		}
		else
		{
			include 'footer.html';
		}
		*/ 
		include 'footer.html';
		?>
  </body>
</html>