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
          <h1>Add Review</h1>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>

    <?php $id = $_GET["movie"];?>

    <div class="container">
      <form class="form-horizontal" action="addReview.php">
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
                $rs = mysql_query("SELECT title, year, id FROM Movie WHERE id = $id", $db_connection);
                if(!$rs){
                  echo "Query failed: " . mysql_error();
                }
                $row = mysql_fetch_row($rs);
                $title = $row[0];
                $year = $row[1];
                $mid = $row[2];
                echo "<option value='$mid'>$title ($year)</option>";

                mysql_close($db_connection);
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="name">Name</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="name" placeholder="Text input"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="rating">Rating</label>
          <div class="col-sm-10">
            <select class="form-control" name="rating">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="comment">Comment</label>
          <div class="col-sm-10">
            <textarea class="form-control" name="comment" placeholder="Text input"></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-2"></div>
          <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">Add</button></div>
        </div>
      </form>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
          <b><a href="displayMovie.php?identifier=<?php echo $id;?>">Go Back To the Movie Info Page</a></b>
        </div>
      </div>
    </div>

    <?php
      //Test input condition
      if(isset($_GET["submit"])){
        if($_GET["name"]){
          $db_connection = mysql_connect("localhost:1438", "cs143", "");
          if(!$db_connection){
            $errmsg = mysql_error($db_connection);
            echo "Connection failed: $errmsg";
            exit(1);
          }
        }
        else{
          echo "Name must be entered";
          exit(1);
        }
      }
      else exit(1);

      mysql_select_db("CS143", $db_connection);

      $name = $_GET["name"];
      $mid = $_GET["movie"];
      $rating = $_GET["rating"];
      $comment = $_GET["comment"];
      $time = date("Y-m-d h:i:s", time());
      $query = "";

      //Insert value to MovieActor table
      $query = "INSERT INTO Review VALUES('$name', '$time', $mid, $rating, '$comment')";
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
