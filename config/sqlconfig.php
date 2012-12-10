<?php
/**
 * 		Grupp 18 - 2012-11-27
 * 	Name:	Erik Larsson
 *	file: 	sqlconfig.php
 *	Desc:	open connection to our Database.
 *
 */

$server = "";

if($DEBUG)
{
	$server = "tistatos.dyndns.org:2325";
}
else
{
	$server = "mysql.itn.liu.se";
}

//connect to server and select lego database;
mysql_connect($server, "lego","");
mysql_select_db("lego");