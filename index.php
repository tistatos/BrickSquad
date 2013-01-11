<?php
	/**
	 * 		Grupp 18 - 2012-12-10
	 * 	Name:	Daniel Rönnkvist
	 *	file: 	Index.php
	 *	Desc:	home/index of website
	 */
	//import that has a SQL connection
	require("./templates/headerWMySQL.php");
?>
<div class="title" id="title">
	<h1 class="titleHeader">BRICKSQUAD</h1>
	<p class='tagline'>F&ouml;r oss som gillar Lego mer &auml;n stegu!</p>
</div>

<div class="head">
	<h1>Home</h1>
</div>
<div class="selected" id="selected">
	<h1 class="titleHeader">Set of the Day!</h1>
	<?php
		//Depending on day, we create variables for a search
		$today = getdate();
		$weekDay = 0;
		$dateRand = 0;
		switch($today["weekday"])
		{
			case "Monday":
				$weekDay = 0;
				break;
			case "Tuesday":
				$weekDay = 1;
				break;
			case "Wedneseday":
				$weekDay = 2;
				break;
			case "Thursday":
				$weekDay = 3;
				break;
			case "Friday":
				$weekDay = 4;
				break;
			case "Saturday":
				$weekDay = 5;
				break;
			case "Sunday":
				$weekDay = 6;
				break;
		}
		$weekDay = ceil(($weekDay/6) * 4);
		//switch to information_schema to get number of entries in sets
		$numOfSets = 0;
		if(@mysql_ping())
		{
			$queryString = "SELECT TABLE_ROWS FROM TABLES
							WHERE TABLE_SCHEMA = 'lego'
							AND TABLE_NAME = 'sets'";
			$TotSetContent = mysql_db_query("information_schema", $queryString);
			$row = mysql_fetch_row($TotSetContent);
			$numOfSets = intval($row[0]);
			mysql_select_db("lego");

			$dateRand = ceil(($today["yday"]/365) * $numOfSets);
			$queryString = "SELECT setID as 'Set ID',
		                      categories.Categoryname as 'Category',
		                      setname as 'Set Name',
		                      year as 'Year'
		                      FROM sets
		                      JOIN categories ON sets.CatID = categories.CatID
		                      ORDER BY $weekDay
		                      LIMIT $dateRand,1";
		    //echo($queryString);

		    $setContent = mysql_query($queryString);

		    $row = mysql_fetch_row($setContent);

		    //get the different set data
		    $setId = $row[0];

		    //Get picture of the set
		    $imgLink = getPictureLink($setId, "S");
		    $bigImgLink = "http://img.bricklink.com/SL/$setId.jpg";

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

			echo('<table class="info">');
			echo('<tr class="header">');

			for($i=0; $i<mysql_num_fields($setContent); $i++)
			{
				//Print column heading
				$fieldname = mysql_field_name($setContent, $i);
				echo("<th>$fieldname</th>");
			}
			echo "</tr>\n";
			echo('<tr class="parts" onclick="location.href=\'./search.php?searchType=setID&amp;searchString='.$row[0].'&amp;searchYear=\'">');
			for($i = 0; $i< mysql_num_fields($setContent); $i++)
			{
				echo("<td>$row[$i]</td>");
			}
			echo ("</tr>");

			echo("</table>");
		}
	?>
</div>

<?php
	require("./templates/footer.php");
?>