<?php
/**
 * 		Grupp 18 - 2012-12-10
 * 	Name:	Erik Larsson
 *	file: 	header.php
 *	Desc:	Template for website header
 */
?>

<?php print("<?xml version = '1.0' encoding = 'iso-8859-1'?>\n"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
	<head>
			<title>Bricksquad - F&ouml;r oss som gillar Lego mer &auml;n stegu!</title>
			<link rel="stylesheet" type="text/css" href="./css/style.css" />
			<script type="text/javascript" src="./js/script.js"></script>

			<?php
			//Change this to false to use School database
			$DEBUG = true;
			//Start connection to SQL-Servers
			require("./config/sqlconfig.php");
			?>
	</head>
<body>
	<?php
		require("./templates/menu.php");
	?>