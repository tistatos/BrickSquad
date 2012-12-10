<?php
/**
 * 		Grupp 18 - 2012-12-06
 * 	Name:	Erik Larsson
 *	file: 	menu.php
 *	Desc:	Hold layout for menu
 */
?>

<div class="menu" id="menu" onmouseover="menuMouseEnter();" onmouseout="menuMouseExit();">
	<table border="0">
		<tr>
			<td class="menu" onclick="location.href='index.php'"><img class='menu' src="./images/home.png">Home</td>
		</tr>
		<tr>
			<td class="menu" onclick="location.href='search.php'"><img class='menu' src="./images/search.png">Search</td>
		</tr>
		<tr>
			<td class="menu" onclick="location.href='about.php'"><img class='menu' src="./images/about.png">About</td>
		</tr>
		<tr>
			<td class="menu" onclick="location.href='contact.php'" ><img class='menu' src="./images/contact.png">Contact</td>
		</tr>
	</table>
</div>