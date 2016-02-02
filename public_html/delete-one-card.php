<?php
	//make sure user is logged in. redirect to login page otherwise.
	require('check-id.php');


	//connect to database.
	require('../secure-includes/db.php');
	//to "delete" cards, we just set them to not be visible.
	//no data is actually deleted, so the cards could potentially
	//be restored if needed.

  $card_id = $_GET['card_id'];
	$user_id = $_SESSION['user_id'];
	$sql = "UPDATE cards
			SET is_visible = FALSE WHERE card_id = $card_id AND user_id = $user_id";
	$results = @mysqli_query($cnxn, $sql);
	if ($results)
	{
		header('Location: http://anarchy.greenrivertech.net/student_review_cards.php');
	}
	else
	{
		print('<p>Error: Failed to delete cards.</p>');
	}
?>
