<?php
	/**
	*    Grupp 18 - 2012-12-10
   	*  Name: Daniel Rönnkvist
	*  file: search.php
	*  Desc: searchpage for bricksquad
	*/
require("./templates/headerWMySQL.php");

if(sizeof($_GET) != 0)
{
	//GET Data from user's search
	$searchType = $_GET['searchType'];
	$searchString = $_GET['searchString'];
	if(isset($_GET['searchYear']))
	{
		$searchYear = $_GET['searchYear'];
	}

}

?>
<div class="title">
	<h1 class="titleHeader">SEARCH</h1>
	<h1 class="titleSub">Bricksquad</h1>
	<?php
		$queryString = "SELECT TABLE_NAME, TABLE_ROWS
						FROM TABLES
						WHERE TABLE_SCHEMA ='lego'";
		if(@mysql_ping())
		{
			mysql_select_db("information_schema");
			$content = mysql_query($queryString);
			mysql_select_db("lego");
			echo("<p class='tagline'>");
			echo("This database contains: <br />");
			while($row = mysql_fetch_row($content))
			{
				switch($row[0])
				{
					case "parts":
					echo("$row[1] number of Parts! <br />");
					break;
					case "sets":
					echo("$row[1] number of Sets! <br />");
					break;
				}
			}
			echo("</p>");
		}
?>
</div>
<div class="head">
	<h1>Search</h1>
</div>

<div class="search">
	<form action="search.php" method="GET" id="searchForm" onsubmit="javascript:return searchValidate();">
	<table class="searchTable">
		<tr>
			<td>Search for:</td>
			<td><select name="searchType" onchange="javascript:dropDownChange();">
			<?php
				//search types
				$types = array(	"setID" => "Set ID",
								"setName" => "Set Name",
								"setCat" => "Set Category",
								"partID" => "Part ID",
								"partName" => "Part Name" );

				foreach ($types as $type => $name)
				{
					//If user's made a search, make his searchType selected
					if(isset($searchType))
					{
						if($searchType == $type)
						{
							echo("<option value='$type' selected>$name</option>");
						}
						else
						{
						echo("<option value='$type'>$name</option>");
						}
					}
					else
					{
						echo("<option value='$type'>$name</option>");
					}
				}
				echo("</select> </td>");
				echo("</tr>");
				echo("<tr>");
				echo("<td>Search:</td>");
				echo("<td>");
				//Users search string is contained
				if(isset($searchString))
				{
					echo("<input type='text' size='40' name='searchString' value='$searchString'/>");
				}
				else
				{
					echo("<input type='text' size='40' name='searchString' value=''/>");
				}
				echo("</td>");
				echo("</tr>");
				echo("<tr>");
				echo("<td>Year:</td>");
				echo("<td>");
				//Users year serch string is contained
				if(isset($searchYear))
				{
					echo("<input type='text' size='4' name='searchYear' value='$searchYear'/>");
				}
				else if(isset($searchType))
				{
					//If user was searching for partID or partName, disable the year input
					if($searchType == "partID" || $searchType == "partName")
					{
						echo("<input type='text' size='4' name='searchYear' value='' disabled/>");
					}
				}
				else
				{
					echo("<input type='text' size='4' name='searchYear' value=''/>");
				}
				echo("</td>");
				echo("</tr>");
				echo("</table>");
			?>

		<!--Anchor used when user clicks for a new page in search -->
		<a id='result'></a>
		<input type=submit value="Submit" />
	</form>
</div>

