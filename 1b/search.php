<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CS143 Movie Datebase System</title>
    <link href="bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Add New Content<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="addPeople.php">Add Actor/Director</a></li>
                <li><a href="addMovie.php">Add Movie Information</a></li>
                <li><a href="addMARelation.php">Add Movie/Actor Relation</a></li>
                <li><a href="addMDRelation.php">Add Movie/Director Relation</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Browsing Content<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="showActor.php">Show Actor Information</a></li>
                <li><a href="showMovie.php">Show Movie Information</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Search Interface<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="search.php">Search Anything</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <div class="container">
      <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-8">
          <h1>Searching Page</h1>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>

    <div class="container">
      <form class="form-horizontal" method="GET" action="search.php">
        <div class="form-group">
          <label class="col-sm-2 control-label" for="search_input">Search</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="search_input" placeholder="Search..."></div>
        </div>
        <div class="form-group">
          <div class="col-sm-2"></div>
          <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">Search</button></div>
        </div>
      </form>
    </div>

    <?php
      //Test input condition
      if(isset($_GET["submit"])){
        if($_GET["search_input"]){
          $db_connection = mysql_connect("localhost:1438", "cs143", "");
          if(!$db_connection){
            $errmsg = mysql_error($db_connection);
            echo "Connection failed: $errmsg";
            exit(1);
          }
        }
        else{
          echo "Search box must be entered.";
          exit(1);
        }
      }
      else exit(1);

      mysql_select_db("CS143", $db_connection);

      $search_input = $_GET["search_input"];
      $query = "";

      //Matching Actors
      $split = explode(" ", $search_input);
      $f = $split[0];
      $l = $split[1];
      if($l)
        $query = "SELECT first, last, dob, id FROM Actor WHERE first LIKE '%$f%' AND last LIKE '%$l%'";
      else
        $query = "SELECT first, last, dob, id FROM Actor WHERE first LIKE '%$f%' OR last LIKE '%$f%'";
      $rs = mysql_query($query, $db_connection);
      if(!$rs){
        echo "Query failed: " . mysql_error();
        exit(1);
      }
      echo "<div class='container' style='padding-top:50px'>";
      echo "<div class='row'><div class='col-sm-offset-2 col-sm-8'><h4>Matching Actors</h4></div></div>";
      echo "<div class='row'>";
      echo "<div class='col-sm-2'></div>";
      echo "<div class='col-sm-10'>";
      echo "<table class='table table-bordered'>";
      echo "<tr><th>Name</th><th>Date of Birth</th></tr>";
      while($row = mysql_fetch_row($rs)){
        $name = $row[0] . " " . $row[1];
        $dob = $row[2];
        $id = $row[3];
        echo "<tr><td><a href='displayActor.php?identifier=$id'>$name</a></td><td><a href='displayActor.php?identifier=$id'>$dob</a></td></tr>";
      }
      echo "</table>";
      echo "</div>";
      echo "</div>";
      echo "</div>";

      //Matching Moviess
      $query = "SELECT title, year, id FROM Movie WHERE title LIKE '%$search_input%'";
      $rs = mysql_query($query, $db_connection);
      if(!$rs){
        echo "Query failed: " . mysql_error();
        exit(1);
      }
      echo "<div class='container' style='padding-top:50px'>";
      echo "<div class='row'><div class='col-sm-offset-2 col-sm-8'><h4>Matching Movies</h4></div></div>";
      echo "<div class='row'>";
      echo "<div class='col-sm-2'></div>";
      echo "<div class='col-sm-10'>";
      echo "<table class='table table-bordered'>";
      echo "<tr><th>Title</th><th>Year</th></tr>";
      while($row = mysql_fetch_row($rs)){
        $title = $row[0];
        $year = $row[1];
        $id = $row[2];
        echo "<tr><td><a href='displayMovie.php?identifier=$id'>$title</a></td><td><a href='displayMovie.php?identifier=$id'>$year</a></td></tr>";
      }
      echo "</table>";
      echo "</div>";
      echo "</div>";
      echo "</div>";

      mysql_close($db_connection);
    ?>
  </body>
</html>
