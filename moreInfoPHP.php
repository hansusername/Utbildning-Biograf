<?php
  //Mer information om film
  $movieID = $_GET['ID'];
  //$movieID = "";
  $infoMovieSQL = "SELECT movies.Title, movies.Length, movies.Description, movies.Price, posters.FileName, posters.AltText FROM movies, posters, movieartconnect WHERE movies.MovieID = movieartconnect.MovieID AND posters.PosterID = movieartconnect.PosterID AND movies.MovieID = '$movieID' ";
  $infoMovieResult = mysqli_query($loginMySQL, $infoMovieSQL);
  $infoMovie = "";
  while ($infoMovie = mysqli_fetch_array($infoMovieResult))
  {
    $mTitle = $infoMovie['Title'];
    $mLength = $infoMovie['Length'];
    $mPrice = $infoMovie['Price'];
  }
?>