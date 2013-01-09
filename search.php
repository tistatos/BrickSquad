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
		<h1>Search</h1>
	</div>

  <div class="search">
    <form action="search.php" method="GET" id="searchForm" onsubmit="javascript:return searchValidate();">
      Search for:
      <select name="searchType" onchange="javascript:dropDownChange();">
<?php
      $types = array("setID" => "Set ID",
                     "setName" => "Set Name",
                     "setCat" => "Set Category",
                     "partID" => "Part ID",
                     "partName" => "Part Name" );
      foreach ($types as $type => $name)
      {
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
      echo("</select> <br />");

      //Users search is contained
      if(isset($searchString))
      {
        echo("Search: <input type='text' size='40' name='searchString' value='$searchString'/>");
      }
      else
      {
        echo("Search: <input type='text' size='40' name='searchString' value=''/>");
      }
      echo("<br />");
      if(isset($searchYear))
      {
        echo("Year: <input type='text' size='20' name='searchYear' value='$searchYear'/>");
      }
      else if(isset($searchType))
      {
        if($searchType == "partID" || $searchType == "partName")
        {
          echo("Year: <input type='text' size='20' name='searchYear' value='' disabled/>");
        }
      }
      else
      {
        echo("Year: <input type='text' size='20' name='searchYear' value=''/>");
      }
      echo("<br />");
      echo("<a id='result'></a>");
?>
      <input type=submit value="Submit" />
    </form>
  </div>

<?php

  // TODO: sorting with by clicking the row headers
  //TODO : how to solve multiple category results?
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
    //we need this later in this scope
    if(numOfResults($contents) > 1)
    {
      //We have multiple results and create a table of results
      CreateResultTable($contents, $searchType);

      //create paging
      CreatePaging(numOfResults($contents));
    }
    else if(numOfResults($contents) == 0)
    {
      echo("<h1>No Results!</h1>");
    }
    else
    {
      //we skip result list and show data of the only result
      $row = mysql_fetch_row($contents);

      if($searchType == "partID")
      {
        $partId = $row[0];
        $partName = $row[1];
        $category = $row[2];

        $colors = GetPartColors($partId);
        $color = 0;
        if($colors != "")
        {
          $color = $colors[0];
          $imgLink = getPictureLink($partId, "P/$color");
        }
        echo("<h1>$partName </h1> <br />");
        if($imgLink != "")
        {
          echo("<img class='select' src=$imgLink alt='' /> <br />");
        }

        echo("<p>Part ID: $partId </p>");
        echo("<p>Category: $category </p>");

        //Get all colors the part exists in
        echo("<p>Available Colors:</p>");
        $colorNewRow = 0;
        for($i = 0; $i < sizeof($colors); $i++)
        {

          $imgLink = getPictureLink($partId, "P/$colors[$i]");
          if($imgLink != "")
          {
            echo("<img src=$imgLink alt='' />");

            if(($colorNewRow % 4) == 3)
            {
              echo("<br />");
            }
            $colorNewRow++;
          }

        }
      }
      else
      {
        $setId = $row[0];
        $category = $row[1];
        $setName = $row[2];
        $year = $row[3];

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
        $setId = $row[0];
        echo('<div class="head">');
        echo('<h1> Parts </h1>');
        echo('</div>');
        echo('<div class="partlist">');
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