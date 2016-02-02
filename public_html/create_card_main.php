<h1>Create Cards Page</h1>
<!-- start of card form -->
<form class="form-horizontal" method="post" action="create_card_form.php">

	<div class="row">
		<div class="col-sm-6 col-md-6 card-front">
				
			<!-- left side -->
			<h2 class="text-center">Front</h2>
			<div class="card-half">
				
				<!-- Text input-->
				<!-- <div class="form-group">
					<label class="col-sm-4 col-md-4 control-label" for="name">Name</label>
					<div class="col-sm-6 col-md-6">
						<input class="form-control input-md" id="name" name="name" placeholder="ex: John Doe" required="" type="text"
								value="<?php /* if ($submitted && !empty($_POST['name']))
								{
									print($_POST['name']);
								}
								
								*/?>">
						<a data-placement="bottom" data-toggle="tooltip" href="#" title="Enter your name.">Help</a>
						<?php /*
							//if name is blank, show an error.
							if ($submitted && (empty($_POST['name'])))
							{
								print("<p class=\"form_error\">Enter your name.</p>");
							}
						*/?>
					</div>
				</div> -->

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
									if ($submitted && !empty($_POST['chapter']) && $ch == $_POST['chapter'])
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
							if ($submitted && empty($_POST['chapter']))
							{
								print("<p class=\"form_error\">Select a chapter.</p>");
							}
							//error for if the chapter is not numeric
							else if ($submitted && !is_numeric($_POST['chapter']))
							{
								print("<p class=\"form_error\">Invalid chapter.</p>");
							}
							//if the chapter was not selected at all
							else if ($submitted && $_POST['chapter'] == 0)
							{
								print("<p class=\"form_error\">Select a chapter.</p>");
							}
							//if the chapter is a number greater or less than expected
							else if ($submitted && ($_POST['chapter'] > 12 || $_POST['chapter'] < 0))
							{
								print("<p class=\"form_error\">Invalid chapter number.</p>");
							}
						?>
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-sm-4 col-md-4 control-label" for="word">Vocabulary Word</label>
					<div class="col-sm-6 col-md-6">
						<input class="form-control input-md" id="word" name="word" placeholder="ex: Catastrophy" required="" type="text"
								value="<?php if ($submitted && !empty($_POST['word']))
								{
									print($_POST['word']);
								}
							?>">
						<a data-placement="bottom" data-toggle="tooltip" href="#" title="Enter the word that this card will describe.">Help</a>
						<?php
							//if word is blank, show an error.
							if ($submitted && (empty($_POST['word'])))
							{
								print("<p class=\"form_error\">Enter a vocabulary word.</p>");
							}
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
								if ($_POST['speech'] == 'Verb')
								{
									print("selected=\"selected\"");
								}
							?>>Verb</option>
							<option value="Noun" <?php
								if ($_POST['speech'] == 'Noun')
								{
									print("selected=\"selected\"");
								}
							?>>Noun</option>
							<option value="Adjective" <?php
								if ($_POST['speech'] == 'Adjective')
								{
									print("selected=\"selected\"");
								}
							?>>Adjective</option>
						</select>
						<a data-placement="bottom" data-toggle="tooltip" href="#" title="Select the part of speech (noun, verb, or adjective) of this word.">Help</a>
						<?php
							//error for if the part of speech is empty or unselected
							if ($submitted && (empty($_POST['speech']) || (is_numeric($_POST['speech']) && $_POST['speech'] == 0)))
							{
								print("<p class=\"form_error\">Select a part of speech.</p>");
							}
							//if the chapter is a number greater or less than expected
							else if ($submitted && ($_POST['speech'] != 'Verb' && $_POST['speech'] != 'Noun' && $_POST['speech'] != 'Adjective'))
							{
								print("<p class=\"form_error\">Invalid part of speech.</p>");
							}
						?>
					</div>
				</div>

				<!-- Textarea -->
				<div class="form-group">
					<label class="col-sm-4 col-md-4 control-label" for="wordInUse">Word in use</label>
					<div class="col-sm-6 col-md-6">
						<textarea class="form-control" id="wordInUse" name="wordInUse" required=""><?php
								if ($submitted && !empty($_POST['wordInUse']))
								{
									print($_POST['wordInUse']);
								}
							?></textarea>
						<a data-placement="bottom" data-toggle="tooltip" href="#" title="Provide a sentence from the book using the vocabulary word!">Help</a>
						<?php
							//if wordInUse is blank, show an error.
							if ($submitted && (empty($_POST['wordInUse'])))
							{
								print("<p class=\"form_error\">Enter an example sentence from the book.</p>");
							}
						?>
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-sm-4 col-md-4 control-label" for="page">Page Number</label>
					<div class="col-sm-6 col-md-6">
						<input class="form-control input-md" id="page" name="page" placeholder="ex: 105" required="" type="number"
								value="<?php if ($submitted && !empty($_POST['page']) && is_numeric($_POST['page']))
									{
										print($_POST['page']);
									}
								?>">
						<a data-placement="bottom" data-toggle="tooltip" href="#" title="Enter the page number from your book where you first saw this word.">Help</a>
						<?php
							//if page number is blank, show an error.
							if ($submitted && (empty($_POST['page'])))
							{
								print("<p class=\"form_error\">Enter the page number for the example sentence.</p>");
							}
							//if page number is not numeric, show an error.
							else if ($submitted && (!is_numeric($_POST['page'])))
							{
								print("<p class=\"form_error\">Page number must be a number.</p>");
							}
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
								if ($submitted && !empty($_POST['definition']))
								{
									print($_POST['definition']);
								}
							?></textarea>
						<a data-placement="bottom" data-toggle="tooltip" href="#" title="Provide your own definition for the vocabulary word.">Help</a>
						<?php
							//if definition is blank, show an error.
							if ($submitted && (empty($_POST['definition'])))
							{
								print("<p class=\"form_error\">Enter your definition for this word.</p>");
							}
						?>
					</div>
				</div>
				<!-- Textarea -->
				<div class="form-group">
					<label class="col-sm-4 col-md-4 control-label" for="exampleSentence">Example Sentence</label>
					<div class="col-sm-6 col-md-6">
						<textarea class="form-control" id="exampleSentence" name="exampleSentence" required=""><?php
								if ($submitted && !empty($_POST['exampleSentence']))
								{
									print($_POST['exampleSentence']);
								}
							?></textarea>
						<a data-placement="bottom" data-toggle="tooltip" href="#" title="Provide your own sentence using the vocabulary word.">Help</a>
						<?php
							//if example sentence is blank, show an error.
							if ($submitted && (empty($_POST['exampleSentence'])))
							{
								print("<p class=\"form_error\">Enter your own example sentence for this word.</p>");
							}
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
		<div class="row row-centered">
			<div class="col-sm-12 col-md-12">
				<button class="btn btn-lg btn-main" type="submit" name="submit">Create Card</button>
			</div>
		</div>
	</div>
</form>
<!-- end of card form -->