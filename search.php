
<?php
  /**
   *    Grupp 18 - 2012-12-10
   *  Name: Daniel Rönnkvist
   *  file:   search.php
   *  Desc: searchpage
   */

  require("./templates/search-header.php");
?>

  <div class="title">
    <h1 class="titleHeader">ABOUT</h1>
    <h1 class="titleSub">Bricksquad</h1>
    <p class='tagline'>F&ouml;r oss som gillar Lego mer &auml;n stegu!</p>
  </div>

  
  <!-- <div class="search" id="search"> -->
      <form action="search.php" method=GET name="form">
      
      <table style = "border:1px solid black; text-align:left; width:200px; background-color:gray; padding:5px; margin-top: 10px;">
      <tr>
        <td>
        Common Set ID:<input type="text" size="40" name="setnr" />
        </td>
        <td>
        <input type=submit value="Submit" />
        </td>
      </tr>
      <tr>
        <td>
        Specific Set ID:<input type="text" size="40" name="setnr_specific" />
        </td>
        <td>
        <input type=submit value="Submit" />
        </td>
      </tr>
      <tr>
        <td>
        Part ID:<input type="text" size="40" name="part_id" />
        </td>
        <td>
        <input type=submit value="Submit" />
        </td>
      </tr>
      <tr>
        <td>
        Set Name:<input type="text" size="40" name="set_name" />
        </td>
        <td>
        <input type=submit value="Submit" />
        </td>
      </tr>
      <tr>
        <td>
        Part Name:<input type="text" size="40" name="part_name" />
        </td>
        <td>
        <input type=submit value="Submit" />
        </td>
      </tr>
      <tr>
        <td>
        Category Name:<input type="text" size="40" name="category_name" />
        </td>
        <td>
        <input type=submit value="Submit" />
        </td>
        Year:<input type="text" size="40" name="year" />
        </td>
        <td>
        <input type=submit value="Submit" />
        </td>
      </tr>
      </table>
      </form>
  

  <!--
  <div class="search" id="search">
    <form action="search.php" method=POST name="form">
      <span id="main-search">
        <label for="main-searchfield">Search for:</label>
        <input type="text" size="40" name="setnr" class="main-searchfield" id="main-searchfield" />
        <input type="image" src="images/search-glas.png" class="submit" onsubmit="submit-form();" /><br/>
      </span>
      <p class="adv">
        Advanced Search
        <input type="image" src="images/pil.png" class="pil">
      </p>
      <div id="advanced-search">
        <span class='left'>
          <label for="year">Year:</label>
          <input type='text' size='40' name='year' id='year' />
          <label for="color">Color:</label>
          <input type='text' size='40' name='color' id='color' />
        </span>

        <span class='right'>
          <label for="category">Category:</label>
          <input type='text' size='40' name='category' id='category' />
          <label for="tags">Tags:</label>
          <input type='text' size='40' name='tags' id='tags' />
        </span>
      </div>
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
      $contents = mysql_query("SELECT * FROM sets WHERE SetID LIKE '$setnr-%' AND Year ='" . $year ."'" );
      CreateTable($contents);
      $setnr_specific = $setnr."-1";      //////////////FULKODDDNING!!!!!!!!!!!!!!!!!!!! anger setnr_specific ett värde så att minifigurerna visas
    }
    //Specific search for sets
    else if(sizeof($_GET) != 0 && $_GET['setnr_specific'] != "")
    {
      $contents = mysql_query("SELECT * FROM sets WHERE SetID ='" . $setnr_specific ."'");
      CreateTable($contents);
    }

    //Search for part
    else if(sizeof($_GET) != 0 && $_GET['part_id'] != "")
    {
      $contents = mysql_query("SELECT * FROM parts WHERE PartID ='" . $part_id . "'");
      CreateTable($contents);
    }
    else if(sizeof($_GET) != 0 && $_GET['set_name'] != "")
    { 
      $setnr_specific = mysql_query("SELECT SetID FROM sets WHERE Setname ='" . $set_name . "'");  //klipper ut SetID
      $setnr_specific_row = mysql_fetch_row($setnr_specific);
      //echo ($setnr_specific_row[0]);
      $setnr_specific = $setnr_specific_row[0];
      //echo("<p>Specific setnr:  </p> $setnr_specific_row[0]");
      $contents = mysql_query("SELECT * FROM sets WHERE Setname ='" . $set_name ."'");
      CreateTable($contents);
      
    }
    else if(sizeof($_GET) != 0 && $_GET['category_name'] != "")
    { 
    $catalog_id = mysql_query("SELECT CatID FROM categories WHERE Categoryname ='" . $category_name ."'");

    $catalog_id_row = mysql_fetch_row($catalog_id);
    echo ($catalog_id_row[0]);
    $contents = mysql_query("SELECT * From sets WHERE CatID ='" . $catalog_id_row[0] . "' ORDER BY Year");
    
    echo("<table border=1><tr>");
    for($i =0; $i < mysql_num_fields($contents); $i++)
      {
        $fieldname = mysql_field_name($contents, $i);
        echo("<th>$fieldname</th>");
      }
      echo ("<th>Imageeeeee</th>");  //fulkooood!
      
    while($row = mysql_fetch_row($contents))
      {
        echo('<tr onclick="location.href=\'./search.php?setnr=&setnr_specific='.$row[0].'\'">');
        for($i=0; $i<mysql_num_fields($contents); $i++)
        {
            if($i == 0)
            {
              $SetID_for_image = $row[$i];
            }
            echo("<td>$row[$i]</td>");
            
        }
        //echo("$SetID_for_image");
        $site = "http://www.bricklink.com/SL/" . $SetID_for_image . ".jpg";
        echo("<td><img class='image_resize' src=$site alt='gif-image' /></td>");
        //echo("<td>$SetID_for_image</td>");
        echo("</tr>");
      }
      
    echo("</table>");
    
    
    
    /*
      echo("Kategorii nammmmna:   $category_name");
      
       $category_query = mysql_query("SELECT sets.SetID FROM sets 
                      JOIN categories ON sets.CatID = categories.CatID 
                      WHERE Categoryname = '" . $category_name . "'");
      
       while ( $setnr_specific_row = mysql_fetch_row($category_query)){
       $contents = mysql_query("SELECT * FROM sets WHERE SetID ='" . $setnr_specific_row[0] ."'");
       CreateTable($contents);
       }
       */
  
      
    }
    else if(sizeof($_GET) != 0 && $_GET['part_name'] != "")
    {
      $part_id = mysql_query("SELECT PartID FROM parts WHERE Partname ='" . $part_name . "'");  //klipper ut part_id
      $part_id_row = mysql_fetch_row($part_id);
      $part_id = $part_id_row[0];
      
      $contents = mysql_query("SELECT * FROM parts WHERE PartID ='" . $part_id_row[0] . "'");
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
      else if($setnr_specific != "" )
      {
        $site = "http://www.bricklink.com/SL/" . $setnr_specific .".jpg OR .png OR .gif" ; // bild för setnumber specifik
        echo("<img class='select' src=$site>");
      }
      
      /*
      else if($set_name != "" )
      {
        $set_name_row = mysql_fetch_row($contens1);
        echo("<p>debugg:  </p> $set_name_row[0]");
        $site = "http://www.bricklink.com/SL/1094-1.jpg OR .png OR .gif" ; // bild för setnumber specifik
        echo("<img class='select' src=$site>");
        
      }
      */
      
      else if ($part_id != "")                   //fixme (validering bilder?)
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
          {
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
    */

 
    
 

?>
</div>

<?php
  require("./templates/footer.php");
?>