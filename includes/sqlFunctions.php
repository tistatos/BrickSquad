<?php
	/**
	 * 		Grupp 18 - 2012-12-10
	 * 	Name:	Erik Larsson
	 *	file: 	sqlFunctions.php
	 *	Desc:	functions for handling SQL replies
	 */

//Create a table of result for query
function CreateResultTable($queryResult, $typeOfSearch)
{
	if(mysql_num_rows($queryResult) == 0)
	{
		//Query is empty
		echo("No result!");
	}
	else
	{
		echo('<table class="info">');
		echo('<tr class="header">');
		for($i=0; $i<mysql_num_fields($queryResult); $i++)
		{
			$fieldname = mysql_field_name($queryResult, $i);
			echo("<th>$fieldname</th>");
		}
		echo "</tr>\n";

		while($row = mysql_fetch_row($queryResult))
		{
			if($typeOfSearch == "partID" || $typeOfSearch == "partName")
			{
				$searchType = "partID";
			}
			else
			{
				$searchType = "setID";
			}
			echo('<tr class="parts" onclick="location.href=\'./search.php?searchType='.$searchType.'&searchString='.$row[0].'&searchYear=\'">');
			for($i=0; $i<mysql_num_fields($queryResult); $i++)
			{
				echo("<td>$row[$i]</td>");
			}
			echo("</tr>\n");
		}
		echo("</table>\n");
	}
}

function createPartListTable($queryResult)
{
	echo("<table class='info'>");
	echo("<tr class='header'>");
	for($i = 0; $i < (mysql_num_fields($queryResult));$i++)
	{
		$fieldname = mysql_field_name($queryResult, $i);
		echo("<th>$fieldname</th>");
	}
	echo("<th>Image</th>");
	echo("</tr>");

	while($row = mysql_fetch_row($queryResult))
	{
		echo('<tr class="parts" onclick="location.href=\'./search.php?searchType=partID&searchString='.$row[0].'&searchYear=\'">');
		for($i = 0; $i < mysql_num_fields($queryResult); $i++)
		{
			echo("<td>$row[$i]</td>");
		}
		//get color of part
		$colorStringQuery = "SELECT ColorID from colors WHERE Colorname='$row[2]'";
		$colorQuery = mysql_query($colorStringQuery);
		$colorRow = mysql_fetch_row($colorQuery);
		$color = $colorRow[0];
		$piclink = getPictureLink($row[0], "P/$color");
		if($piclink != "")
		{
			echo("<td><img src='$piclink' alt='gif-image' /></td>");
		}
		else
		{
			echo("<td>no image</td>");
		}
		echo("</tr>");
	}
	echo("</table>\n");
}

function createMiniFigTable($queryResult)
{
	echo("<table class='info'>");
	echo("<tr class='header'>");
	for($i = 0; $i < (mysql_num_fields($queryResult));$i++)
	{
		$fieldname = mysql_field_name($queryResult, $i);
		echo("<th>$fieldname</th>");
	}
	echo("<th>Image</th>");
	echo("</tr>");

	while($row = mysql_fetch_row($queryResult))
	{
		echo('<tr class="parts">');
		for($i = 0; $i < mysql_num_fields($queryResult); $i++)
		{
			echo("<td>$row[$i]</td>");
		}
		$piclink = getPictureLink($row[0], "M");
		if($piclink != "")
		{
			echo("<td><img src='$piclink' alt='gif-image' /></td>");
		}
		else
		{
			echo("<td>no image</td>");
		}
		echo("</tr>");
	}
	echo("</table>");

}
//Return number of results in query
function numOfResults($queryResult)
{
	return mysql_num_rows($queryResult);
}

function getPictureLink($queryId, $prefix)
{
	//test for sql connection
	if(mysql_ping())
	{
		$filePathQuery = mysql_query(" SELECT filepath, isthere FROM `images` WHERE filepath LIKE '$prefix/$queryId%' ");
		$filePathQueryRow = mysql_fetch_row($filePathQuery);
		if($filePathQueryRow[1] == 1)
		{
			//'isthere' is one, i.e there is a picturelink
			return "http://img.bricklink.com/$filePathQueryRow[0]";
		}
		else
		{
			//get picture in slower way
			return "";
		}
	}
	else
	{
		//no connection to SQL-server
		return "";
	}

}

//Try to find image for $part and set
function validate_image($Part, $Color)
{
	$site = "http://img.bricklink.com/";
	$gif_url = $site . "P/" . $Color .  "/" . $Part . ".gif";
	$jpg_url = $site . "P/" . $Color .  "/" . $Part . ".jpg";

	if (@fclose(fopen($gif_url, "r")))
	{
		print("<td><img src='$gif_url' alt='gif-image' /></td>");
	}
	else if (@fclose(fopen($jpg_url, "r")))
	{
		print("<td><img src='$jpg_url' alt='jpg-image' /></td>");
	}
	else
	{
		print("<td> .PNG fil </td>");
	}
}