<?
/**
 * 		Grupp 18 - 2012-12-06
 * 	Name:	Erik Larsson
 *	file: 	menu.php
 *	Desc:	Hold layout for menu
 */
?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="./js/menu.js"></script>

<div class="menu" id="menu" onmouseover="menuMouseEnter();" onmouseout="menuMouseExit();">
	<table border="0">
	<tr>
	<td class="menu"><img class='menu' src="./images/home.png" name="menuItem" onclick="location.href='index.php'"></td>
	</tr>
	<tr>
	<td class="menu"><img class='menu' src="./images/search.png" name="menuItem" onclick="location.href='search.php'"></td>
	</tr>
	<tr>
	<td class="menu"><img class='menu' src="./images/about.png" name="menuItem" onclick="location.href='about.php'"></td>
	</tr>
	<tr>
	<td class="menu"><img class='menu' src="./images/contact.png" name="menuItem" onclick="location.href='contact.php'"></td>
	</tr>
	</table>
</div>