<?php
	$word = $_POST['word'];
	$speech = $_POST['speech'];
	$chapter = $_POST['chapter'];
	$page = $_POST['page'];
	$es = str_replace($word, "<strong>$word</strong>", $_POST['exampleSentence']);
	$def = $_POST['definition'];
	$wiu = str_replace($word, "<strong>$word</strong>", $_POST['wordInUse']);
?>

<h1>Review Cards Page</h1>
	<div class="row">
		<div class="alert alert-success alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong>Tip:</strong> Click on a card to flip it!
		</div>
	</div>
<div class="row">
	<div class="col-sm-6 card-container">
		<div class="card card-block">
			<div class="front">
				<!-- <a href="sample_card_review.html"> -->
					<!-- <i class="expand-card glyphicon glyphicon-fullscreen pull-right"></i> -->
					<!-- <button type="button" class="btn btn-success pull-right">Grade <span class="badge">3</span></button> -->
					<!-- <button type="button" class="btn btn-default pull-right">Grade <span class="badge">pending</span></button> -->
					<p class="pull-right">Grade <span class="badge">pending</span></p>
				<!-- </a> -->
				<!-- <p class="card-text">Word: <?php print $word?></p> -->
				<h2 class="card-title"><?php print $word?></h2>
				<p class="card-text">Part of Speech: <?php  print $speech ?></p>
				<p class="card-text">Word in use: <?php print $wiu ?></p>
				<p class="card-text small-info pull-right">Chapter <?php print $chapter ?> - pg.<?php print $page ?></p>
				<!-- <a href="sample_card_review.html" class="btn btn-green">Show more</a> -->
			</div>
			<div class="back">
				<p class="card-text">Definition: <?php print $def ?></p>
				<p class="card-text">Example Sentence: <?php print $es ?></p>
			</div>
		</div>
	</div>
	<div class="col-sm-6 card-container">
		<div class="card card-block">
			<div class="front">
				<p class="pull-right">Grade <span class="badge badge-success">4 out of 4</span></p>
				<h2 class="card-title">Programmer</h2>
				<p class="card-text">Part of Speech: Noun</p>
				<p class="card-text">Word in use: The <strong>programmer</strong> created our school website.</p>
				<p class="card-text small-info pull-right">Chapter <?php print $chapter ?> - pg.<?php print $page ?></p>
			</div>
			<div class="back">
				<p class="card-text">Definition: a person who writes computer programs; a person who programs a device, especially a computer.</p>
				<p class="card-text">Example Sentence: <?php print $es ?></p>
			</div>
		</div>
	</div>
</div>