<?php 
  include "phpscript.php";
  include "header.php";
?>
<article class="login">
  <section id="userArea" class="login">
  <h2>Välkommen till Biografen!</h2>
    <p>Vi är en liten familjeägd biograf som har varit verksam i generationer. Eftersom vi är ett familjeföretag tycker vi att familjen är det viktigaste som finns. Här visar vi de senaste filmpremiärerna och gamla klassiker.</p>
    <p>Alla är självklart välkomna, inte bara barnfamiljer. Vi visar även andra filmer på senare tider, håll utkik på vår hemsida!</p>
    <p>För att kunna köpa biljetter på våran hemsida behöver du vara inloggad, är det första gången du besöker oss regitrerar du dig nedan.</p>

    <button id="logIn" class="btnLogInScreen" onclick="window.location.href = 'loginForm.php'">Logga in</button>
    <button id="signUp" class="btnLogInScreen" onclick="window.location.href = 'registerForm.php'">Registrera dig</button>
  </section> 
    <img class="login" src="images/filmrulle.jpg" alt="Två filmrullar som ligger på ett blankt underlag">
    <button class="btnNoLogIn" onclick="window.location.href = 'mainsite.php'">Bläddra bland våra filmer utan att logga in!</button>  

</article>
<?php include "footer.php"?>

