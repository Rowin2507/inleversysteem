<?php
if(isset($_SESSION['gebruikersnaam'])) {
  header("Location: ../home");
} else if(isset($_SESSION['login_error_msg'])) {
  echo '<div class="login-error">Gebruikersnaam en/ of wachtwoord onjuist</div>';
} else if(isset($_SESSION['recaptcha_error_msg'])) {
  echo '<div class="login-error">Recaptcha was niet aangevinkt</div>';
}
?>


<div class="background-image">
  <div class="inloggen-content">
    <div class="inloggen-logo">
      <img src="./assets/images/logo-ma.png" id="login-logo" alt="logo"/>
      <span class="login-logo-text"><h2>LOG IN</h2></span>
    </div>
    <div class="inloggen-form">
      <form method="post" action="./model/inloggen.php">
        <p><span class="item"><i class="fa fa-user-o" aria-hidden="true"></i></span><input type="text" name="username" id="username" placeholder="Gebruikersnaam" autocomplete="off" required/></p>
        <p><span class="item"><i class="fa fa-key" aria-hidden="true"></i></span><input type="password" name="password" id="password" placeholder="Wachtwoord" autocomplete="off" required/></p>
        <div class="g-recaptcha" data-sitekey="6LfGrTgUAAAAAA8_X3PIj6WVZJ4Zz9PfAN2ol10q"></div>
        <p><input type="submit" name="submit" id="inloggen" value="&#xf1d9; Log in"/></p>
        <a href="./instellen" class="link-instellen">Account activeren/ herstellen.</a>
      </form>
    </div>
  </div>
</div>
