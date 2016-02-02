<h1>Update Card Page</h1>
<!-- start of card form -->
<form class="form-horizontal" method="post" action="<?php print $_SERVER["PHP_SELF"] . '?card_id=' . $card_id; ?>">

	<div class="row">
		<div class="col-sm-6 col-md-6 card-front">

			<!-- left side -->
			<h2 class="text-center">Front</h2>
			<div class="card-half">


				<!-- Select Basic -->
				<div class="form-group">
					<label class="col-sm-4 col-md-4 control-label" for="chapter">Chapter</label>
					<div class="col-sm-6 col-md-6">
						<select class="form-control" id="chapter" name="chapter">
							<option value="0">Select Chapter</option>
							<?php
								for ($ch = 1; $ch <= 12; $ch++)
								{
									print("<option value=\"$ch\"");
									if ($ch == $chapter)
									{
										print(" selected=\"selected\"");
									}
									print(">Chapter $ch</option>\n");
								}
							?>
						</select>
						<a data-placement="bottom" data-toggle="tooltip" href="#" title="Select the chapter of your book where you first saw this word.">Help</a>
						<?php
							//error for if chapter was somehow empty
						?>
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-sm-4 col-md-4 control-label" for="word">Vocabulary Word</label>
					<div class="col-sm-6 col-md-6">
						<input class="form-control input-md" id="word" name="word" placeholder="ex: Catastrophy" required="" type="text"
								value="<?php if ($word)
								{
									print($word);
								}
							?>">
						<a data-placement="bottom" data-toggle="tooltip" href="#" title="Enter the word that this card will describe.">Help</a>
						<?php
							//if word is blank, show an error.
						?>
					</div>
				</div>

				<!-- Select Basic -->
				<div class="form-group">
					<label class="col-sm-4 col-md-4 control-label" for="speech">Part of Speech</label>
					<div class="col-sm-6 col-md-6">
						<select class="form-control" id="speech" name="speech">
							<option value="0">Select part of speech</option>
							<option value="Verb" <?php
								if ($part_of_speech == 'Verb')
								{
									print("selected=\"selected\"");
								}
							?>>Verb</option>
							<option value="Noun" <?php
								if ($part_of_speech == 'Noun')
								{
									print("selected=\"selected\"");
								}
							?>>Noun</option>
							<option value="Adjective" <?php
								if ($part_of_speech == 'Adjective')
								{
									print("selected=\"selected\"");
								}
							?>>Adjective</option>
						</select>
						<a data-placement="bottom" data-toggle="tooltip" href="#" title="Select the part of speech (noun, verb, or adjective) of this word.">Help</a>
						<?php
							//error for if the part of speech is empty or unselected
						?>
					</div>
				</div>

				<!-- Textarea -->
				<div class="form-group">
					<label class="col-sm-4 col-md-4 control-label" for="wordInUse">Word in use</label>
					<div class="col-sm-6 col-md-6">
						<textarea class="form-control" id="word_in_use" name="word_in_use" required=""><?php
								if ($word_in_use)
								{
									print($word_in_use);
								}
							?></textarea>
						<a data-placement="bottom" data-toggle="tooltip" href="#" title="Provide a sentence from the book using the vocabulary word!">Help</a>
						<?php
							//if wordInUse is blank, show an error.
						?>
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-sm-4 col-md-4 control-label" for="page">Page Number</label>
					<div class="col-sm-6 col-md-6">
						<input class="form-control input-md" id="page" name="page" placeholder="ex: 105" required="" type="number"
								value="<?php if ($page_number)
									{
										print($page_number);
									}
								?>">
						<a data-placement="bottom" data-toggle="tooltip" href="#" title="Enter the page number from your book where you first saw this word.">Help</a>
						<?php
							//if page number is blank, show an error.
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6 card-back">
			<!-- right side -->
			<h2 class="text-center">Back</h2>
			<div class="card-half">
				<!-- Textarea -->
				<div class="form-group">
					<label class="col-sm-4 col-md-4 control-label" for="definition">Definition</label>
					<div class="col-sm-6 col-md-6">
						<textarea class="form-control" id="definition" name="definition" required=""><?php
								if ($definition)
								{
									print($definition);
								}
							?></textarea>
						<a data-placement="bottom" data-toggle="tooltip" href="#" title="Provide your own definition for the vocabulary word.">Help</a>
						<?php
							//if definition is blank, show an error.
						?>
					</div>
				</div>
				<!-- Textarea -->
				<div class="form-group">
					<label class="col-sm-4 col-md-4 control-label" for="example_sentence">Example Sentence</label>
					<div class="col-sm-6 col-md-6">
						<textarea class="form-control" id="example_sentence" name="example_sentence" required=""><?php
								if ($example_sentence)
								{
									print($example_sentence);
								}
							?></textarea>
						<a data-placement="bottom" data-toggle="tooltip" href="#" title="Provide your own sentence using the vocabulary word.">Help</a>
						<?php
							//if example sentence is blank, show an error.
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- line divider -->
	<hr>

	<!-- Button -->
	<div class="form-group">
		<div class="col-sm-12 col-md-12">
			<button class="btn btn-lg btn-block btn-green" type="submit" name="submit">update</button>
		</div>
	</div>
</form>
<!-- end of card form -->