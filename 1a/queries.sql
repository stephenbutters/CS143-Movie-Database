/*Names of all the actors in the movie 'Die Another Day'*/
SELECT DISTINCT CONCAT(Actor.first, ' ', Actor.last)
FROM Movie, Actor, MovieActor
WHERE MovieActor.mid = Movie.id AND MovieActor.aid = Actor.id AND Movie.title = 'Die Another Day';

/*Count of all the actors who acted in multiple movies*/
SELECT COUNT(a.aid) FROM
(SELECT aid FROM MovieActor GROUP BY aid HAVING COUNT(mid) > 1) a;

/*Title of movies that sell more than 1000000 tickets*/
SELECT DISTINCT Movie.title
FROM Movie, Sales
WHERE Movie.id = Sales.mid AND Sales.ticketsSold > 1000000;

/*Count of all directors who directed movies which sell more than 1100000 tickets*/
SELECT COUNT(a.id) FROM 
(SELECT DISTINCT D.id
FROM Director D, Sales S, MovieDirector M
WHERE D.id = M.did AND S.mid = M.mid AND S.ticketsSold > 1100000) a;

/*Titles of movies that have above 93 rating on both imdb and rotten tomatoes*/
SELECT DISTINCT Movie.title
FROM Movie, MovieRating
WHERE Movie.id  = MovieRating.mid AND MovieRating.imdb > 93 AND MovieRating.rot > 93;
