<?php
	//make sure the data is escaped.
	$chapter = mysqli_real_escape_string($cnxn, $_POST['chapter']);
	$word = mysqli_real_escape_string($cnxn, $_POST['word']);
	$speech = mysqli_real_escape_string($cnxn, $_POST['speech']);
	$wordInUse = mysqli_real_escape_string($cnxn, $_POST['wordInUse']);
	$page = mysqli_real_escape_string($cnxn, $_POST['page']);
	$definition = mysqli_real_escape_string($cnxn, $_POST['definition']);
	$exampleSentence = mysqli_real_escape_string($cnxn, $_POST['exampleSentence']);
	
	//user id is pulled from the session
	$user_id = $_SESSION['user_id'];
	
	//add card to the database. This user's id is added to the card,
	//so that cards can be linked to the users table (each user has some number of cards).
	$sql = "INSERT INTO cards (user_id, chapter, word, part_of_speech, word_in_use, page_number,
			definition, example_sentence, grade, timestamp)
			VALUES ($user_id, $chapter, '$word', '$speech', '$wordInUse', $page, '$definition',
			'$exampleSentence', $grade, NOW())";
	//echo $sql;
	$result = @mysqli_query($cnxn, $sql);
	if (!$result) {
			print"<p>Error adding card to database: " . mysqli_error($cnxn) . "</p>";
			die;
	}
	