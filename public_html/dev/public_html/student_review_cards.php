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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESOL Card Website - Review Cards</title>

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
	       
	      if(isset($_POST['chapter']))
	      {
	       	$sql = "SELECT * FROM cards WHERE chapter = " . $_POST['chapter'];
		if ($_POST['chapter'] == '0')
		{
	       		$sql = "SELECT * FROM cards WHERE 1";
	       	}
	      }
	      else
	      {
	       	$sql = "SELECT * FROM cards WHERE 1";
	      }
	      
				//only show this user's cards
				$checkUser = $_SESSION['user_id'];
				$sql = $sql . " AND user_id = $checkUser";
				
				//do not show cards that have been set to not visible ("deleted" cards)
				$sql = $sql . " AND is_visible = TRUE";
				
				//show newest cards first (at the top of the list)
				$sql = $sql . " ORDER BY timestamp DESC";
	        ?>
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="well">
            <h1>Review Cards Page</h1>
            <div class="row">
              <div class="alert alert-success alert-dismissible" role="alert">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                  <span aria-hidden="true">&times;</span>
                </button>
                <strong>Tips:</strong>
                Click on a card to flip it! Hover your mouse over 'Grade' to display instructor comments!
              </div>
            </div>
						<div class="row">
							<div class="col-50 pull-left">
							<?php
							//only show delete all cards button if user is admin
							if ($isAdmin)
							{
								print '<button id="delete-all-cards" class="alert alert-danger">Delete all cards</button>';
							}
							?>
							</div>
							<div class="col-50 pull-right">
								<form class="form-group" role="form" method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
								  <label for="sel1">Filter By Chapter:</label>
								  <select class="form-control" id="sel1" name="chapter" onchange="this.form.submit()">
								    <option value="-1">Select Chapter</option>
								    <option value="0">All Chapters</option>
								    <option value="1">Chapter 1</option>
								    <option value="2">Chapter 2</option>
								    <option value="3">Chapter 3</option>
								    <option value="4">Chapter 4</option>
								    <option value="5">Chapter 5</option>
								    <option value="6">Chapter 6</option>
								    <option value="7">Chapter 7</option>
								    <option value="8">Chapter 8</option>
								    <option value="9">Chapter 9</option>
								    <option value="10">Chapter 10</option>
								    <option value="11">Chapter 11</option>
								    <option value="12">Chapter 12</option>
								  </select>
							  </form>
							</div>
						</div>
            <div class="row">
              <?php
                if ($result = @mysqli_query($cnxn, $sql))
								{
                  //while($row = mysqli_fetch_array($result)){
									
									//if the number of cards that will be shown is 3 or more,
									//then we need to use the pushed footer.
									if (mysqli_num_rows($result) >= 3)
									{
										$pushFooter = true;
									}
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
										
										echo "<div class='col-sm-6 card-container'>";
										echo "<div class='card card-block'>";
										echo "<div class='front'>";
										
										if($grade == -1)
										{
											echo "<div class='grade-info'>";
											echo "<a href='#' class='label label-pill label-default' data-toggle='popover'>Not Graded</a>";
											echo "</div>";
										}
										else
										{
											echo "<div class='grade-info'>";
											echo "<a href='#' class='label label-pill label-success' data-toggle='popover' data-trigger='hover' title='Comments' data-placement='bottom' data-content='" . $comment . "'>Grade: " . $grade  ."</a>";
											echo "</div>";
										}
										
										echo "<div class='grade-info'>";
											echo "<a href='update-card.php?card_id=$card_id' class='label label-pill label-primary' data-toggle='popover'>Edit</a>";
										echo "</div>";
										
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
                  }
                mysqli_close($cnxn);
                }
								else
								{
                  echo "<p>Error: Failed to retrive cards.</p>";
                  mysqli_close($cnxn);
                }
              ?>
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
		
		<script>
			$("#delete-all-cards").click(function() {
				if (confirm('Are you sure you want to delete all cards?'))
				{
					window.location = "delete-all-cards.php";
				}
			});
		</script>
  </body>
</html>