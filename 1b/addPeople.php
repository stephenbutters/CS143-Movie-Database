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
          <h1>Add Actor/Director</h1>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>

    <div class="container">
      <form class="form-horizontal" method="GET" action="addPeople.php">
        <div class="form-group">
          <div class="col-sm-2"></div>
          <div class="col-sm-10">
            <label class="radio-inline">
              <input type="radio" checked="checked" name="identity" value="Actor"/>Actor
            </label>
            <label class="radio-inline">
              <input type="radio" name="identity" value="Director"/>Director
            </label>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="FirstName">First Name</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="FirstName" placeholder="First Name"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="LastName">Last Name</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="LastName" placeholder="Last Name"></div>
        </div>
        <div class="form-group">
          <div class="col-sm-2"></div>
          <div class="col-sm-10">
            <label class="radio-inline">
              <input type="radio" checked="checked" name="sex" value="male"/>Male
            </label>
            <label class="radio-inline">
              <input type="radio" name="sex" value="female"/>Female
            </label>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="DOB">Date of Birth</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="dateb" placeholder="Text input"><p class="help-block">ie: 1997-05-05</p></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="DOD">Date of Death</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="dated" placeholder="Text input"><p class="help-block">leave blank if alive now</p></div>
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
        if($_GET["FirstName"] and $_GET["LastName"] and $_GET["dateb"]){
          $db_connection = mysql_connect("localhost:1438", "cs143", "");
          if(!$db_connection){
            $errmsg = mysql_error($db_connection);
            echo "Connection failed: $errmsg";
            exit(1);
          }
        }
        else{
          echo "FirstName, LastName and dob must be entered";
          exit(1);
        }
      }
      else exit(1);

      mysql_select_db("CS143", $db_connection);

      $identity = $_GET["identity"];
      $FirstName = $_GET["FirstName"];
      $LastName = $_GET["LastName"];
      $sex = $_GET["sex"];
      $dob = $_GET["dateb"];
      if($_GET["dated"]) $dod = "'" . $_GET["dated"] . "'"; else $dod = "NULL";
      $query = "";

      //Acquire Max Person ID
      $rs = mysql_query("SELECT id FROM MaxPersonID", $db_connection);
      if(!$rs){
        echo "Query failed: " . mysql_error();
        exit(1);
      }
      $maxID = mysql_fetch_row($rs)[0];

      //Insert value to table
      if($identity == "Actor") $query = "INSERT INTO Actor VALUES($maxID + 1, '$LastName', '$FirstName', '$sex', '$dob', $dod)";
      else $query = "INSERT INTO Director VALUES($maxID + 1, '$LastName', '$FirstName', '$dob', $dod)";
      $rs = mysql_query($query, $db_connection);
      if(!$rs){
        echo "Query failed: " . mysql_error();
        exit(1);
      }
      else{
        echo "Add Success: ";
        echo $maxID+1 . " $LastName $FirstName $sex $dob $dod";
      }

      //Update Max Person ID
      $rs = mysql_query("UPDATE MaxPersonID SET id = id + 1", $db_connection);
      if(!$rs){
        echo "Query failed: " . mysql_error();
        exit(1);
      }

      mysql_close($db_connection);
    ?>
  </body>
</html>
