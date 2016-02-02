<?php
//make sure user is logged in. redirect to login page otherwise.
require('check-id.php');
?>

<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESOL Card Website - Student Card Table</title>

    <link crossorigin="anonymous" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->

    <script language="JavaScript" src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript"></script>

    <script crossorigin="anonymous" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


    <script language="JavaScript" src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script language="JavaScript" src="https://cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.js" type="text/javascript"></script>
    <!-- <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css"> -->

    <link href="http://cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" type="text/css">

    <link href="style.css" rel="stylesheet">

  </head>

  <body>

    <?php include 'header.html'; ?>

    <div class="container">
      <div class="row">
        <?php include 'side-menu.php';?>
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="well">
            <h1>
              Student Card Table
            </h1>
						<div class="alert alert-success alert-dismissible" role="alert">
							<button aria-label="Close" class="close" data-dismiss="alert" type="button">
								<span aria-hidden="true">&times;</span>
							</button>
							<strong>Tips:</strong>
							Click on a word to see the word's card!
						</div>
            <table cellspacing="0" class="table table-striped table-bordered" id="datatable" width="100%">
              <thead>
                <tr>
                  <th>Chapter</th>
                  <th>Word</th>
                  <th>Part of Speech</th>
									<th>Definition</th>
									<th>Example Sentence</th>
                  <th>Grade Status</th>
									<th>Instructor Comments</th>
                </tr>
              </thead>

              <tfoot>
                <tr>
                  <th>Chapter</th>
                  <th>Word</th>
                  <th>Part of Speech</th>
									<th>Definition</th>
									<th>Example Sentence</th>
                  <th>Grade Status</th>
									<th>Instructor Comments</th>
                </tr>
              </tfoot>

              <tbody>
                <?php
                  //Write to the database
                  require "../secure-includes/db.php";
									$user_id = $_SESSION['user_id'];
                  $sql = "SELECT * FROM cards WHERE user_id = $user_id";
									//only visible cards are shown
									$sql = $sql . " AND is_visible = 1";
                  if ($result = @mysqli_query($cnxn, $sql))
                  {
                    //while($row = mysqli_fetch_array($result)){
                    foreach($result as $row)
                    {

                      $card_id = $row['card_id'];
                      $definition =  stripslashes($row['definition']);
                      $part_of_speech =  stripslashes($row['part_of_speech']);
                      $word =  stripslashes($row['word']);
                      $chapter =  stripslashes($row['chapter']);
                      $grade =  stripslashes($row['grade']);
											$comment =  stripslashes($row['comment']);
											$example_sentence = stripslashes($row['example_sentence']);
                      $is_visible = $row['is_visible'];


                      echo "<tr>";
											echo "<td data-title='Chapter'>{$chapter}</td>";
											//word is clickable; sends user to review card page, to the card, and colors the card so that it is easier to notice.
                      echo "<td data-title='Word'><a href='student_review_cards.php?card_id=$card_id#selected-card'>{$word}</a></td>";
											echo "<td data-title='Part of Speech'>{$part_of_speech}</td>";
                      echo "<td data-title='Example Sentence'>{$example_sentence}</td>";
											echo "<td data-title='Definition'>{$definition}</td>";

                      if ($grade == -1)
                      {
                        echo "<td>
													Not Graded
                        </td>";
                      }
                      else
                      {
                        echo "<td>
													Grade: {$grade}
                        </td>";
                      }

											echo "<td data-title='Instructor Comments'>{$comment}</td>";
                      echo "</tr>";
                    }

                  }
                  else
                  {
                    echo "<tr><td>Error: Failed to retrive data.</td></tr>";
                  }

                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php include 'footer.html'; ?>
    <script>
    
      $(document).ready(function() {
        $('#datatable').dataTable( {
					
					<?php 
					//sets initial search
					if (isset($_GET['chapter']))
					{
						echo "'oSearch': {'sSearch': '" . $_GET['chapter'] . "'},";
					}
					?>
					
					//causes the table to remember how it was sorted when switching between pages
					stateSave: true
				});

        $('[data-toggle=tooltip]').tooltip();
      });
    </script>
  </body>
</html>