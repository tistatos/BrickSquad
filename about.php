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
		<p>
			<h2>Members</h2>
		</p>
	</div>

	<div class="selected" id="selected">
		<div class="contactMember">
			<img src="./images/daniel.jpg" alt="daniel"><br />
			Daniel R&ouml;nnkvist <br/>
			<a href="mailto:danro716@student.liu.se"> danro716@student.liu.se </a>
		</div>
		<div class="contactMember">
			<img src="./images/Erik.jpg" alt="erik"><br />
			Erik Larsson<br/>
			<a href="mailto:erila135@student.liu.se">erila135@student.liu.se </a>
		</div>
		<div class="contactMember">
			<img src="./images/pelle.jpg" alt="pelle"><br />
			Pelle Serander<br/>
			<a href="mailto:pelse862@student.liu.se">pelse862@student.liu.se </a>
		</div>
		<div class="contactMember">
			<img src="./images/totte.jpg" alt="totte"><br />
			Erik Olsson<br/>
			<a href="mailto:eriol726@student.liu.se">eriol726@student.liu.se </a>
		</div>
	</div>

<?php
	require("./templates/footer.php");
?>