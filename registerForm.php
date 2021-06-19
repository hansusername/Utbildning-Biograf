<?php 
  include "phpscript.php";
  include "header.php";
?>
<article class="login">
  <section id="userArea" class="login">
  <form method="POST">
    <h4>Registrera dig som kund här!</h4>
    <p class="signUpForm">Förnamn:</p><input type="text" name="fName" required><br>
    <p class="signUpForm">Efternamn:</p><input type="text" name="lName" required><br>
    <p class="signUpForm">Personnummer: (12 siffror)</p><input type="number" name="bDate" required><br>
    <p class="signUpForm">Mobilnnummer: (10 siffror)</p><input type="text" name="phoneNumber"><br>
    <p class="signUpForm">E-postadress:</p><input type="email" name="email" required><br>
    <p class="signUpForm">Lösenord:</p><input type="password" name="Password" required><br>
    <p class="signUpForm">Repetera lösenord:</p><input type="password" name="PasswordConf" required><br>
    <input name="btnSignup" type="submit" value="Bli medlem!">
    <?php 
      if (count($errorCheck) > 0)
      {
        foreach ($errorCheck as $errormsg)
        {
          echo "<br>", $errormsg;
        }
      }
    ?>
  </form>
  </section> 
    <img class="login" src="images/filmrulle.jpg" alt="Två filmrullar som ligger på ett blankt underlag">
    <button class="btnNoLogIn" onclick="window.location.href = 'mainsite.php'">Bläddra bland våra filmer utan att logga in!</button>  
</article>
<?php include "footer.php";?>
