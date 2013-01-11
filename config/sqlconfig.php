<?php
/**
 * 		Grupp 18 - 2012-11-27
 * 	Name:	Erik Larsson
 *	file: 	sqlconfig.php
 *	Desc:	open connection to our Database.
 *
 */

$server = "mysql.itn.liu.se";
$login = "lego";
$pass = "";

//connect to server and select lego database;
if(@mysql_connect($server, $login,$pass))
{
	//If we've made a connection
	mysql_select_db("lego");
}
else
{
	//Create a window showing that not having connection to sql would cause
	//website not working
	echo("<div class='errorWindow'>");
	echo("<h1 class='titleHeader'>Error!</h1>");
	echo("<p>There is no connection to the database! <br />");
	echo("This website won't function properly");
	echo("</p>");
	echo("</div>");
}