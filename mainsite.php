<?php
  include "phpscript.php";
  include "header.php";
?>
  
    <article class="main">
    <?php while ( $dateMovie = mysqli_fetch_array($dateMovieResult, MYSQLI_ASSOC)) { $curMovie = $dateMovie['MovieID']; ?>
      <section class="main">  
      <img class="movie" src="images/<?php echo getPoster($curMovie)["FileName"]; ?>" alt="<?php echo getPoster($curMovie)['AltText']; ?>">

          <h3 class="title"><?php echo getMovie($curMovie)['Title']; ?></h3>
          <p class="movieText">Speltid: <?php echo getMovie($curMovie)["Length"]; ?> min</p>
          <p class="movieText">Pris: <?php echo getMovie($curMovie)["Price"]; ?> kr</p>
          <h4 class="movieText">Handling</h4>
          <p class="movieText"><?php echo getMovie($curMovie)["Description"]; ?></p>
          <br>
          <br>
          <?php foreach (getGenre($curMovie) as $i) { echo $i; }; ?>

          <br>
          <button class="btnTicket" value="<?php echo $curMovie; ?>">Köp biljett</button>
      </section>
    <?php } ?>
    </article>
    
    <aside>
      <div id="userForm">
        <h3 class="asideText">Välkommen <?php if ($_SESSION == null) { echo " till Biografen!";} else { echo $_SESSION['username'], "!"; }?></h3>
        <p class="asideText"><?php if ($_SESSION == null) { echo "Vill du köpa en biljett till någon av filmerna måste du vara inloggad."; } else { ?></p>
        <p class="asideText"><?php echo "Du har besök biografen:"; ?>
          <?php } ?>
        <?php if ($_SESSION != null) { ?>
          <h4 class="title">Dina uppgifter</h4>
          <p class="asideTextSmall">Stämmer inte dina uppgifter kan du uppdatera detta direkt.</p>
          <p class="asideTextHead">Kundnummer:</p>
          <p class="asideText"><?php echo $_SESSION['customerID']; ?></p>

          <!--Visar användarens angivna e-postadress-->
          <div id="displayEmail">
            <p class="asideTextHead">E-postadress: <button id="btnEditEmail" onclick="updateEmail()"><i class='far fa-edit'></i></button></p>
            <p id="showEmail" class="asideText"><?php echo $_SESSION['email']; ?></p>
          </div>

          <div id="divUpdateEmail">
            <input type="email" name="username" required autofocus>
          </div>

          <p class="asideTextHead">Telefonnummer: <button><i class='far fa-edit'></i></button></p>
          <p id="showPhone" class="asideText"><?php echo $_SESSION['phone']; ?></p>
            
          <button class="btnsignOut" onclick="window.location.href = 'logout.php'">Logga ut</button>
          <?php } else { ?>
            <button id="logIn" class="btnMain" onclick="window.location.href = 'loginForm.php'">Logga in</button>
            <button id="signUp" class="btnMain" onclick="window.location.href = 'registerForm.php'">Registrera dig</button>
            <?php } ?>
      </div>
    </aside>
    <script>
      //Tanken var att detta skulle visa en input 
      function updateEmail() {
        var show = document.getElementByID("displayEmail");
        var change = document.getElementByID("divUpdateEmail");

        show.style.display = (show.style.display == "none");
        change.style.display = (change.style.display =="block");
      }
    </script>
    <?php include "footer.php" ?>