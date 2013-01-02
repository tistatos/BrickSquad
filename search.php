<?php
  /**
   *    Grupp 18 - 2012-12-10
   *  Name: Daniel Rönnkvist
   *  file: search.php
   *  Desc: searchpage
   */
  require("./templates/search-header.php");

  if(sizeof($_GET) != 0)
  {
    //Data from user
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
    <p class='tagline'>F&ouml;r oss som gillar Lego mer &auml;n stegu!</p>
  </div>

	<div class="head">
		<p> <h1>Search</h1> </p>
	</div>

  <div class="search">
    <form action="search.php" method="GET" id="searchForm" onsubmit="javascript:return searchValidate();">
      Search for:
      <select name="searchType" onchange="javascript:dropDownChange();">
        <option value="setID">Set ID</option>
        <option value="setName">Set Name</option>
        <option value="setCat">Set Category</option>
        <option value="partID">Part ID</option>
        <option value="partName">Part Name</option>
      </select> <br />
      Search: <input type="text" size="40" name="searchString" /><br />
      Year: <input type="text" size="20" name="searchYear" /><br />
      <input type=submit value="Submit" />
    </form>
  </div>

<?php

  // TODO: how should we handle ID searches?
  // TODO: if result of query is just one set/part - skip searchresult
  // TODO: should we make a maximum amount of search results per page?
  // TODO: sorting with by clicking the row headers

  //Search result list
  if(sizeof($_GET) !=0)
  {
    echo('<div class="head">');
    echo('<p> <h1> Result </h1></p>');
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
        //TODO : how to solve multiple category results?

        //get the CatID to later find all sets with this CatID
        $categoryQuery = "SELECT CatID FROM categories WHERE Categoryname like'%$searchString%'";

        $catalogId = mysql_query($categoryQuery);
        $catalogIdRow = mysql_fetch_row($catalogId);

        $queryString .= " WHERE sets.CatID ='" . $catalogIdRow[0] . "' ORDER BY Year";
      break;

      case "partID":  //Search for pieces with ID
        $queryString = "SELECT * FROM parts
                              JOIN categories ON parts.CatID = categories.CatID
                              WHERE PartID LIKE '$searchString%'";
      break;

      case "partName":   //Search for piece with name
        $queryString = "SELECT * FROM parts
                              JOIN categories ON parts.CatID = categories.CatID
                              WHERE Partname like'%$searchString%'";
      break;
    }

    //Send query
    $contents = mysql_query($queryString);
    //we need this later in this scope
    $row;
    if(numOfResults($contents) > 1)
    {
      //We have multiple results and create a table of results
      CreateResultTable($contents, $searchType);
    }
    else
    {
      //we skip result list and show data of the only result
      $row = mysql_fetch_row($contents);

      if($searchType == "partID")
      {
        $partId = $row[0];
        $category = $row[1];
        $partName = $row[2];
        //FIXME: prefix is incorrect - we need to get a color for the part
        $site = getPictureLink($partId, "P");
        echo('<h1>$partName </h1> <br />');
        echo('<img class="select" src=$site alt="No Image" /><br /> ');
        echo('<p>Part ID: $setOrPartId </p>');
        echo('<p>Category: $category </p>');
      }
      else
      {
        $setId = $row[0];
        $category = $row[1];
        $setName = $row[2];
        $year = $row[3];

        $site = getPictureLink($setId, "S");
        echo("<h1>$setId </h1>");
        if($site != "")
        {
          echo("<img class='select' src=$site alt='' /> <br />");
        }
        else
        {
          echo("<h1>No Image</h1>");
        }
        echo("<p>Set ID: $setId </p>");
        echo("<p>Category: $category </p>");
        echo("<p>year: $year </p>");
      }
    }
    echo('</div>');

    //Detailed partlist
    if($searchType == "setID")
    {
      if(numOfResults($contents) == 1)
      {
        $setId = $row[0];
        echo('<div class="head">');
        echo('<p> <h1> Parts </h1></p>');
        echo('</div>');
        echo('<div class="partlist">');
        $queryString = "SELECT parts.PartID, parts.Partname AS Name, colors.Colorname AS Color, inventory.Quantity AS Qty
                        FROM inventory
                        JOIN parts ON inventory.ItemID = parts.PartID
                        JOIN colors ON inventory.colorID = colors.colorID
                        WHERE inventory.SetID ='$setId'";

        //Send Query
        $partContent = mysql_query($queryString);
        createPartListTable($partContent);
        echo('</div>');
      }
    
?>

    <?php
    //Get Picture FIXME
    /*
      if ($part_id != "")                   //fixme (validering bilder?)
      {

        $colorIdQuery = mysql_query(" SELECT DISTINCT colors.ColorID, colors.Colorname FROM inventory
                          JOIN colors ON inventory.ColorID = colors.ColorID
                          JOIN parts ON inventory.ItemID = parts.PartID
                          WHERE PartID = '". $part_id ."' ORDER BY ColorID");




        echo("<table border=1>");

        $alt_image = validate_image($part_id, $color_row[0]);

        $filePathQuery = mysql_query(" SELECT filepath, isthere FROM `images` WHERE filepath LIKE 'P/$color_row[0]/%' ");

        while ($color_row = mysql_fetch_row($colorIdQuery)){

        $path_check ="P/" . $color_row[0] . "/" . $part_id . ".gif";


              if($path_check == $filePathQuery)   //fixme!! fixa validering om inte bilden finns i DB
              {
              $site = "http://img.bricklink.com/P/" . $color_row[0] . "/" . $part_id . ".gif";
                echo("<tr><td><img class='select' src=$site alt='no-image' /></td>");

              }
              else
              {
                validate_image($part_id, $color_row[0]);
              }
              echo("<td>$color_row[1]</td></tr>");
        }
        echo("</table > ");
      }
    }*/

    ?>

  <?php
  /*
  <div class="is" id="is">
  //Content of selected set
  if(sizeof($_GET) != 0)
  {
    $contents = mysql_query(" SELECT inventory.SetID, inventory.Quantity AS Qty,
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

            $colorIdQuery = mysql_query("SELECT colors.ColorID, colors.Colorname FROM inventory
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
          {// asd
            echo("<td>$row[$i]</td>");
          }
        }
        echo("</tr>\n");
      }
      echo("</table>\n");
    }



      //Search query for everythhing in sets
      $table_query = mysql_query("SELECT minifigs.MinifigID,inventory.Quantity, inventory.SetID, minifigs.Minifigname
                      FROM inventory
                      JOIN minifigs ON inventory.ItemID= minifigs.MinifigID
                      WHERE inventory.SetID= '$setnr-%' OR inventory.SetID ='" . $setnr_specific ."'");


      //echo($table_query[$i]);

      if(mysql_num_rows($table_query) == 0)
      {
        echo("Ingen detaljerad information funnen!");
      }
      else
      {
        echo("<table border=1>\n");
        echo("<th> MinifigID </th><th> Qty </th><th> SetID </th><th> Name</th><th> Image </th>");
      }
      while($miniFigTableRow = mysql_fetch_row($table_query))
      {
        echo("<tr>");
        for($n=0; $n<mysql_num_fields($table_query); $n++)
        {
          echo("<td> $miniFigTableRow[$n] </td>");
        }
        $imglink_minifig = "http://img.bricklink.com/M/".$miniFigTableRow[0].".gif"  ;
        echo("<td><img src='$imglink_minifig' alt='gif-image' /></td>");
        echo("</tr>");
      }
        echo("</table>\n");
  }
    /*
    //Part search
    $part_query = mysql_query("SELECT PartID, Partname FROM `parts` WHERE PartID = 'part_id' ");
    $partTable_row = mysql_fetch_row($part_query);

        echo("<td>$partTable_row[0]</td>");
          }
        }


</div>
*/
?>


<?php
  require("./templates/footer.php");
?>