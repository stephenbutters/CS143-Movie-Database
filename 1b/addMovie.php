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

    <div class="container">
      <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-8">
          <h1>Add New Movie</h1>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>

    <div class="container">
      <form class="form-horizontal" method="GET" action="addMovie.php">
        <div class="form-group">
          <label class="col-sm-2 control-label" for="title">Title</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="title" placeholder="Text input"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="company">Company</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="company" placeholder="Text input"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="year">Year</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="year" placeholder="Text input"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="rating">MPAA Rating</label>
          <div class="col-sm-10">
            <select class="form-control" name="rating">
              <option value="G">G</option>
              <option value="NC-17">NC-17</option>
              <option value="PG">PG</option>
              <option value="PG-13">PG-13</option>
              <option value="R">R</option>
              <option value="surrendere">surrendere</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="genre">Genre</label>
          <div class="col-sm-10">
            <input type="checkbox" name="genre[]" value="Action">Action</input>
            <input type="checkbox" name="genre[]" value="Adult">Adult</input>
            <input type="checkbox" name="genre[]" value="Adventure">Adventure</input>
            <input type="checkbox" name="genre[]" value="Animation">Animation</input>
            <input type="checkbox" name="genre[]" value="Comedy">Comedy</input>
            <input type="checkbox" name="genre[]" value="Crime">Crime</input>
            <input type="checkbox" name="genre[]" value="Documentary">Documentary</input>
            <input type="checkbox" name="genre[]" value="Drama">Drama</input>
            <input type="checkbox" name="genre[]" value="Family">Family</input>
            <input type="checkbox" name="genre[]" value="Fantasy">Fantasy</input>
            <input type="checkbox" name="genre[]" value="Horror">Horror</input>
            <input type="checkbox" name="genre[]" value="Musical">Musical</input>
            <input type="checkbox" name="genre[]" value="Mystery">Mystery</input>
            <input type="checkbox" name="genre[]" value="Romance">Romance</input>
            <input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi</input>
            <input type="checkbox" name="genre[]" value="Short">Short</input>
            <input type="checkbox" name="genre[]" value="Thriller">Thriller</input>
            <input type="checkbox" name="genre[]" value="War">War</input>
            <input type="checkbox" name="genre[]" value="Western">Western</input>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-2"></div>
          <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">Add</button></div>
        </div>
      </form>
    </div>

    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <?php
      //Test input condition
      if(isset($_GET["submit"])){
        if($_GET["title"] and $_GET["company"] and $_GET["year"]){
          $db_connection = mysql_connect("localhost:1438", "cs143", "");
          if(!$db_connection){
            $errmsg = mysql_error($db_connection);
            echo "Connection failed: $errmsg";
            exit(1);
          }
        }
        else{
          echo "Title, Company and Year must be entered";
          exit(1);
        }
      }
      else exit(1);

      mysql_select_db("CS143", $db_connection);

      $title = $_GET["title"];
      $company = $_GET["company"];
      $year = $_GET["year"];
      $rating = $_GET["rating"];
      $genre = $_GET["genre"];
      $query = "";

      //Acquire Max Movie ID
      $rs = mysql_query("SELECT id FROM MaxMovieID", $db_connection);
      if(!$rs){
        echo "Query failed: " . mysql_error();
        exit(1);
      }
      $maxID = mysql_fetch_row($rs)[0];

      //Insert value to Movie table
      $query = "INSERT INTO Movie VALUES($maxID + 1, '$title', $year, '$rating', '$company')";
      $rs = mysql_query($query, $db_connection);
      if(!$rs){
        echo "Query failed: " . mysql_error();
        exit(1);
      }
      else{
        echo "Add Success: ";
        echo $maxID+1 . " $title $year $rating $company";
        echo "<br/>";
      }

      //Insert value to MovieGenre table
      foreach ($genre as $g){
        $query = "INSERT INTO MovieGenre VALUES($maxID + 1, '$g')";
        $rs = mysql_query($query, $db_connection);
        if(!$rs){
          echo "Query failed: " . mysql_error();
          exit(1);
        }
        else{
          echo "Add Success: ";
          echo $maxID+1 . " $g";
          echo "<br/>";
        }
    }

      //Update Max Movie ID
      $rs = mysql_query("UPDATE MaxMovieID SET id = id + 1", $db_connection);
      if(!$rs){
        echo "Query failed: " . mysql_error();
        exit(1);
      }

      mysql_close($db_connection);
    ?>
  </body>
</html>
