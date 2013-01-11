<?php
	/**
	 * 		Grupp 18 - 2012-12-10
	 * 	Name:	Erik Larsson
	 *	file: 	sqlFunctions.php
	 *	Desc:	Functions for handling SQL replies
	 *			and other parts of website related to SQL
	 */

/**
 * Create a table of result for query
 * @param $queryResult - Data from SQL-query
 * @param $typeOfSearch - what type of search has been done
 */
function CreateResultTable($queryResult, $typeOfSearch)
{
	if(!@mysql_ping())
	{
		echo("ERROR!");
		return;
	}
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
			//Print column heading
			$fieldname = mysql_field_name($queryResult, $i);
			echo("<th>$fieldname</th>");
		}

		echo("<th>Images</th>");

		echo "</tr>\n";
		echo("</table>");

		//outer frame and inner frame used in paging system
		echo("<div class='outerSearchResult'>");
		echo("<div id='searchResult' class='innerSearchResult'>");
		//Table with result
		echo('<table class="info">');
		while($row = mysql_fetch_row($queryResult))
		{
			//Depending on what type of search, the rows should link to certain pages
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
				//shorten name if its to long  to not destroy paging
				$row[2] = substr($row[2], 0, 40) . "...";
			}

			for($i=0; $i<mysql_num_fields($queryResult); $i++)
			{
				//priting all data in to the table
				echo("<td>$row[$i]</td>");
			}

			if($searchType == "setID")
			{
				//Get a small preview picture
				$imgLink = getPictureLink($row[0], "S");
			}
			if($searchType =="partID")
			{
				//Get a small picture of one of the parts
				$colors = GetPartColors($row[0]);
        		$color = 0;
        		//TODO: use value and keys instead to have names of colors aswell
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

/**
 * Create List of all parts in a set
 * @param $queryResult - Data from SQL-query
 */
function createPartListTable($queryResult)
{
	if(!@mysql_ping())
	{
		echo("ERROR!");
		return;
	}
	echo("<table class='info'>");
	echo("<tr class='header'>");
	for($i = 0; $i < (mysql_num_fields($queryResult));$i++)
	{
		//Print column  heading
		$fieldname = mysql_field_name($queryResult, $i);
		echo("<th>$fieldname</th>");
	}
	echo("<th>Image</th>");
	echo("</tr>");

	while($row = mysql_fetch_row($queryResult))
	{
		//Print each row
		echo('<tr class="parts" onclick="location.href=\'./search.php?searchType=partID&amp;searchString='.$row[0].'&amp;searchYear=\'">');
		for($i = 0; $i < mysql_num_fields($queryResult); $i++)
		{
			echo("<td>$row[$i]</td>");
		}
		//Get color of part
		$colorStringQuery = "SELECT ColorID from colors WHERE Colorname='$row[2]'";
		$colorQuery = mysql_query($colorStringQuery);
		$colorRow = mysql_fetch_row($colorQuery);
		$color = $colorRow[0];
		$piclink = getPictureLink($row[0], "P/$color");

		//print picture of part
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
/**
 * Create a table with minifigures
 * @param $queryResult - Data from SQL-query
 */
function createMiniFigTable($queryResult)
{
	if(!@mysql_ping())
	{
		echo("ERROR!");
		return;
	}
	echo("<table class='info'>");
	echo("<tr class='header'>");
	for($i = 0; $i < (mysql_num_fields($queryResult));$i++)
	{
	//Print column heading

		$fieldname = mysql_field_name($queryResult, $i);
		echo("<th>$fieldname</th>");
	}
	echo("<th>Image</th>");
	echo("</tr>");

	while($row = mysql_fetch_row($queryResult))
	{
		//Print data of minifig
		echo('<tr class="parts">');
		for($i = 0; $i < mysql_num_fields($queryResult); $i++)
		{
			echo("<td>$row[$i]</td>");
		}
		//Get picture
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

/**
 * Return number of results in query
 * @param $queryResult - Data from SQL-query
 */
function numOfResults($queryResult)
{
	return mysql_num_rows($queryResult);
}

function getPictureLink($queryId, $prefix)
{
	//test for sql connection
	if(@mysql_ping())
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

/**
 * Create Paging numbers for search results
 * @param $numberofResults - a total number of sets or parts in the search
 */
function CreatePaging($numberofResults)
{
	echo("<p>");
	echo("Pages: ");
	$NumberOfPages = ceil($numberofResults/11);
	for($i =0; $i < $NumberOfPages; $i++)
	{
		//print a number with a link to the javascript function that creates the paging
		echo("<a onclick='javascript:scrollResult($i);' href='#result'>".($i+1)." &nbsp;</a>");
	}
	echo("</p>");
}

/**
 * Get list of all colors a specific part has
 * @param $partID - ID of part we're looking for
 */
function GetPartColors($partID)
{
	//We do a distinct question to the database to find the colors of the part in every
	//set available
	$queryString = 	"SELECT DISTINCT colors.ColorID, colors.Colorname FROM inventory
							JOIN colors ON inventory.ColorID = colors.ColorID
							WHERE inventory.ItemID = '$partID'";
	//test connection to SQL
	if(@mysql_ping())
	{

		$colorContents = mysql_query($queryString);
		if(numOfResults($colorContents) != 0)
		{
			$colorArray = array();
			while($row = mysql_fetch_row($colorContents))
			{
				//dictionary with both colorID and name
				$colorArray["$row[1]"] = $row[0];
			}
			return $colorArray;
		}
		else
		{
			return "";
		}
	}
}