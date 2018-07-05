<?php

//RECPATCHA PROCES
if(isset($_POST['g-recaptcha-response'])){
  $captcha=$_POST['g-recaptcha-response'];
}
if(!$captcha){
  header("Location: ./instellen");
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

  //INSTELLEN PROCES
  if (isset($_POST['submit'])){

  $gebruikersnaam = mysqli_real_escape_string($dbc,htmlentities($_POST['username']));
  $check=mysqli_query($dbc,"SELECT gebruikersnaam FROM docenten WHERE gebruikersnaam='$gebruikersnaam'
                            UNION ALL
                            SELECT gebruikersnaam FROM leerlingen WHERE gebruikersnaam='$gebruikersnaam'");
  $checkrows=mysqli_num_rows($check);

  if (!$checkrows == $gebruikersnaam) {
    echo '
      <div class="melding-bg">
        <div class="melding-block">
          <img src="./assets/images/melding.png" />
          <p>Een leerling/ docent met gebruikersnaam <strong>'. $gebruikersnaam . '</strong> kunnen wij helaas niet herkennen.</p>
          <p><a style="color: #e62686;" href="./instellen">Klik hier om het opnieuw te proberen.</a></p>
        </div>
      </div>';
  } else if (is_numeric ($gebruikersnaam)) {
    $mailadres = $gebruikersnaam . '@ma-web.nl';
    $query = "UPDATE leerlingen SET mailadres = '$mailadres' WHERE gebruikersnaam='$gebruikersnaam'";
    $result = mysqli_query($dbc,$query) or die ("Er is een fout opgetreden tijdens het invoegen van de gebruiker.");

    // MAILPROCES LEERLINGEN
    $get_voornaam = "SELECT voornaam FROM leerlingen WHERE gebruikersnaam='$gebruikersnaam'";
    $result_voornaam = mysqli_query($dbc, $get_voornaam);
    $row = mysqli_fetch_array($result_voornaam);
    $voornaam = $row['voornaam'];

    $random_number = rand(1000, 9999);
    $hashcode = hash('sha512', $random_number);
    $hashQuery = "UPDATE leerlingen SET hashcode = '$hashcode' WHERE gebruikersnaam='$gebruikersnaam'";
    $hashResult = mysqli_query($dbc,$hashQuery) or die ('Fout tijdens het maken van de hashcode.');


    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: activatie@ma-inleversysteem.nl' . "\r\n";
    $headers .= '' . "\r\n";

    $mailto = $mailadres;
    $subject = 'Inleversysteem activatie';
    $message = '

      <!DOCTYPE html>
      <html lang="nl">
      <head>
      <title>Inleversysteem activatie</title>
      <style>
        body {margin: 0 auto; font-family: sans-serif; background: #E6E6E6; color: #000; text-align: center;}
        table.logo {margin: 50px auto; text-align: center;}
        table.content {margin: 0 auto; text-align: center;}
        a {color: #e62686; text-decoration: none;}
      </style>
      </head>

      <body style="margin: 0 auto; font-family: sans-serif; background: #E6E6E6; color: #000; text-align: center;">
        <table class="logo" cellspacing="0" style="background: #fff; width: 550px; padding: 25px; border-radius: 8px;">
          <tr><a href="http://23250.hosts.ma-cloud.nl/inleversysteem/"><img src="http://23250.hosts.ma-cloud.nl/inleversysteem/assets/images/logo-ma.png" width="200" height="auto"/></a></tr>
        </table>

        <table class="content" cellspacing="0" style="background: #fff; width: 550px; height: 750px; padding: 25px; border-radius: 8px;">
          <tr>
            <p><p><p><span style="font-size: 20px;">Welkom bij het Ma Inleversysteem, <strong><span style="color: #e62686;">'. $voornaam .'!</span></strong></span></p></p></p>
            <p>Om je account te activeren moet je op de onderstaande link klikken</p>
            <a href="http://23250.hosts.ma-cloud.nl/inleversysteem/aanmaken?mailadres=' . $mailadres . '&hashcode=' . $hashcode . '">Klik hier om je account te activeren.</a>
          </tr>
          <tr>
            <p>Copyright © 2018 - Inleversysteem | Mediacollege</p>
          </tr>
        </table>
      </body>
      </html>
      ';

    if (mail($mailto, $subject, $message, $headers)){
      echo '
        <div class="melding-bg">
          <div class="melding-block">
            <img src="./assets/images/mail.png" />
            <p>Er is een bevestigingsmail verzonden naar <strong style="color: #e62686;">'. $mailadres . '.</strong></p>
            <p>Volg daar de instructies om je accountregistratie te voltooien.</p>
          </div>
        </div>';
    } else {
      echo '
        <div class="melding-bg">
          <div class="melding-block">
            <img src="./assets/images/melding.png" />
            <p>Er is een fout opgetreden tijdens het verzenden van de mail.</p>
            <a style="color: #e62686;" href="./instellen">Klik hier om het opnieuw te proberen.</a>
          </div>
        </div>';
    }

  } else {
    $get_mailadres = "SELECT mailadres FROM docenten WHERE gebruikersnaam='$gebruikersnaam'";
    $result_mailadres = mysqli_query($dbc, $get_mailadres);
    $row = mysqli_fetch_array($result_mailadres);
    $mailadres = $row['mailadres'];

    // MAILPROCES DOCENTEN
    $get_voornaam = "SELECT voornaam FROM docenten WHERE gebruikersnaam='$gebruikersnaam'";
    $result_voornaam = mysqli_query($dbc, $get_voornaam);
    $row = mysqli_fetch_array($result_voornaam);
    $voornaam = $row['voornaam'];

    $random_number = rand(1000, 9999);
    $hashcode = hash('sha512', $random_number);
    $hashQuery = "UPDATE docenten SET hashcode = '$hashcode' WHERE gebruikersnaam='$gebruikersnaam'";
    $hashResult = mysqli_query($dbc,$hashQuery) or die ('Fout tijdens het maken van de hashcode.');

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: activatie@ma-inleversysteem.nl' . "\r\n";
    $headers .= '' . "\r\n";

    $mailto = $mailadres;
    $subject = 'Inleversysteem activatie';
    $message = '

      <!DOCTYPE html>
      <html lang="nl">
      <head>
      <title>Inleversysteem activatie</title>
      <style>
        body {margin: 0 auto; font-family: sans-serif; background: #E6E6E6; color: #000; text-align: center;}
        table.logo {margin: 50px auto; text-align: center;}
        table.content {margin: 0 auto; text-align: center;}
        a {color: #e62686; text-decoration: none;}
      </style>
      </head>

      <body style="margin: 0 auto; font-family: sans-serif; background: #E6E6E6; color: #000; text-align: center;">
        <table class="logo" cellspacing="0" style="background: #fff; width: 550px; padding: 25px; border-radius: 8px;">
          <tr><a href="http://23250.hosts.ma-cloud.nl/inleversysteem/"><img src="http://23250.hosts.ma-cloud.nl/inleversysteem/assets/images/logo-ma.png" width="200" height="auto"/></a></tr>
        </table>

        <table class="content" cellspacing="0" style="background: #fff; width: 550px; height: 750px; padding: 25px; border-radius: 8px;">
          <tr>
            <p><p><p><span style="font-size: 20px;">Welkom bij het Ma Inleversysteem, <strong><span style="color: #e62686;">'. $voornaam .'!</span></strong></span></p></p></p>
            <p>Om je account te activeren moet je op de onderstaande link klikken</p>
            <a href="http://23250.hosts.ma-cloud.nl/inleversysteem/aanmaken?mailadres=' . $mailadres . '&hashcode=' . $hashcode . '">Klik hier om je account te activeren.</a>
          </tr>
          <tr>
            <p>Copyright © 2018 - Inleversysteem | Mediacollege</p>
          </tr>
        </table>
      </body>
      </html>
      ';


      if (mail($mailto, $subject, $message, $headers)){
        echo '
          <div class="melding-bg">
            <div class="melding-block">
              <img src="./assets/images/mail.png" />
              <p>Er is een bevestigingsmail verzonden naar <strong style="color: #e62686;">'. $mailadres . '.</strong></p>
              <p>Volg daar de instructies om je accountregistratie te voltooien.</p>
            </div>
          </div>';
      } else {
        echo '
          <div class="melding-bg">
            <div class="melding-block">
              <img src="./assets/images/melding.png" />
              <p>Er is een fout opgetreden tijdens het verzenden van de mail.</p>
              <a style="color: #e62686;" href="./instellen">Klik hier om het opnieuw te proberen.</a>
            </div>
          </div>';
      }
    }
  } else {
    header("Location: ./home");
  }


}
