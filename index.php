<?php
	/**
	 * 		Grupp 18 - 2012-12-10
	 * 	Name:	Daniel Rönnkvist
	 *	file: 	Index.php
	 *	Desc:	home/index of website
	 */

	require("./templates/header.php");
?>
<div class="title" id="title">
		<h1 class="titleHeader">BRICKSQUAD</h1>
		<p class='tagline'>F&ouml;r oss som gillar Lego mer &auml;n stegu!</p>
</div>

<div class="head">
	<h1>Home</h1>
</div>
<div class="selected" id="selected">
	<h1 class="titleHeader">Set of the Day!</h1>
	<!-- TEST CODE REMOVE WHEN WE GO LIVE! -->
	(picture and table links to a searchquery for this specific set?)<br />
	<img class='select' src=http://www.bricklink.com/SL/1712-1.jpg alt=""><br /><br />
	<table class="info">
		<tr class="header">
			<th>Set Id</th>
			<th>Category</th>
			<th>Set Name</th>
			<th>Year of release</th>
		</tr>
		<tr class="parts">
			<td>1712-1</td>
			<td>Castle</td>
			<td>Crossbow cart</td>
			<td>1994</td>
		</tr>
	</table>
	<!-- TEST CODE REMOVE WHEN WE GO LIVE! -->
</div>
<?php
require("./templates/footer.php");
?>