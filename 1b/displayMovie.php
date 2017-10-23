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
          <h1>Movie Information Page</h1>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>

    <div class='container' style='padding-top:20px'>
      <div class='row'><div class='col-sm-offset-2 col-sm-10'><h4><b>Movie Information is:</b></h4></div></div>
      <?php
        $id = $_GET["identifier"];

        $db_connection = mysql_connect("localhost", "cs143", "");
        if(!$db_connection){
          $errmsg = mysql_error($db_connection);
          echo "Connection failed: $errmsg";
          exit(1);
        }

        mysql_select_db("CS143", $db_connection);

        $rs = mysql_query("SELECT title, company, rating FROM Movie WHERE Movie.id = $id", $db_connection);
        if(!$rs){
          echo "Query failed: " . mysql_error();
          exit(1);
        }
        $row = mysql_fetch_row($rs);
        $title = $row[0];
        $producer = $row[1];
        $rating = $row[2];
        $rs = mysql_query("SELECT genre FROM MovieGenre WHERE mid = $id", $db_connection);
        if(!$rs){
          echo "Query failed: " . mysql_error();
          exit(1);
        }
        $genre = "";
        while($row = mysql_fetch_row($rs)){
          $genre = $genre . " " . $row[0];
        }
        $rs = mysql_query("SELECT CONCAT(Director.first, ' ', Director.last) FROM Director, MovieDirector WHERE MovieDirector.mid = $id AND MovieDirector.did = Director.id", $db_connection);
        if(!$rs){
          echo "Query failed: " . mysql_error();
          exit(1);
        }
        $row = mysql_fetch_row($rs);
        $director = $row[0];

        mysql_close($db_connection);
      ?>
      <div class='row'><div class='col-sm-offset-2 col-sm-10'>Title: <?php echo $title;?></div></div>
      <div class='row'><div class='col-sm-offset-2 col-sm-10'>Producer: <?php echo $producer;?></div></div>
      <div class='row'><div class='col-sm-offset-2 col-sm-10'>Rating: <?php echo $rating;?></div></div>
      <div class='row'><div class='col-sm-offset-2 col-sm-10'>Director: <?php echo $director;?></div></div>
      <div class='row'><div class='col-sm-offset-2 col-sm-10'>Genre: <?php echo $genre;?></div></div>
    </div>

    <div class='container' style='padding-top:20px'>
      <div class='row'><div class='col-sm-offset-2 col-sm-10'><h4><b>Actors in this Movie:</b></h4></div></div>
      <div class="row">
        <div class="col-sm-offset-2 col-sm-10">
          <table class='table table-bordered'>
            <tr><th>Name</th><th>Role</th></tr>
            <?php
              $id = $_GET["identifier"];

              $db_connection = mysql_connect("localhost", "cs143", "");
              if(!$db_connection){
                $errmsg = mysql_error($db_connection);
                echo "Connection failed: $errmsg";
                exit(1);
              }

              mysql_select_db("CS143", $db_connection);

              $rs = mysql_query("SELECT CONCAT(Actor.first, ' ', Actor.last), MovieActor.role, Actor.id FROM Actor, MovieActor WHERE Actor.id = MovieActor.aid AND MovieActor.mid = $id", $db_connection);
              if(!$rs){
                  echo "Query failed: " . mysql_error();
                  exit(1);
              }

              while($row = mysql_fetch_row($rs)){
                $name = $row[0];
                $role = $row[1];
                $aid = $row[2];
                echo "<tr>";
                echo "<td><a href='displayActor.php?identifier=$aid'>$name</a></td><td>$role</td>";
                echo "</tr>";
              }

              mysql_close($db_connection);
            ?>
          </table>
        </div>
      </div>
    </div>

    <div class="container" style="padding-top:20px">
      <div class='row'><div class='col-sm-offset-2 col-sm-10'><h4><b>User Review:</b></h4></div></div>
      <?php
        $db_connection = mysql_connect("localhost", "cs143", "");
        if(!$db_connection){
          $errmsg = mysql_error($db_connection);
          echo "Connection failed: $errmsg";
          exit(1);
        }

        mysql_select_db("CS143", $db_connection);

        $rs = mysql_query("SELECT AVG(rating), COUNT(rating) FROM Review WHERE mid = $id GROUP BY mid", $db_connection);
        if(!$rs){
            echo "Query failed: " . mysql_error();
            exit(1);
        }

        $row = mysql_fetch_row($rs);
        if($row){
          $avg = $row[0];
          $count = $row[1];
          echo "<div class='row'><div class='col-sm-offset-2 col-sm-10'>Average score for this movie is $avg based on $count people's reviews</div></div>";
        }

        mysql_close($db_connection);
      ?>
      <div class="row"><div class="col-sm-offset-2 col-sm-10"><b><a href='addReview.php?movie=<?php echo $id;?>'>Leave Your Review</a></b></div></div>
    </div>

    <?php
      if($row){
        echo "<div class='container' style='padding-top:20px'>";
        echo "<div class='row'><div class='col-sm-offset-2 col-sm-10'><h4><b>Comments Below:</b></h4></div></div>";

        $db_connection = mysql_connect("localhost", "cs143", "");
        if(!$db_connection){
          $errmsg = mysql_error($db_connection);
          echo "Connection failed: $errmsg";
          exit(1);
        }

        mysql_select_db("CS143", $db_connection);

        $rs = mysql_query("SELECT name, time, rating, comment FROM Review WHERE mid = $id", $db_connection);
        if(!$rs){
            echo "Query failed: " . mysql_error();
            exit(1);
        }

        while($detail = mysql_fetch_row($rs)){
          $name = $detail[0];
          $time = $detail[1];
          $rating = $detail[2];
          $comment = $detail[3];
          echo "<div class='row'><div class='col-sm-offset-2 col-sm-10'><b style='color:red'>$name</b> rates this movie with score <b style='color:blue'>$rating</b> and left a review at $time</div></div>";
          echo "<div class='row'><div class='col-sm-offset-2 col-sm-10'>comment: $comment</div></div>";
        }

        echo "</div>";
      }
    ?>

    <div class="container" style="padding-top:50px"></div>
  </body>
</html>
