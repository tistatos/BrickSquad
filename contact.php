<?php
	/**
	 * 		Grupp 18 - 2012-12-10
	 * 	Name:	Daniel Rönnkvist
	 *	file: 	contact.php
	 *	Desc:	The contact page
	 */

	require("./templates/header.php");
?>

	<div class="title">
		<h1 class="titleHeader">CONTACT</h1>
		<h1 class="titleSub">Bricksquad</h1>
		<p class='tagline'>F&ouml;r oss som gillar Lego mer &auml;n stegu!</p>
	</div>

	<div class="head">
		<p>
			<h2>Members</h2>
		</p>
	</div>

	<div class="selected" id="selected">
		<?php require('templates/form.php') ?>
	</div>
<?php
require("./templates/footer.php");
?>