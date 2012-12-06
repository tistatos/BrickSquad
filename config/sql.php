<?php

/* 		Grupp 18 - 2012-11-27
	Name:	Erik Larsson
	file: 	sql.php
	Desc:	Multipurpose file for sql queries and sql connection
			Only holds one connection for now
*/
	//holds our connection
	$connection;
	$connectionServer;


//test if we have a connection to a server, if not, connect to that server
//Returns true if we ar connected or connection was successfully established
function CheckDBConnection($server,$user,$pass)
{
	global $connection;
	global $connectionServer;
	//test if we have connection to database
	if($connection && $server == $connectionServer)
	{
		return true;
	}
	else
	{
		//if not, connect
		$connection = mysql_connect($server, $user, $pass);
		if($connection)
		{
			//OK! save server adress aswell
			$connectionServer = $server;
			return true;
		}
		else
		{
			//error connecting to server
			return false;

		}
	}
}

//handles querys to sql DB
//To be implmented
function DBQuery($queryString)
{
	return "";
}

//close connection to our server
function CloseDBConnection()
{
	global $connection;
	mysql_close($connection);
}