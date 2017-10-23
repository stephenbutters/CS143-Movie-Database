/*Cannot delete movie id because MovieActor table needs to reference Movie.id*/
DELETE FROM Movie WHERE id < 20;
/*Query failed: Cannot delete or update a parent row: a foreign key constraint fails (`CS143`.`Sales`, CONSTRAINT `Sales_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))*/

/*Cannot delete actor id because MovieActor table needs to reference Actor.id*/
DELETE FROM Actor WHERE id < 20;
/*Query failed: Cannot delete or update a parent row: a foreign key constraint fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`))*/

/*Cannot delete director id because MovieDirector table needs to reference Director.id*/
DELETE FROM Director WHERE id < 200;
/*Query failed: Cannot delete or update a parent row: a foreign key constraint fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_2` FOREIGN KEY (`did`) REFERENCES `Director` (`id`))*/

/*Cannot insert because id=1 does not exist from Movie table*/
INSERT INTO Sales(mid) VALUES(1);
/*Query failed: Cannot add or update a child row: a foreign key constraint fails (`CS143`.`Sales`, CONSTRAINT `Sales_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))*/

/*Cannot insert because id=1 does not exist from Movie table*/
INSERT INTO MovieGenre(mid) VALUES(1);
/*Query failed: Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))*/

/*Cannot insert because id=1 does not exist from Director table*/
INSERT INTO MovieDirector(did) VALUES(1);
/*Query failed: Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_2` FOREIGN KEY (`did`) REFERENCES `Director` (`id`))*/

/*Cannot insert because id=2 does not exist from Actor table*/
INSERT INTO MovieActor(aid) VALUES(2);
/*Query failed: Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`))*/

/*Cannot insert because id=1 does not exist from Movie table*/
INSERT INTO MovieRating(mid) VALUES(1);
/*Query failed: Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieRating`, CONSTRAINT `MovieRating_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))*/

/*Cannot insert because id=1 does not exist from Movie table*/
INSERT INTO Review(mid) VALUES(1);
/*Query failed: Cannot add or update a child row: a foreign key constraint fails (`CS143`.`Review`, CONSTRAINT `Review_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))*/

/*Cannot update because sex must be either male or female in Actor table*/
UPDATE Actor SET sex = 'else' WHERE id = 10;

/*Cannot update because dob must be specified*/
UPDATE Director SET dob = '' WHERE id = 104;

/*Cannot update because rating must be between 0 to 100*/
UPDATE MovieRating SET imdb = 200 WHERE mid = 272;
