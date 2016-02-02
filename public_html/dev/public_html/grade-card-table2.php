<?php
//make sure user is logged in. redirect to login page otherwise.
require('check-id.php');

//this is an admin page. make sure the user is an admin. if not, redirect to homepage.
if (!$isAdmin)
{
	header('location: index.php');
}
?>

<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>ESOL Card Website - Cards Overview</title>

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

    <?php /*include 'header.html'; */?>

    <div class="container">
      <div class="row">
        <?php include 'side-menu.php';?>
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="well">
            <h1>
              Student Cards Overview
            </h1>
            <table cellspacing="0" class="table table-striped table-bordered" id="datatable" width="100%">
              <thead>
                <tr>
                  <th>Student</th>
                  <th>Word</th>
                  <th>Chapter</th>
                  <th>Status</th>
                </tr>
              </thead>

              <tfoot>
                <tr>
                  <th>Student</th>
                  <th>Word</th>
                  <th>Chapter</th>
                  <th>Status</th>
                </tr>
              </tfoot>

              <tbody>
                <?php
                  //Write to the database
                  require "../secure-includes/db.php";
                  $sql = "SELECT card_id, first_name, last_name, word, chapter, grade, is_visible FROM cards, users WHERE cards.user_id = users.user_id";
                  if ($result = @mysqli_query($cnxn, $sql))
                  {
                    //while($row = mysqli_fetch_array($result)){
                    foreach($result as $row)
                    {

                      $card_id = $row['card_id'];
                      $first_name =  stripslashes($row['first_name']);
                      $last_name =  stripslashes($row['last_name']);
                      $word =  stripslashes($row['word']);
                      $chapter =  stripslashes($row['chapter']);
                      $grade =  stripslashes($row['grade']);
                      $is_visible = $row['is_visible'];


                      echo "<tr>";
                      echo "<td data-title='Student'>{$first_name} {$last_name}</td>";
                      echo "<td data-title='Word'>{$word}</td>";
                      echo "<td data-title='Chapter'>{$chapter}</td>";

                      if ($grade == -1)
                      {
                        echo "<td>
                          <p data-placement='top' data-toggle='tooltip' title='Grade'>Not Graded
                            <a class='btn btn-success btn-xs pull-right' href='grade-card.php?card_id=" . $card_id . "'>
                              <span class='glyphicon glyphicon-pencil'></span>
                            </a>
                          </p>
                        </td>";
                      }
                      else
                      {
                        echo "<td>
                          <p data-placement='top' data-toggle='tooltip' title='Edit'>Grade: {$grade}
                            <a class='btn btn-primary btn-xs pull-right' href='grade-card.php?card_id=" . $card_id . "'>
                              <span class='glyphicon glyphicon-wrench'></span>
                            </a>
                          </p>
                        </td>";
                      }

                      echo "</tr>";
                    }

                  }
                  else
                  {
                    echo "<p>Error: Failed to retrive data.</p>";
                  }

                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php /*include 'footer.html';*/ ?>
    <script>
      $(document).ready(function() {
        $('#datatable').dataTable();

        $('[data-toggle=tooltip]').tooltip();
      });
    </script>
  </body>
</html>
