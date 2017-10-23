<html>
<head><title>Retrieve data using sql</title></head>
<body>
  <h2>Type an sql query in the following box:</strong></h2>
  <form action="query.php" method="GET">
    <textarea name="query" cols="60" rows="8"></textarea>
  <br/>
    <input type="submit"></input>
  </form>
  <?php
    if($_GET["query"]){
      $db_connection = mysql_connect("localhost", "cs143", "");
      if(!$db_connection){
        $errmsg = mysql_error($db_connection);
        echo "Connection failed: $errmsg";
        exit(1);
      }

      mysql_select_db("CS143", $db_connection);

      $query = $_GET["query"];
      $rs = mysql_query($query, $db_connection);
      if(!$rs){
          echo "Query failed: " . mysql_error();
          exit(1);
      }

      echo "<h3>Results from MySQL:</h3>";
      echo "<table border=1 cellspacing=1 cellpadding=2>";
      echo "<tr align=center>";
      $j = 0;
      while($j < mysql_num_fields($rs)){
          $meta = mysql_fetch_field($rs, $j);
          if(!$meta){
            echo "No information available";
          }
          echo "<th>$meta->name</th>";
          $j++;
      }
      echo "</tr>";

      while($row = mysql_fetch_row($rs)){
        $length = count($row);
        echo "<tr align=center>";
        for($i = 0; $i < $length; $i++){
          $temp = $row[$i];
          echo "<td>$temp</td>";
        }
        echo "</tr>";
      }
      echo "</table>";

      mysql_close($db_connection);
    }
  ?>
</body>
</html>
