<?php 
  include "phpscript.php";
  include "header.php";
?>
<article class="login">
  <section id="userArea" class="login">
    <form id="loginUser" method="POST">
      <h4>Logga in här!</h4>
      <p class="input"><?php echo $msg;?></p>
      <p class="input">E-postadress: </p><input type="email" name="username" required autofocus>
      <p class="input">Lösenord:</p><input type="password" name="password" required><br>
      <input name="btnLogin" type="submit" value="Jag vill in!">
    </form>
  </section> 
    <img class="login" src="images/filmrulle.jpg" alt="Två filmrullar som ligger på ett blankt underlag">
    <button class="btnNoLogIn" onclick="window.location.href = 'mainsite.php'">Bläddra bland våra filmer utan att logga in!</button>  
</article>
<?php include "footer.php";?>