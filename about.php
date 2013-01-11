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
	<div class="aboutText">
		This webpage is the result of the examination project of the course TNMK30 on Link&ouml;pings Universitet, campus
		 Norrk&ouml;ping. The webpage was created by group 18 ("Bricksquad") during a 5 week long process. It was created with
		the help of the lego database from <a href="http://www.bricklink.com/">bricklink.com</a>. If you want to take
		a closer look at the source code we have provided a .zip wich contains all our source code. Included is our
		raport and timescheduele for the project. If you have questions about the webpage, project
		 or the course we would like to direct your attention towards the <a href="contact.php">contact</a> page.
	</div>
	<div id="download">
		<br/>
		<a href="./bricksquad.zip">
		<img class="download" src="images/download.svg" alt=""><br/>
		Download our source code!
		</a>
	</div>
	<br>
</div>

<?php
	require("./templates/footer.php");
?>