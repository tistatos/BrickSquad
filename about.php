<?php
	/**
	 * 		Grupp 18 - 2012-12-10
	 * 	Name:	Daniel Rönnkvist
	 *	file: 	about.php
	 *	Desc:	about the website
	 */

	require("./templates/header.php");
?>

	<div class="title" id="title">
		<h1 class="titleHeader">ABOUT</h1>
		<h1 class="titleSub">Bricksquad</h1>
		<p class='tagline'>F&ouml;r oss som gillar Lego mer &auml;n stegu!</p>
	</div>

	<div class="head">
			<h2>Members</h2>
	</div>

	<div class="selected" id="selected">
		<div id="contactImg">
			<div class="contactMember">
				<img src="./images/daniel.jpg" alt="daniel"><br />
				Daniel R&ouml;nnkvist
			</div>
			<div class="contactMember">
				<img src="./images/erik.jpg" alt="erik"><br />
				Erik Larsson
			</div>
			<div class="contactMember">
				<img src="./images/pelle.jpg" alt="pelle"><br />
				Pelle Serander
			</div>
			<div class="contactMember">
				<img src="./images/totte.jpg" alt="totte"><br />
				Erik Olsson
			</div>
		</div>
		<div id="text">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</div>
		<div id="download">
			<br/>
			<a href="downloadlink">
			<img class="download" src="images/download.svg" alt=""><br/>
			Download our source code!
			</a>
		</div>
	</div>

<?php
	require("./templates/footer.php");
?>