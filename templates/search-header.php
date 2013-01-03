<?php
/**
 * 		Grupp 18 - 2012-12-10
 * 	Name:	Erik Larsson
 *	file: 	header.php
 *	Desc:	Template for website header
 */
?>

<!DOCTYPE html>
<html>
	<head>
			<meta charset="UTF-8">
			<title>Bricksquad - F&ouml;r oss som gillar Lego mer &auml;n stegu!</title>
			<link rel="stylesheet" type="text/css" href="./css/standard.css" />
			<script type="text/javascript" src="./js/script.js"></script>
			<link rel="shortcut icon" href="./images/favicon.ico">

			<?php
			//Change this to false to use School database
			$DEBUG = false;

			//Start connection to SQL-Servers
			require("./config/sqlconfig.php");

			//Includes function for handling SQL result layout
			require("./includes/sqlFunctions.php");
			?>
	</head>
<body>
	<?php
		require("./templates/menu.php");
	?>