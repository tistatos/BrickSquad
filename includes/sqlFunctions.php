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

		echo("<th>Images</th>");

		echo "</tr>\n";
		echo("</table>");
		echo("<div class='outerSearchResult'>");
		echo("<div id='searchResult' class='innerSearchResult'>");
		echo('<table class="info">');
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
			echo('<tr class="parts" onclick="location.href=\'./search.php?searchType='.$searchType.'&amp;searchString='.$row[0].'&amp;searchYear=\'">');
			if(strlen ($row[2]) > 40)
			{
				//shorten name
				$row[2] = substr($row[2], 0, 40) . "...";
			}
			for($i=0; $i<mysql_num_fields($queryResult); $i++)
			{
				echo("<td>$row[$i]</td>");
			}

			if($searchType == "setID")
			{
				$imgLink = getPictureLink($row[0], "S");
			}
			if($searchType =="partID")
			{
				$colors = GetPartColors($row[0]);
        		$color = 0;
        		if($colors != "")
        		{
          			$color = $colors[0];
          			$imgLink = getPictureLink($row[0], "P/$color");
        		}
			}
			if($imgLink != "")
			{
				echo("<td><img height='80' src='". $imgLink . "' alt=$row[0] /></td>");
			}
			else
			{
				echo("<td><img height='80' src='./images/noimg.png' alt='' /></td>");
			}

			echo("</tr>\n");
		}
		echo("</table>\n");
		echo("</div>");
		echo("</div>");
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
		echo('<tr class="parts" onclick="location.href=\'./search.php?searchType=partID&amp;searchString='.$row[0].'&amp;searchYear=\'">');
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

function CreatePaging($numberofResults)
{
	echo("<p>");
	echo("Pages: ");
	$NumberOfPages = ceil($numberofResults/11);
	for($i =0; $i < $NumberOfPages; $i++)
	{
		echo("<a onclick='javascript:scrollResult($i);' href='#result'>".($i+1)." &nbsp;</a>");
	}
	echo("</p>");
}

function GetPartColors($partID)
{
	$queryString = 	"SELECT DISTINCT colors.ColorID, colors.Colorname FROM inventory
							JOIN colors ON inventory.ColorID = colors.ColorID
							WHERE inventory.ItemID = '$partID'";
	if(mysql_ping())
	{
		$colorContents = mysql_query($queryString);
		if(numOfResults($colorContents) != 0)
		{
			$colorArray = array();
			while($row = mysql_fetch_row($colorContents))
			{
					$colorArray[] = $row[0];
			}
			return $colorArray;
		}
		else
		{
			return "";
		}
	}
}