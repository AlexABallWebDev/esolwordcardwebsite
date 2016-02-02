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

    <?php /*include 'header.html'; */?>

    <div class="container">
      <div class="row">
        <?php
      	include 'side-menu.php';
        //first create a connection to the database
	       require('../secure-includes/db.php');

         //only show this user's cards
 				$checkUser = $_SESSION['user_id'];

        //previous and next cards
        $previous = null;
        $next = null;

         //Check if card_id is specified
         if(isset($_GET['card_id']))
         {
           $card_id = $_GET['card_id'];
           //get card and display it
           $sql = "SELECT * FROM cards WHERE user_id = $checkUser AND card_id = $card_id AND is_visible = TRUE ORDER BY timestamp ASC LIMIT 1";

         }
         else
         {
           //$sql = "SELECT * FROM cards WHERE user_id = $checkUser AND is_visible = TRUE ORDER BY timestamp ASC LIMIT 1";

           //Start with a random card
           $sql = "SELECT * FROM cards WHERE user_id = $checkUser AND is_visible = TRUE AND card_id >= (SELECT FLOOR( MAX(card_id) * RAND()) FROM cards ) ORDER BY card_id LIMIT 1";
         }

         if ($result = @mysqli_query($cnxn, $sql))
         {
           foreach($result as $row)
           {
             //Bold vocab word in example sentence and word in use sentence.
          		$card_id = $row['card_id'];
          		$word_in_use = str_ireplace($row['word'], "<u>" . $row['word'] . "</u>", $row['word_in_use']);
          		$example_sentence = str_ireplace($row['word'], "<u>" . $row['word'] . "</u>", $row['example_sentence']);
          		$word = $row['word'];
          		$part_of_speech = $row['part_of_speech'];
          		$chapter = $row['chapter'];
          		$pg = $row['page_number'];
          		$definition = $row['definition'];
          		$grade = $row['grade'];
          		$comment = $row['comment'];
             $previous = checkPrevious($card_id, $cnxn, $checkUser);
             $next = checkNext($card_id, $cnxn, $checkUser);
          }

        }
        else
        {
          echo"<h1>No cards found!</h1>";
          die();
        }

        function checkPrevious($id, $cnxn, $user)
        {
           //echo "<h1>Getting previous</h1>";
           //get the card_id of the previous card
           $p_sql = "SELECT card_id FROM cards WHERE user_id = $user AND is_visible = TRUE AND card_id < $id ORDER BY card_id DESC LIMIT 1";

           if($p_result = mysqli_query($cnxn, $p_sql))
           {
             foreach($p_result as $p_row)
             {

               $previous = $p_row['card_id'];
               //echo "<h1>Previous: " . $previous . "</h1>";
             }
             return $previous;
           }
           else
           {
             echo "<h1>Failed Getting previous</h1>";
             return null;
           }
        }

         function checkNext($id, $cnxn, $user)
         {
           //get the card_id of the next card
           $n_sql = "SELECT card_id FROM cards WHERE user_id = $user AND is_visible = TRUE AND card_id > $id ORDER BY card_id ASC LIMIT 1";

           if($n_result = mysqli_query($cnxn, $n_sql)){
             foreach($n_result as $n_row){
               $next = $n_row['card_id'];
               //echo "<h1>Next: " . $next . "</h1>";
             }
             return $next;
           }
           else
           {
             echo "<h1>Failed Getting Next</h1>";
             return null;
           }
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


										echo "<div class='col-xs-6 card-container col-centered'>";
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
                        if($previous != null)
                        {
                          echo "<button name='card_id' value='$previous' class='btn btn-primary pull-left'>Previous Card</button>";
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
		*/ ?>
  </body>
</html>
