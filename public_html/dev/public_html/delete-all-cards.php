<?php
	//make sure user is logged in. redirect to login page otherwise.
	require('check-id.php');
	
	//this is an admin page. make sure the user is an admin. if not, redirect to homepage.
	if (!$isAdmin)
	{
		header('location: index.php');
	}
	
	//connect to database.
	require('../secure-includes/db.php');
	
	//to "delete" cards, we just set them to not be visible.
	//no data is actually deleted, so the cards could potentially
	//be restored if needed.
	$sql = 'UPDATE cards
			SET is_visible = FALSE';
	
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