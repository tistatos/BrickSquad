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
	<div class="list" id="list">
<p>
		<table border=1>
<tr><th>SetID</th><th>CatID</th><th>Setname</th><th>Year</th></tr>
<tr onclick="location.href='./search.php?setnr=&setnr_specific=1712-1'"><td>1712-1</td><td>9</td><td>Crossbow Cart</td><td>1994</td></tr>
</table>
		</p>

	</div>

	<div class="selected" id="selected">
		<img class='select' src=http://www.bricklink.com/SL/1712-1.jpg><br /> <p>Satsnummer: 1712-1</p> 		<br />
		<table border="0">
			<tr>
				<td>Lite info</td>
				<td>lite mer info</td>
			</tr>
			<tr>
				<td>INFORMATION</td>
				<td>LEGO IS FUN</td>
			</tr>
		</table>
	</div>

	<div class="is" id="is">
<table border=1>
<tr><th>SetID</th><th>Qty</th><th>Color</th><th>Name</th><th>Image</th></tr>
<tr onclick="location.href='./search.php?setnr=&setnr_specific=1712-1'"><td>1712-1</td><td>1</td><td>Light Gray</td><td>Minifig, Shield Ovoid with Dragon Green and Red Pattern</td><td><img src='http://img.bricklink.com/P/9/2586p4b.gif' alt='gif-image' /></td><td>9</td></tr>
<tr onclick="location.href='./search.php?setnr=&setnr_specific=1712-1'"><td>1712-1</td><td>2</td><td>Dark Gray</td><td>Minifig, Weapon Crossbow</td><td><img src='http://www.bricklink.com/P/10/2570.jpg' alt='jpg-image' /></td><td>10</td></tr>
<tr onclick="location.href='./search.php?setnr=&setnr_specific=1712-1'"><td>1712-1</td><td>1</td><td>Black</td><td>Minifig, Weapon Pike / Spear</td><td><img src='http://www.bricklink.com/P/11/4497.jpg' alt='jpg-image' /></td><td>11</td></tr>
<tr onclick="location.href='./search.php?setnr=&setnr_specific=1712-1'"><td>1712-1</td><td>1</td><td>Dark Gray</td><td>Minifig, Weapon Sword, Shortsword</td><td><img src='http://img.bricklink.com/P/10/3847.gif' alt='gif-image' /></td><td>10</td></tr>
<tr onclick="location.href='./search.php?setnr=&setnr_specific=1712-1'"><td>1712-1</td><td>2</td><td>Black</td><td>Plate 2 x 6</td><td><img src='http://img.bricklink.com/P/11/3795.gif' alt='gif-image' /></td><td>11</td></tr>
<tr onclick="location.href='./search.php?setnr=&setnr_specific=1712-1'"><td>1712-1</td><td>2</td><td>Black</td><td>Plate, Modified 1 x 1 with Clip Vertical - Type 3 (thick U clip)</td><td><img src='http://img.bricklink.com/P/11/4085c.gif' alt='gif-image' /></td><td>11</td></tr>
<tr onclick="location.href='./search.php?setnr=&setnr_specific=1712-1'"><td>1712-1</td><td>1</td><td>Black</td><td>Plate, Modified 1 x 2 with 1 Stud (Jumper)</td><td><img src='http://img.bricklink.com/P/11/3794.gif' alt='gif-image' /></td><td>11</td></tr>
<tr onclick="location.href='./search.php?setnr=&setnr_specific=1712-1'"><td>1712-1</td><td>1</td><td>Black</td><td>Plate, Modified 1 x 2 with Handles - Flat Ends, Low Attachment</td><td><img src='http://img.bricklink.com/P/11/3839b.gif' alt='gif-image' /></td><td>11</td></tr>
<tr onclick="location.href='./search.php?setnr=&setnr_specific=1712-1'"><td>1712-1</td><td>1</td><td>Black</td><td>Plate, Modified 2 x 2 with Wheels Holder</td><td><img src='http://img.bricklink.com/P/11/4600.gif' alt='gif-image' /></td><td>11</td></tr>
<tr onclick="location.href='./search.php?setnr=&setnr_specific=1712-1'"><td>1712-1</td><td>1</td><td>Light Gray</td><td>Plate, Round 1 x 1 Straight Side</td><td><img src='http://img.bricklink.com/P/9/4073.gif' alt='gif-image' /></td><td>9</td></tr>
<tr onclick="location.href='./search.php?setnr=&setnr_specific=1712-1'"><td>1712-1</td><td>2</td><td>Light Gray</td><td>Plate, Round 1 x 1 Straight Side</td><td><img src='http://img.bricklink.com/P/9/4073.gif' alt='gif-image' /></td><td>9</td></tr>
<tr onclick="location.href='./search.php?setnr=&setnr_specific=1712-1'"><td>1712-1</td><td>3</td><td>Black</td><td>Tile, Modified 1 x 1 with Clip</td><td><img src='http://img.bricklink.com/P/11/2555.gif' alt='gif-image' /></td><td>11</td></tr>
<tr onclick="location.href='./search.php?setnr=&setnr_specific=1712-1'"><td>1712-1</td><td>2</td><td>Brown</td><td>Wheel Wagon Small (27mm D.)</td><td><img src='http://img.bricklink.com/P/8/2470.gif' alt='gif-image' /></td><td>8</td></tr>
</table>
	</div>
</body>
</html>