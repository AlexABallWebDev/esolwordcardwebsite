<div id="wrapper">
  <div id="info">
		<input type="checkbox" id="menu" name="menu" class="menu-checkbox">
		<div class="menu">
			<label class="menu-toggle" for="menu"><span>Toggle</span></label>
			<ul>
				<!-- <img alt="GRC" class="grc-logo img-responsive" src="img/grc.jpg" style="height: 50px"/> -->
				<li class="navbarremove">
					<a href="index.php">Home</a>
				</li>
				<?php
				//if admin is logged in, show grade cards link
				if ($isAdmin)
				{
					print '<li class="navbarremove">';
					print '<a href="grade-card-table.php">Grade Cards</a>';
					print '</li>';
				}
				?>
				<li class="navbarremove">
					<a href="create_card_form.php">Create Card</a>
				</li>
				<li class="navbarremove">
					<a href="student_review_cards.php">Review Cards</a>
				</li>
				<?php
				//if student is logged in, show cards table and test yourself
				if (!$isAdmin)
				{
					print '<li class="navbarremove">';
					print '<a href="student-card-table.php">Student Card Table</a>';
					print '</li>';
					print '<li class="navbarremove">';
					print '<a href="test-yourself.php">Test Yourself</a>';
					print '</li>';
				}
				?>
				<li class="navbarremove">
					<a href="resource.php">Resources</a>
				</li>
				<li class="navbarremove">
					<a href="change-password-form.php">Change Password</a>
				</li>
				<li class="navbarremove">
					<a href="logout.php">Log out</a>
				</li>
				
				<!--
				<li class="sidebar-image navbarremove">
					<img alt="GRC" class="sidebar-image grc-logo img-responsive" src="img/grc.jpg" />
				</li>
				
				<li class="sidebar-space-20 navbarremove">
					<a href="mailto:javery@greenriver.edu" class="instructor-info">
								Instructor Information: javery@greenriver.edu</a>
				</li>
				-->
			</ul>
			
			<!--
			<div id="google_translate_element" class="sidebar-space-20"></div>
			<script type="text/javascript">
				function googleTranslateElementInit() {
					new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
				}
			</script>
			-->
			<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
		</div>
	</div>
</div>