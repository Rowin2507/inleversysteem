<?php
if(isset($_SESSION['gebruikersnaam'])) {
  header("Location: ../home");
} else if(isset($_SESSION['recaptcha_error_msg'])) {
  echo '<div class="login-error">Recaptcha was niet aangevinkt</div>';
}
?>

<div class="background-image">
  <div class="inloggen-content">
    <div class="inloggen-logo">
      <img src="./assets/images/logo-ma.png" id="login-logo" alt="logo" />
      <span class="login-logo-text"><h2>STEL IN</h2></span>
    </div>
    <div class="inloggen-form">
      <form method="post" action="./bevestiging">
        <p><span class="item"><i class="fa fa-user-o" aria-hidden="true"></i></span><input type="text" name="username" id="username" language="language" placeholder="Gebruikersnaam" autocomplete="off" required/></p>
        <p><span class="item"><i class="fa fa-envelope-o" aria-hidden="true"></i></span><span id="email"><span id="output">Mailadres</span>@ma-web.nl</span></p>
        <div class="g-recaptcha" data-sitekey="6LfGrTgUAAAAAA8_X3PIj6WVZJ4Zz9PfAN2ol10q"></div>
        <p><input type="submit" name="submit" id="verzenden" value="&#xf1d9; Verzenden"/></p>
        <a href="./inloggen" class="link-inloggen">Terug naar inloggen.</a>
      </form>
    </div>
  </div>
</div>
