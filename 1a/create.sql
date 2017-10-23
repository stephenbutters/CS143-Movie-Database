/*Movie id should always be unique primary key*/
CREATE TABLE Movie(
      id INT,
      title VARCHAR(100),
      year INT,
      rating VARCHAR(10),
      company VARCHAR(50),
      PRIMARY KEY(id));

/*Actor id should always be unique primary key*/
/*sex is either Male or Female*/
/*Actor must have a dob*/
CREATE TABLE Actor(
      id INT,
      last VARCHAR(20),
      first VARCHAR(20),
      sex VARCHAR(6),
      dob DATE,
      dod DATE,
      PRIMARY KEY(id),
      CHECK(sex = 'Male' OR sex = 'Female'),
      CHECK(dob != ''));

/*mid should reference movie id from Movie table*/
CREATE TABLE Sales(
      mid INT,
      ticketsSold INT,
      totalIncome INT,
      FOREIGN KEY(mid) REFERENCES Movie(id)) ENGINE=INNODB;

/*Director id should always be unique primary key*/
/*Director must have a dob*/
CREATE TABLE Director(
      id INT,
      last VARCHAR(20),
      first VARCHAR(20),
      dob DATE,
      dod DATE,
      PRIMARY KEY(id),
      CHECK(dob != ''));

/*mid should reference movie id from Movie table*/
CREATE TABLE MovieGenre(
      mid INT,
      genre VARCHAR(20),
      FOREIGN KEY(mid) REFERENCES Movie(id)) ENGINE=INNODB;

/*mid should reference movie id from Movie table, did should reference director id from Director table*/
CREATE TABLE MovieDirector(
      mid INT,
      did INT,
      FOREIGN KEY(mid) REFERENCES Movie(id),
      FOREIGN KEY(did) REFERENCES Director(id)) ENGINE=INNODB;

/*mid should reference movie id from Movie table, aid should reference actor id from Actor table*/
CREATE TABLE MovieActor(
      mid INT,
      aid INT,
      role VARCHAR(50),
      FOREIGN KEY(mid) REFERENCES Movie(id),
      FOREIGN KEY(aid) REFERENCES Actor(id)) ENGINE=INNODB;

/*mid should reference movie id from Movie table*/
/*both imdb and rot score must be between 0 to 100*/
CREATE TABLE MovieRating(
      mid INT,
      imdb INT,
      rot INT,
      FOREIGN KEY(mid) REFERENCES Movie(id),
      CHECK(imdb >= 0 AND imdb <= 100),
      CHECK(rot >= 0 AND rot <= 100)) ENGINE=INNODB;

/*mid should reference movie id from Movie table*/
/*rating must be between 0 to 100*/
CREATE TABLE Review(
      name VARCHAR(20),
      time TIMESTAMP,
      mid INT,
      rating INT,
      comment VARCHAR(500),
      FOREIGN KEY(mid) REFERENCES Movie(id),
      CHECK(rating >= 0 AND rating <= 100)) ENGINE=INNODB;

CREATE TABLE MaxPersonID(id INT);
CREATE TABLE MaxMovieID(id INT);
