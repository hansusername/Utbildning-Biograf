<?php
  //Loggar in på databasen som jag skapat för hemsidan.
  $loginMySQL = mysqli_connect("localhost", "kundBio", "kundLösen", "biografen");
  if (mysqli_connect_errno())
  {
    echo "Något gick fel: " . mysqli_connect_error();
  }

  //Hämtar MovieID från airtime.
  $dateMovieSQL = "SELECT MovieID FROM airtime WHERE Date >= CURRENT_DATE";
  $dateMovieResult = mysqli_query($loginMySQL, $dateMovieSQL);
  $dateMovie = ""; 
  
  //Funktion för att hämta information om film.
  function getMovie($curMovie)
  {
    $getMovieSQL = "SELECT * FROM movies WHERE MovieID = $curMovie";
    $getMovieResult = mysqli_query($GLOBALS['loginMySQL'], $getMovieSQL);
    $getMovie = mysqli_fetch_array($getMovieResult, MYSQLI_ASSOC);

    $curTitle = $getMovie['Title'];
    $curLength = $getMovie['Length'];
    $curDescription = $getMovie['Description'];
    $curPrice = $getMovie['Price'];

    $return_arr = array("Title" => $curTitle, "Length" => $curLength, "Description" => $curDescription, "Price" => $curPrice);
    return $return_arr;
  }

  //Funktion för att hämta information om poster/bild.
  function getPoster($curMovie)
  {
    $getPosterSQL = "SELECT FileName, AltText FROM posters, movieartconnect WHERE movieartconnect.PosterID = posters.PosterID AND MovieID = $curMovie";
    $getPosterResult = mysqli_query($GLOBALS['loginMySQL'], $getPosterSQL);
    $getPoster = mysqli_fetch_assoc($getPosterResult);

    $curFileName = $getPoster['FileName'];
    $curAltText = $getPoster['AltText'];

    $return_arr = array("FileName" => $curFileName, "AltText" => $curAltText); 
    return $return_arr;
  }

  //Funktion för att hämta information om genre.
  //Jag har stress och kommer inte på hur jag ska kunna loopa och få ut alla genres.
  function getGenre($curMovie)//Skriver endast ut första Genren i arrayen.
  {
    $curGenre = array();

    $getGenreSQL = "SELECT Genre FROM genres, genreconnect WHERE genres.GenreID = genreconnect.GenreID AND MovieID = $curMovie";
    $getGenreResult = mysqli_query($GLOBALS['loginMySQL'], $getGenreSQL);
    $getGenre = mysqli_fetch_assoc($getGenreResult);

    $curGenre[] = $getGenre['Genre'];
    /*foreach ($getGenre as $i)
    {
      $curGenre[] = $i;
    }*/

    return $curGenre;
  }

  //Kod för inloggning.
  session_start();
  //Skapar alla variabler utan innehåll.
  $msg = "";
  
  $logInSQL  ="";
  $logInResult = "";

  //Funktionalitet inloggning

  if (isset($_POST['btnLogin']))
  {
    //Städar strängar
    $username = mysqli_escape_string($loginMySQL, $_POST['username']);
    $password = mysqli_escape_string($loginMySQL, $_POST['password']);
    //Hash
    $password = md5($password);
    $adminUser = md5($_POST['username']);
    //Skapar och kör SQl fråga
    $logInSQL = "SELECT * FROM customers WHERE Email = '$username' AND Password = '$password' ";
    $logInResult = mysqli_query($loginMySQL, $logInSQL);
    $logIn = mysqli_fetch_array($logInResult, MYSQLI_ASSOC);
    
    //echo $login['CustomerID'];
    //echo $login['FirstName'];

    //Admin inloggningsuppgifter
    //Jag sparar inte detta i databasen då denna kan bli hackad. 
    //adminUser = admin@admin.admin
    //password = AdminLoggain 
    if ($adminUser == "839531d0faa3e6efb8d874dd74a8e530" && $password == "e89849598c0eeb6309b2e46e495c4c52")
    {
      header("location: admin.php");
    }

    //Söker efter inmatad data i databas
    if ($username == $logIn['Email'] && $password == $logIn['Password'])
    {
      $_SESSION['username'] = $logIn['FirstName'] . " " . $logIn['LastName'];
      $_SESSION['email'] = $username;
      $custID = $logIn['CustomerID'];
      $_SESSION['customerID'] = $custID;
      $phone = $logIn['Phone'];
      $_SESSION['phone'] = $phone;

      $msg = "Välkommen till oss " . $_SESSION['username'];
      
      header("location: mainsite.php");
      exit();
    }
    else
    {
      $msg = "Fel användarnamn eller lösenord, försök igen!";
    }
  }

  //Registrering
  //Deklarerar variabler
  $errorCheck = array();
  $signUpSQL ="";
  $signUpResult = "";
  $sendSignUp = "";

  $username = "";
  $password = "";
  $fName = "";
  $lName = "";
  $bDate = "";
  $phoneNumber = "";
  $email = "";
  $Password = "";
  
  //Funktionalitet registrering
  if (isset($_POST['btnSignup']))
  {
    
    $fName = mysqli_escape_string($loginMySQL, $_POST['fName']);
    $lName = mysqli_escape_string($loginMySQL, $_POST['lName']);
    $bDate = mysqli_escape_string($loginMySQL, $_POST['bDate']);
    $phoneNumber = mysqli_escape_string($loginMySQL, $_POST['phoneNumber']);
    $email = mysqli_escape_string($loginMySQL, $_POST['email']);
    $Password = mysqli_escape_string($loginMySQL, $_POST['Password']);
    $PasswordConf = mysqli_escape_string($loginMySQL, $_POST['PasswordConf']);
    
    $signUpSQL = "SELECT * FROM customers WHERE Email = '$email' OR BirthDate = '$bDate'";
    $signUpResult = mysqli_query($loginMySQL, $signUpSQL);
    $signUp = mysqli_fetch_array($signUpResult, MYSQLI_ASSOC);

    //Måste vara rätt antal tecken i personnummer och telefonnummer
    if (strlen($bDate) == 12 && strlen($phoneNumber) == 10)
    {
      //Ser till att löseno och repetera lösen är lika
      if ($Password === $PasswordConf)
      {
        //Kollar om email redan finns i databas
        if ($signUp['Email'] === $email)
        {
          array_push($errorCheck, "E-postadressen finns redan registrerad hos oss.");
        }
        //Kollar om personnummer finns i databas
        if ($signUp['BirthDate'] === $bDate)
        {
          array_push($errorCheck, "Du är redan kund hos oss.");
        }
        //Är errorCheck tom skapas en rad i tabell
        if (count($errorCheck) == 0)
        {
          //Hash av lösenord innan de skrivs till databasen
          $Password = md5($Password);
          $sendSignUp = "INSERT INTO `customers` (`CustomerID`, `FirstName`, `LastName`, `BirthDate`, `Phone`, `Email`, `Password`) VALUES (NULL, '$fName', '$lName', '$bDate', '$phoneNumber', '$email', '$Password')";
          mysqli_query($loginMySQL, $sendSignUp);
          header("location = thanks.php");
          exit();
        }
      } 
      else
      {
        array_push($errorCheck, "Lösenorden matchar inte varandra.");
      }
    }
    else
    {
      array_push($errorCheck, "Personnummer eller telefonnummer har fel antal tecken.");
    }
  }

  //Uppdatera kunduppgifter
  //Deklarera variabler
  //Denna kod lämnade felmeddelanden när det inte var en användare inloggad, nu körs den bara om session inte saknar värde.
  if ($_SESSION != null)
  {
    $newEmail = "";
    
    $custID = $_SESSION['customerID'];

    //SQl för updatering
    $changeEmailSQL = "UPDATE `customers` SET `Email` = '$newEmail' WHERE `customers`.`CustomerID` = '$custID' ";
    
  }
  

  

?>