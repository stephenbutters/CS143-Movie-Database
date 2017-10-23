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
          <h1>Actor Information Page</h1>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>

    <div class='container' style='padding-top:50px'>
      <div class='row'><div class='col-sm-offset-2 col-sm-10'><h4>Actor Information is:</h4></div></div>
      <div class="row">
        <div class="col-sm-offset-2 col-sm-10">
          <table class='table table-bordered'>
            <tr><th>Name</th><th>Sex</th><th>Date of Birth</th><th>Date of Death</th></tr>
            <?php
              $id = $_GET["identifier"];

              $db_connection = mysql_connect("localhost", "cs143", "");
              if(!$db_connection){
                $errmsg = mysql_error($db_connection);
                echo "Connection failed: $errmsg";
                exit(1);
              }

              mysql_select_db("CS143", $db_connection);

              $rs = mysql_query("SELECT first, last, sex, dob, dod FROM Actor WHERE id = $id", $db_connection);
              if(!$rs){
                  echo "Query failed: " . mysql_error();
                  exit(1);
              }

              while($row = mysql_fetch_row($rs)){
                $name = $row[0] . " " . $row[1];
                $sex = $row[2];
                $dob = $row[3];
                $dod = $row[4];
                echo "<tr>";
                echo "<td>$name</td><td>$sex</td><td>$dob</td><td>$dod</td>";
                echo "</tr>";
              }

              mysql_close($db_connection);
            ?>
          </table>
        </div>
      </div>
    </div>

    <div class='container' style='padding-top:50px'>
      <div class='row'><div class='col-sm-offset-2 col-sm-10'><h4>Actor's Movies and Role:</h4></div></div>
      <div class="row">
        <div class="col-sm-offset-2 col-sm-10">
          <table class='table table-bordered'>
            <tr><th>Role</th><th>Movie Title</th></tr>
            <?php
              $id = $_GET["identifier"];

              $db_connection = mysql_connect("localhost", "cs143", "");
              if(!$db_connection){
                $errmsg = mysql_error($db_connection);
                echo "Connection failed: $errmsg";
                exit(1);
              }

              mysql_select_db("CS143", $db_connection);

              $rs = mysql_query("SELECT MovieActor.role, Movie.title, Movie.id FROM Movie, MovieActor WHERE MovieActor.aid = $id AND MovieActor.mid = Movie.id", $db_connection);
              if(!$rs){
                  echo "Query failed: " . mysql_error();
                  exit(1);
              }

              while($row = mysql_fetch_row($rs)){
                $role = $row[0];
                $title = $row[1];
                $mid = $row[2];
                echo "<tr>";
                echo "<td>$role</td><td><a href='displayMovie.php?identifier=$mid'>$title</a></td>";
                echo "</tr>";
              }

              mysql_close($db_connection);
            ?>
          </table>
        </div>
      </div>
    </div>

    <div class="container" style="padding-top:50px"></div>

  </body>
</html>
