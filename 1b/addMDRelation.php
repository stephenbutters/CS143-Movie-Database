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
          <h1>Add Movie/Director Relation</h1>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>

    <div class="container">
      <form class="form-horizontal" action="addMDRelation.php">
        <div class="form-group">
          <label class="col-sm-2 control-label" for="movie">Movie Title</label>
          <div class="col-sm-10">
            <select class="form-control" name="movie">
              <?php
                $db_connection = mysql_connect("localhost", "cs143", "");
                if(!$db_connection){
                  $errmsg = mysql_error($db_connection);
                  echo "Connection failed: $errmsg";
                }
                mysql_select_db("CS143", $db_connection);
                $rs = mysql_query("SELECT id, title, year FROM Movie;", $db_connection);
                if(!$rs){
                  echo "Query failed: " . mysql_error();
                }
                while($row = mysql_fetch_row($rs)){
                  $id = $row[0];
                  $title = $row[1];
                  $year = $row[2];
                  echo "<option value='$id'>$title ($year)</option>";
                }

                mysql_close($db_connection);
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="director">Director</label>
          <div class="col-sm-10">
            <select class="form-control" name="director">
              <?php
                $db_connection = mysql_connect("localhost", "cs143", "");
                if(!$db_connection){
                  $errmsg = mysql_error($db_connection);
                  echo "Connection failed: $errmsg";
                }
                mysql_select_db("CS143", $db_connection);
                $rs = mysql_query("SELECT id, last, first, dob FROM Director;", $db_connection);
                if(!$rs){
                  echo "Query failed: " . mysql_error();
                }
                while($row = mysql_fetch_row($rs)){
                  $id = $row[0];
                  $last = $row[1];
                  $first = $row[2];
                  $dob = $row[3];
                  echo "<option value='$id'>$first $last ($dob)</option>";
                }

                mysql_close($db_connection);
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-2"></div>
          <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">Add</button></div>
        </div>
      </form>
    </div>

    <?php
      //Test input condition
      if(isset($_GET["submit"])){
        $db_connection = mysql_connect("localhost:1438", "cs143", "");
        if(!$db_connection){
          $errmsg = mysql_error($db_connection);
          echo "Connection failed: $errmsg";
          exit(1);
        }
      }
      else exit(1);

      mysql_select_db("CS143", $db_connection);

      $mid = $_GET["movie"];
      $did = $_GET["director"];
      $query = "";

      //Insert value to MovieActor table
      $query = "INSERT INTO MovieDirector VALUES($mid, $did)";
      $rs = mysql_query($query, $db_connection);
      if(!$rs){
        echo "Query failed: " . mysql_error();
        exit(1);
      }
      else
        echo "Add Success";

      mysql_close($db_connection);
    ?>
  </body>
</html>