<?php
	//Search result list
	if(sizeof($_GET) !=0)
	{
		echo('<div class="head">');
		echo('<h1>Result</h1>');
		echo('</div>');
		echo('<div class="selected">');

		//skeleton of our searchstring when we're searching for sets
		$queryString = "SELECT setID as 'Set ID',
		categories.Categoryname as 'Category',
		setname as 'Set Name',
		year as 'Year'
		FROM sets
		JOIN categories ON sets.CatID = categories.CatID";

		//depending on our choice, we get different queries
		switch($searchType)
		{
		case "setID": //searching for setID
			$queryString .= " WHERE SetID LIKE '$searchString%'";

			if($searchYear)
			{
				//search with year
				$queryString .= " AND Year ='$searchYear'";
			}
		break;

		case "setName": //search for set names
			$queryString .= " WHERE Setname LIKE '%$searchString%'";
			if($searchYear)
			{
				//search with year
				$queryString .= " AND Year ='$searchYear'";
			}
		break;

		case "setCat": //search for all sets in category
			//get the CatID to later find all sets with this CatID
			$categoryQuery = "SELECT CatID FROM categories WHERE Categoryname like'%$searchString%'";

			$catalogId = mysql_query($categoryQuery);
			$catalogIdRow = mysql_fetch_row($catalogId);

			$queryString .= " WHERE sets.CatID ='" . $catalogIdRow[0] . "'";

			if($searchYear)
			{
				//search with year
				$queryString .= " AND Year ='$searchYear'";
			}
		break;

		case "partID":  //Search for pieces with ID
			$queryString = "SELECT PartId as 'Part ID',
							Partname as 'Part Name',
							categories.Categoryname as 'Category'
							FROM parts
							JOIN categories ON parts.CatID = categories.CatID
							WHERE PartID = '$searchString'";
		break;

		case "partName":   //Search for piece with name
			$queryString = "SELECT PartId as 'Part ID',
							Partname as 'Part Name',
							categories.Categoryname as 'Category'
							FROM parts
							JOIN categories ON parts.CatID = categories.CatID
							WHERE Partname like'%$searchString%'";
		break;
		}
	//Send query
	$contents = mysql_query($queryString);

	if(numOfResults($contents) > 1)
	{
		//We have multiple results and create a table of results
		CreateResultTable($contents, $searchType);

		//Create paging:
		//Paging is client-side i.e there is no new request to the server
		//making the switch between pages very quick.
		CreatePaging(numOfResults($contents));
	}
	else if(numOfResults($contents) == 0)
	{
		//The search gave no results
		echo("<h1>No Results!</h1>");
	}
	else
	{
		//we skip result list and show data of the only result
		$row = mysql_fetch_row($contents);

		if($searchType == "partID")
		{
			//We've searched for parts
			$partId = $row[0];
			$partName = $row[1];
			$category = $row[2];

			//Get the colors the part is available in.
			$colors = GetPartColors($partId);
			$color = 0;
			if($colors != "")
			{
				//We get the first color and show it as  a big picture
				foreach($colors as $key => $value)
				{
					$color = $value;
					break;
				}
				$imgLink = getPictureLink($partId, "P/$color");
			}

			//Print the Data for the Part
			echo("<h1>$partName </h1> <br />");
			if($imgLink != "")
			{
				echo("<img class='select' src=$imgLink alt='' /> <br />");
			}
			echo("<p>Part ID: $partId </p>");
			echo("<p>Category: $category </p>");

			//Get all colors the part exists in and show pictures for the colors
			echo("<p>Available Colors:</p>");
			$colorNewRow = 0;

			//key is name, value is colorID
			$noPics = "<p>";
			foreach($colors as $key => $value)
			{
				$imgLink = getPictureLink($partId, "P/$value");
				if($imgLink != "")
				{
					echo("<img src=$imgLink alt='' />");
					if(($colorNewRow % 4) == 3)
					{
						echo("<br />");
					}
					$colorNewRow++;
				}
				else
				{
					//If there is no picture, just print the name below pictures
					$noPics .="$key<br /  >";
				}
			}
			$noPics.="</p>";
			echo("$noPics");
		}
		else
		{
			//We're showing a Set
			$setId = $row[0];
			$category = $row[1];
			$setName = $row[2];
			$year = $row[3];

			//Get picture of the set
			$imgLink = getPictureLink($setId, "S");
			$bigImgLink = "http://img.bricklink.com/SL/$setId.jpg";

			echo("<h1>$setName </h1>");
			if(@fclose(fopen($bigImgLink, "r")))
			{
				//if we have large picture of set, use it
				echo("<img class='select' src=$bigImgLink alt='' /> <br />");
			}
			else if($imgLink != "")
			{
				//no big image, rely on database to give us a small picture
				echo("<img class='select' src=$imgLink alt='' /> <br />");
			}
			else
			{
				//no result from datebase
				echo("<h1>No Image</h1>");
			}
			//print data
			echo("<p>Set ID: $setId </p>");
			echo("<p>Category: $category </p>");
			echo("<p>year: $year </p>");
		}
	}
	echo('</div>'); //end of selected


	//Detailed partlist
	if($searchType == "setID")
		{
			if(numOfResults($contents) == 1)
			{
				//only show this part if our original search has one result
				$setId = $row[0];

				echo('<div class="head">');
				echo('<h1> Parts </h1>');
				echo('</div>');
				echo('<div class="partlist">');

				//Get the parts in the set
				$queryString = "SELECT parts.PartID,
				parts.Partname AS Name,
				colors.Colorname AS Color,
				inventory.Quantity AS Qty
				FROM inventory
				JOIN parts ON inventory.ItemID = parts.PartID
				JOIN colors ON inventory.colorID = colors.colorID
				WHERE inventory.SetID ='$setId'";

				//Send Query
				$partContent = mysql_query($queryString);
				createPartListTable($partContent);
				echo('<br>');

				//Mini figures
				$queryString = "SELECT minifigID as 'Figure ID',
				Minifigname as 'Figure Name'
				FROM minifigs
				JOIN inventory ON inventory.ItemID = minifigs.MinifigID
				WHERE inventory.SetID ='$setId'";
				$minifigContent = mysql_query($queryString);
				if(numOfResults($minifigContent) != 0)
				{
					createMiniFigTable($minifigContent);
				}
				echo('</div>');
			}
		}
	}
	require("./templates/footer.php");
?>