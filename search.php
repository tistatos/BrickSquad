<?php
	/**
	 * 		Grupp 18 - 2012-12-10
	 * 	Name:	Daniel Rönnkvist
	 *	file: 	search.php
	 *	Desc:	searchpage
	 */

	require("./templates/search-header.php");
	//Includes function for handling SQL result layout
	require("./includes/sqlFunctions.php");
?>

	<div class="search" id="search">
		<form action="search.php" method=GET name="form">
			Common Set ID:<input type="text" size="40" name="setnr" />
			<input type=submit value="Submit" />
			<br />
			Specific Set ID:<input type="text" size="40" name="setnr_specific" />
			<input type=submit value="Submit" />
		</form>
	</div>

<!--	Advanced search to be implemented
	<div class="search" id="search">
		<form action="search.php" method=POST name="form">
			Search for:<input type="text" size="40" name="setnr" />
			<input type="image" src="images/search.png" class="submit" onsubmit="submit-form();" /><br/>
			<p class="adv">Advanced Search</p>

			<div class="opt">Year:<input type="text" size="40" name="setnr" />
							Color:<input type="text" size="40" name="setnr" /></div>

			<div class="opt2">Category:<input type="text" size="40" name="setnr" />
							Tags:<input type="text" size="40" name="setnr" /></div>
		</form>
	</div>
-->
	<div class="list" id="list">
		<p>
		<?php
		//common search
		if(sizeof($_GET) != 0 && $_GET['setnr'] != "")
		{
			//Query Database for any set - FIXME make specific and common the same!
			$contents = mysql_query("SELECT * FROM sets WHERE SetID LIKE '$setnr-%'");
			CreateTable($contents);
		}
		//Specific search for sets
		else if(sizeof($_GET) != 0 && $_GET['setnr_specific'] != "")
		{
			$contents = mysql_query("SELECT * FROM sets WHERE 1 AND SetID ='" . $setnr_specific ."'");
			CreateTable($contents);
		}
		?>
		</p>
	</div>

	<div class="selected" id="selected">
		<?php
		//Get Picture FIXME
		if(sizeof($_GET) != 0)
		{
			if($setnr != "")
			{
				$site = "http://www.bricklink.com/SL/" . $setnr ."-1.jpg" ; // visar alltid första i setordningen
				echo("<img class='select' src=$site>");
				echo("<br /> <p>Satsnummer: $setnr-1</p> ");
			}
			else
			{
				$site = "http://www.bricklink.com/SL/" . $setnr_specific .".jpg OR .png OR .gif" ; // bild för setnumber specifik
				echo("<img class='select' src=$site>");
			}
		}
		?>
		<br />
		<table border="0">
			<tr>
				<td>Lite info</td>
				<td>lite mer info</td>
			</tr>
			<tr>
				<td>INFORMATION</td>
				<td>LEGO IS FUN</td>
			</tr>
		</table>
	</div>

	<div class="is" id="is">
	<?php
	//Content of selected set
	if(sizeof($_GET) != 0)
	{
		$contents = mysql_query("	SELECT inventory.SetID, inventory.Quantity AS Qty,
									colors.Colorname as Color, parts.Partname as Name
									FROM inventory
									JOIN parts ON inventory.ItemID = parts.PartID
									JOIN colors ON inventory.ColorID = colors.ColorID
									WHERE inventory.SetID LIKE '$setnr-%'
									OR SetID ='" . $setnr_specific ."' ORDER BY SetID, Partname ");

		if(mysql_num_rows($contents) == 0)
		{
			echo("Ingen detaljerad information funnen!");
		}
		else
		{
			//Print headers for table
			echo("<table border=1>\n<tr>");
			for($i =0; $i < mysql_num_fields($contents); $i++)
			{
				$fieldname = mysql_field_name($contents, $i);
				echo("<th>$fieldname</th>");
			}
			echo ("<th>Image</th>");
			echo "</tr>\n";

			//fetch rows and fill table with data
			while($row = mysql_fetch_row($contents))
			{
				echo('<tr onclick="location.href=\'./search.php?setnr=&setnr_specific='.$row[0].'\'">');
				for($i=0; $i<mysql_num_fields($contents); $i++)
				{

					if($i == 3)
					{
						$colorName = $row[2];
						$partName = $row[$i];

						//FIXME Improve
						//Query part name and potential minifig ID
						$partIdQuery = mysql_query("SELECT PartID From parts WHERE Partname ='" . $partName ."'");
						$miniFigIdQuery = mysql_query("SELECT MinifigID FROM minifigs where Minifigname = '". $partName ."'");

						$partRow = mysql_fetch_row($partIdQuery);

						$colorIdQuery = mysql_query("	SELECT colors.ColorID, colors.Colorname FROM inventory
													JOIN colors ON inventory.ColorID = colors.ColorID
													JOIN parts ON inventory.ItemID = parts.PartID
													WHERE PartID = '". $partRow[0] ."' AND Colorname = '". $colorName ."'");
						echo("<td>$row[$i]</td>");
						$color_row = mysql_fetch_row($colorIdQuery);

						$image_Query = mysql_query("SELECT filepath FROM `images` WHERE filepath= 'P/". $color_row[0]. "/".$partRow[0].".gif' AND isthere=TRUE");
						$imageRow = mysql_fetch_row($image_Query);

						$minifigRow = mysql_fetch_row($miniFigIdQuery);

						if($imageRow != null)
						{
							$imglink = "http://img.bricklink.com/" . $imageRow[0];
							echo("<td><img src='$imglink' alt='gif-image' /></td>");
							//error_reporting(0);
						}
						else
						{
							validate_image($partRow[0], $color_row[0]);
						}
						if($minifigRow != null)
						{
							echo($partName);
							$imglink_minifig = "http://img.bricklink.com/M/ ". $minifigRow[0].".gif";
							echo("<td><img src='$imglink_minifig' alt='gif-image' /></td>");
						}
					}
					else
					{
						echo("<td>$row[$i]</td>");
					}
				}
				echo("</tr>\n");
   			}
	   		echo("</table>\n");
		}
	}

/* Search query for minifigs
SELECT inventory.SetID, inventory.Quantity, minifigs.MinifigID, minifigs.minifigname
FROM inventory
JOIN minifigs ON inventory.ItemID= minifigs.MinifigID
WHERE inventory.SetID= '1712-1'
*/

?>
	</div>
</body>
</html>


