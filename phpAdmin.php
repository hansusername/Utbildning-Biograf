<?php
  //Loggar in på databasen.
  $loginMySQL = mysqli_connect("localhost", "HansKristoff", "hanskris112", "biografen");
  if (mysqli_connect_errno())
  {
    echo "Något gick fel: " . mysqli_connect_error();
  }

  //Deklarerar variabler
  $errorCheck = array(); //Vektor för felhantering

  //Meddelande för att se om det fungerar.
  $addMsg = "Inte körd";

  $title = "";
  $length = "";
  $description = "";
  $price = "";

  //Variabel för loop
  $movies = "";
  
  //Hämtar data från databas
  $dataMoviesSQL = "SELECT * FROM movies";
  $dataMoviesResult = mysqli_query($loginMySQL, $dataMoviesSQL);
  $dataMoviesRows = mysqli_fetch_array($dataMoviesResult, MYSQLI_ASSOC);

  //Funktionalitet lägg till titel/film
  if (isset($_POST['addMovie']))
  {
    //Städar strängar
    $title = mysqli_escape_string($loginMySQL, $_POST['title']);
    $length = mysqli_escape_string($loginMySQL, $_POST['length']);
    $description = mysqli_escape_string($loginMySQL, $_POST['description']);
    $price = mysqli_escape_string($loginMySQL, $_POST['price']);
    
    if ($title != NULL && $length != NULL && $description != NULL && $price != NULL)
    {
      //Söker databasen för dubbletter
      if ($dataMoviesRows['Title'] === $title)
      {
        array_push($errorCheck, "Filmen finns redan i systemet");
      }
      //Kör koden om inga fel är funnen
      if (count($errorCheck) == 0)
      {
        $addMovieSQL = "INSERT INTO `movies` (`MovieID`, `Title`, `Length`, `Description`, `Price`) VALUES (NULL, '$title', '$length', '$description', '$price')";
        mysqli_query($loginMySQL, $addMovieSQL);
        $addMsg = "Klart och betalt!";
      }
    }
    else
    {
      $addMsg = "Du måste fylla i alla fält";
    }
  }

  //Funktionalitet schemalägg visningar
  $airError = "";
  if (isset($_POST['pubMovie']))
  {
    $airMovie = mysqli_escape_string($loginMySQL, $_POST['airMovie']);
    $airDate = mysqli_escape_string($loginMySQL, $_POST['airDate']);
    $airTime = mysqli_escape_string($loginMySQL, $_POST['airTime']);
    
    if ($airMovie != NULL && $airDate != NULL && $airTime != NULL)
    {
      $addAirTimeSQL = "INSERT INTO `airtime` (`AirTimeID`, `Date`, `Time`, `MovieID`) VALUES (NULL, '$airDate', '$airTime', '$airMovie')";
      mysqli_query($loginMySQL, $addAirTimeSQL);
      header("location:" . $_SERVER['PHP_SELF']);
      exit();
    } else {
      $airError = "Du måste fylla i alla fält!";
    }
  }
  
  //Lägg till visning av filmer
  $infoMovieSQL = "SELECT MovieID FROM `Movies` ";
  $infoMovieResult = mysqli_query($loginMySQL, $infoMovieSQL);
  $infoMovieRows = mysqli_fetch_array($infoMovieResult, MYSQLI_ASSOC);

  //Statiskit besökare
  //Datum för senaste sju dagarna
  $daysOne = date('Y-m-d', strtotime("-1days"));
  $daysTwo = date('Y-m-d', strtotime("-2days"));
  $daysThree = date('Y-m-d', strtotime("-3days"));
  $daysFour = date('Y-m-d', strtotime("-4days"));
  $daysFive = date('Y-m-d', strtotime("-5days"));
  $daysSix = date('Y-m-d', strtotime("-6days"));
  $daysSeven = date('Y-m-d', strtotime("-7 days"));

  
  //Funktion med SQL för att räkna besök på givet datum
  function getVisits($date)
  {
    $loginMySQL = mysqli_connect("localhost", "HansKristoff", "hanskris112", "biografen");
  if (mysqli_connect_errno())
  {
    echo "Något gick fel: " . mysqli_connect_error();
  }
    $runDate = $date . "%";
    $countVisitsSQL = "SELECT COUNT(TicketID) AS AntalBesök FROM `tickets` WHERE BuyDate LIKE '$runDate' ";
    $countVisitsResult = mysqli_query($loginMySQL, $countVisitsSQL);
    $countVisitsRows = mysqli_fetch_array($countVisitsResult, MYSQLI_ASSOC);

    return $countVisitsRows['AntalBesök'];
  }
  
  //Funktion med SQL för specifik kund
  $GLOBALS['loginMySQL'] = mysqli_connect("localhost", "HansKristoff", "hanskris112", "biografen");
  if (mysqli_connect_errno())
  {
    echo "Något gick fel: " . mysqli_connect_error();
  }
  //Totalt antal besök per kund
  function userVisits($user)
  {
    $userVisitsSQL = "SELECT COUNT(CustomerID) AS AntalBesök FROM `tickets` WHERE CustomerID = $user";
    $userVisitsResult = mysqli_query($GLOBALS['loginMySQL'], $userVisitsSQL);
    $userVisitsRows = mysqli_fetch_array($userVisitsResult, MYSQLI_ASSOC);

    return $userVisitsRows['AntalBesök'];
  }

  //Antal och datum för besök specifik kund
  function statsUser($user)
  {
    $statsUserSQL = "SELECT BuyDate FROM `tickets` WHERE CustomerID = $user";
    $statsUserResult = mysqli_query($GLOBALS['loginMySQL'], $statsUserSQL);
    $statsUserRows = mysqli_fetch_array($statsUserResult, MYSQLI_ASSOC);
    //Avslutad tanke pga tidsbrist
    return array ($statsUserRows['BuyDate']);
  } 

  //Hämtar och skriver till json fil, finns den inte skapas den
  $findUserSQL = "SELECT FirstName FROM `customers` ";
  $findUserResult = mysqli_query($loginMySQL, $findUserSQL);
  $findUserRows = "";
  $jsonData = array();

  if (mysqli_num_rows($findUserResult))
  {
    while ($findUserRows = mysqli_fetch_row($findUserResult))
    {
      $jsonData['Customers'][] = $findUserRows;
    }
  }
  $writeJSON = fopen('customers.json', 'w');
  fwrite($writeJSON, json_encode($jsonData));
  fclose($writeJSON);
?>