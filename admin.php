<?php include "phpAdmin.php"; ?>
<!DOCTYPE html>
<html lang="sv">
<head>
  <meta charset="utf-8">
  <title>Admin Biografen</title>
  <link rel="stylesheet" type="text/css" href="adminStyle.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script><!--Används för autocomplete-->
  <script src="json-datalist.js"></script>

  <!--Load the AJAX API-->
  <script src="https://www.gstatic.com/charts/loader.js"></script>
  
  <!--Diagram för antal besök per vecka-->
  <script>
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {
      //Skapar JS varibler från PHP varibler med datum
      var phpOne = "<?php echo $daysOne; ?>";
      var phpTwo = "<?php echo $daysTwo; ?>";
      var phpThree = "<?php echo $daysThree; ?>";
      var phpFour = "<?php echo $daysFour; ?>";
      var phpFive = "<?php echo $daysFive; ?>";
      var phpSix = "<?php echo $daysSix; ?>";
      var phpSeven = "<?php echo $daysSeven; ?>";

      // Create the data table.
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'datum');
      data.addColumn('number', 'Besök');
      data.addRows([
        [phpSeven, <?php echo getVisits($daysSeven); ?>],
        [phpSix, <?php echo getVisits($daysSix); ?>],
        [phpFive, <?php echo getVisits($daysFive); ?>],
        [phpFour, <?php echo getVisits($daysFour); ?>],
        [phpThree, <?php echo getVisits($daysThree); ?>],
        [phpTwo, <?php echo getVisits($daysTwo); ?>],
        [phpOne, <?php echo getVisits($daysOne); ?>]
      ]);

      // Set chart options
      var options = {'title':'Antal besökare per dag senaste sju dagarna',
                     'width':700,
                     'height':300};

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.ColumnChart(document.getElementById('chartVisits'));
      chart.draw(data, options);
    }
  </script>
</head>
<body>
  <div id="wrapper">
  <header>
    <h1>Biografen</h1>
    <h3>Administratör</h3>
    <nav>
      <ul>
        <li><a href="#">Lägg till ny film</a></li>
        <li><a href="#">Hantera filmer</a></li>
        <li><a href="#">Statistik</a></li>
        <li class="signOut"><a href="index.php">Logga ut</a></li>
      </ul>
    </nav>
  </header>
  <article>
    <h3 class="welcome">Ha en underbar dag!</h3>
    <section>
      <?php //echo $test ?>
      <?php echo $daysSeven; ?>
      <div id="chartVisits"></div>
    </section>
    
    <section>
      <h4>Kundstatistik</h4>
      <p>Sök efter kund du vill se antal besökstillfällen för:</p>
      <div>
        
      <input type="text" id="ajax" list="json-datalist" placeholder="e.g. datalist">
      <datalist id="json-datalist"></datalist>
      
      <!--<div id="chartUsers"></div>-->
      <?php //echo userVisits(3); ?>
    </section>
    
    <section>
      <h3>Lägg till ny film</h3>
      <p>Här lägger du till titlar vi inte visat tidigare.</p>
      <?php echo $addMsg; ?>
      <form method="POST">
        <label for="title">Ange filmens titel här:</label><br>
        <input class="inpAddUser" type="text" id="title" name="title"><br>
        <label for="length">Ange hur många minuter filmen är här:</label><br>
        <input class="inpAddUser" type="number" id="length" name="length"><br>
        <label for="description">Beskriv filmens handling här:</label><br>
        <textarea type="text" id="description" name="description" rows="5" cols="45"></textarea><br>
        <label for="price">Ange hur mycket biljetten ska kosta:</label><br>
        <input class="inpAddUser" type="number" id="price" name="price"><br>
        <input class="btnUpload" name="addMovie" type="submit" value="Lägg till">
      </form>
    </section>
    <section>
      <h3>Schemalägg visningar</h3>
      <p>Här hanterar du när filmer ska visas.</p>
      <?php echo $airError; ?>
      <form method="POST">
        <label for ="airMovie">Välj i listan vilken titel du vill hantera:</label><br>
        <select class="inpAddUser" name="airMovie">
          <?php while($movies = mysqli_fetch_array($dataMoviesResult)) { ?>
            <option value="<?php echo $movies['MovieID']; ?>"><?php echo $movies['Title']; ?></option>
          <?php } ?>
        </select><br>
        <label for="airDate">Vilket datum ska titeln ska visas?</label><br>
        <input class="inpAddUser" type="date" name="airDate"><br>
        <label for="airTime">Vilken tid ska titeln visas?</label><br>
        <input class="inpAddUser" type="time" name="airTime" step="1"><br>
        <input class="btnUpload" name="pubMovie" type="submit" value="Schemalägg">
      </form>
    </section>
    <section>
      <!--Eget formulär för att ladda upp filer.. som jag skiter i nu-->
      <h4>Ladda upp poster till en film</h4>
      <form>
        <label>Filnamn</label>
      </form>
      <form action="upload.php" method="POST" enctype="multipart/form-data">     
        <input type="file" name="fileToUpload" id="fileToUpload"><br>
        <input class="btnUpload" type="submit" value="Ladda upp poster" name="submit">
      </form>
      
      
    </section>

   <!-- Kopierat rakt av från w3schools men jag kan ändå inte ladda upp bilder så jag skiter i det..
     <form action="upload.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form> -->
    
  </article>
  
</div>

</body>
</html>