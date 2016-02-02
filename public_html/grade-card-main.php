<?php
//This file is for displaying the card information to the instructor and
//allowing the card to be graded and commented on.

//the header is the card name
print "<h1>$cardWord</h1>";

//Bold vocab word in example sentence and word in use sentence.
$cardWordInUse = str_ireplace($cardWord, "<u>" . $cardWord . "</u>", $cardWordInUse);
$cardExampleSentence = str_ireplace($cardWord, "<u>" . $cardWord . "</u>", $cardExampleSentence);
?>

<div class="row">
	<div class="col-sm-6 col-md-6 card-front">
		<!-- left side -->
		<h2 class="text-center">Front</h2>
		<div class="card-half">
			<p><strong>Word:</strong> <?php print $cardWord; ?></p>
			<p><strong>Part of Speech:</strong> <?php print $cardPartOfSpeech; ?></p>
			<p><strong>Word in Use:</strong> <?php print $cardWordInUse; ?></p>
			<p><strong>Chapter:</strong> <?php print $cardChapter; ?></p>
			<p><strong>Page Number:</strong> <?php print $cardPageNumber; ?></p>
		</div>
	</div>
	<div class="col-sm-6 col-md-6 card-back">
		<!-- right side -->
		<h2 class="text-center">Back</h2>
		<div class="card-half">
			<p><strong>Definition:</strong> <?php print $cardDefinition; ?></p>
			<p><strong>Example Sentence:</strong> <?php print $cardExampleSentence; ?></p>
		</div>
	</div>
</div>
<!-- Grade and Comments -->
<div class="row">
	<div class="col-sm-12 col-md-12">
		<hr>
		<form class="form-horizontal" method="post" action="<?php print $_SERVER["PHP_SELF"] . '?card_id=' . $card_id; ?>">
			<!-- Date Submitted -->
			<div class="form-group">
				<p class="col-sm-4 col-md-4 control-label"><strong>Date submitted:</strong></p>
				<div class="col-sm-6 col-md-6">
					<p id="dateSubmitted"><?php print $cardDateSubmitted; ?></p>
				</div>
			</div>
			
			<!-- Comment -->
			<div class="form-group">
				<label class="col-sm-4 col-md-4 control-label" for="newComment">Edit your comment for this card:
				<?php
				if (!empty($cardComment))
				{
					print '<br><br>To delete a comment, delete the text in the current comment, then click submit.';
				}
				?></label>
				<div class="col-sm-6 col-md-6">
					<textarea class="form-control" rows="3" id="newComment" name="newComment"><?php print $cardComment; ?></textarea>
				</div>
			</div>
			
			<!-- Grade -->
			<div class="form-group">
				<label class="col-sm-4 col-md-4 control-label" for="newGrade">Grade this card:</label>
				<div class="col-sm-6 col-md-6">
					<input type="range" class="form-control" min="0" max="3" step="1" value="<?php print $cardGrade; ?>"
								id="newGrade" name="newGrade">
					<div class="tick-mark-line">0</div>
					<div class="tick-mark-line">1</div>
					<div class="tick-mark-line">2</div>
					<div class="tick-mark-line" id="tick-three">3</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row row-centered">
					<div class="col-sm-12 col-md-12">
						<button class="btn btn-lg btn-main" type="submit" name="submit" value="submit">Submit</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- End Grade and Comments -->