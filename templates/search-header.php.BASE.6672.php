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
			<script type="text/javascript" src="./js/menu.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
			<script type="text/javascript" src="./js/menu.js"></script>
			<link rel="shortcut icon" href="./images/favicon.ico">

			<?php
			//Change this to false to use School database
			$DEBUG = false;

			//Start connection to SQL-Servers
			require("./config/sqlconfig.php");

			require("./includes/Fetch_image.php");
			if(sizeof($_GET) != 0)
			{
				$setnr = $_GET['setnr'];
				$setnr_specific = $_GET["setnr_specific"];
				$part_id = $_GET["part_id"];
				$set_name = $_GET["set_name"];
				$part_name = $_GET["part_name"];
				$category_name = $_GET["category_name"];
				$year = $_GET["year"];

			}

			//Includes function for handling SQL result layout
			require("./includes/sqlFunctions.php");
			?>
	</head>
<body>
	<?php
		require("./templates/menu.php");
	?>