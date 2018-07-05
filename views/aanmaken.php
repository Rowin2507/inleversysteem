<?php
if(isset($_SESSION['gebruikersnaam'])) {
  header("Location: ../home");
}



  //AANMAKEN PROCES
  if (isset($_POST['submit']) && isset($_POST['g-recaptcha-response'])){
    $mailadres = $_GET["mailadres"];
    $hashcode = $_GET["hashcode"];


    //RECPATCHA PROCES
    $captcha=$_POST['g-recaptcha-response'];

    if(!$captcha){
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      $_SESSION['recaptcha_error_msg'] = "Recaptcha niet aangevinkt";
      unset($_SESSION["login_error_msg"]);
    }
    $secretKey = "6LfGrTgUAAAAAMI5_V7LCqaquVwDdpNEUMFXKS2V";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
    $responseKeys = json_decode($response,true);
    if(intval($responseKeys["success"]) !== 1) {
      echo '<h2>Jij bent een spammer!!</h2>';
    } else {

      //INLOGGEN PROCES
      $get_status = "SELECT status FROM docenten WHERE mailadres='$mailadres' UNION SELECT status FROM leerlingen WHERE mailadres='$mailadres'";
      $result_status = mysqli_query($dbc, $get_status);
      $row = mysqli_fetch_array($result_status);
      $status = $row['status'];

      if ($status == 2) {
        $query = "SELECT * FROM docenten WHERE mailadres='$mailadres' AND hashcode='$hashcode'";
        $result = mysqli_query($dbc,$query) or die ("Fout! Query is mislukt");

        $wachtwoord = mysqli_real_escape_string($dbc,htmlentities($_POST['password']));
        $hashed_wachtwoord = hash('sha512', $wachtwoord);

        $wachtwoordQuery = "UPDATE docenten SET wachtwoord = '$hashed_wachtwoord' WHERE mailadres='$mailadres' AND hashcode='$hashcode'";
        $wachtwoordResult = mysqli_query($dbc,$wachtwoordQuery) or die ("Er is een four opgetreden tijdens het invoegen.");
      } else {
        $query = "SELECT * FROM leerlingen WHERE mailadres='$mailadres' AND hashcode='$hashcode'";
        $result = mysqli_query($dbc,$query) or die ("Fout! Query is mislukt");

        $wachtwoord = mysqli_real_escape_string($dbc,htmlentities($_POST['password']));
        $hashed_wachtwoord = hash('sha512', $wachtwoord);

        $wachtwoordQuery = "UPDATE leerlingen SET wachtwoord = '$hashed_wachtwoord' WHERE mailadres='$mailadres' AND hashcode='$hashcode'";
        $wachtwoordResult = mysqli_query($dbc,$wachtwoordQuery) or die ("Er is een four opgetreden tijdens het invoegen.");

        $statusQuery = "UPDATE leerlingen SET status=1 WHERE mailadres='$mailadres' AND hashcode='$hashcode'";
        $statusResult = mysqli_query($dbc,$statusQuery) or die ('Er is een four opgetreden tijdens het invoegen.');
      }

      echo '
        <div class="melding-bg">
          <div class="melding-block">
            <img src="./assets/images/voltooid.png" />
            <p>Welkom, je account is nu aangemaakt.</p>
            <a style="color: #e62686;" href="./home">Klik hier om in te loggen.</a>
          </div>
        </div>';

    }


  } else {

    if(isset($_SESSION['recaptcha_error_msg'])) {echo '<div class="login-error">Recaptcha was niet aangevinkt</div>';}
    echo '
      <div class="background-image">
        <div class="inloggen-content">
          <div class="inloggen-logo">
            <img src="./assets/images/logo-ma.png" id="login-logo" alt="logo"/>
            <span class="login-logo-text"><h2>STEL IN</h2></span>
          </div>
          <div class="inloggen-form">
            <form method="post">
              <p><span class="item"><i class="fa fa-key" aria-hidden="true"></i></span><input type="password" name="password" id="password" placeholder="Wachtwoord" autocomplete="off" required/></p>
              <p><span class="item"><i class="fa fa-key" aria-hidden="true"></i></span><input type="password" name="password" id="password-herhalen" placeholder="Wachtwoord herhalen" autocomplete="off" required/></p>
              <div class="g-recaptcha" data-sitekey="6LfGrTgUAAAAAA8_X3PIj6WVZJ4Zz9PfAN2ol10q"></div>
              <p><input type="submit" name="submit" id="aanmaken" value="&#xf1d9; Aanmaken"/></p>
              <a href="./inloggen" class="link-inloggen">Terug naar inloggen.</a>
            </form>
          </div>
        </div>
      </div>';
  }





?>
