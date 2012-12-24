<?php
/**
 * 		Grupp 18 - 2012-12-10
 * 	Name:	Erik Larsson
 *	file: 	header.php
 *	Desc:	Template for website header
 */
?>

<?php print("<?xml version = '1.0' encoding = 'iso-8859-1'?>\n"); ?>
<!DOCTYPE html5>
<html>
	<head>
			<title>Bricksquad - F&ouml;r oss som gillar Lego mer &auml;n stegu!</title>
			<link rel="stylesheet" type="text/css" href="./css/standard.css" />
			<script type="text/javascript" src="./js/script.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
			<script type="text/javascript" src="./js/menu.js"></script>
			<link rel="shortcut icon" href="./images/favicon.ico">
	</head>
<body>
	<?php
		require("./templates/menu.php");
	?>