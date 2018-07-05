<?php
if(!isset($_SESSION['gebruikersnaam'])) {
  header("Location: ./inloggen");
} else {
  $gebruikersnaam = $_SESSION['gebruikersnaam'];

  $get_status = "SELECT status FROM docenten WHERE gebruikersnaam='$gebruikersnaam' UNION SELECT status FROM leerlingen WHERE gebruikersnaam='$gebruikersnaam'";
  $result_status = mysqli_query($dbc, $get_status);
  $row = mysqli_fetch_array($result_status);
  $status = $row['status'];
  if ($status > 1) {
    $query = "SELECT * FROM docenten WHERE gebruikersnaam='$gebruikersnaam'";
    $result = mysqli_query($dbc, $query);
      while($row = mysqli_fetch_array($result)) {$voornaam = $row['voornaam']; $tussenvoegsel = $row['tussenvoegsel']; $achternaam = $row['achternaam']; $klasFunctie = $row['klasFunctie']; $thema_kleur = $row['thema_kleur'];}
  } else {
    $query = "SELECT * FROM leerlingen WHERE gebruikersnaam='$gebruikersnaam'";
    $result = mysqli_query($dbc, $query);
      while($row = mysqli_fetch_array($result)) {$voornaam = $row['voornaam']; $tussenvoegsel = $row['tussenvoegsel']; $achternaam = $row['achternaam']; $klasFunctie = $row['klasFunctie']; $thema_kleur = $row['thema_kleur'];}
  }
}
echo "<style>html, body {margin: 0; height: 100%; overflow-y: auto;} footer {background-color: black; padding: 20px 0; bottom: 0; position: relative;}</style>";
?>

<div class="account-titel">
  <h1><?php echo $voornaam . " " . $tussenvoegsel . " " . $achternaam . " | " . $klasFunctie; ?></h1>
  <content>Bekijk of wijzig je instellingen op deze pagina.</content>
</div>

<div class="account-content" id="instellingen">
  <h2>INSTELLINGEN</h2>
  <form method="post">
    <span>Thema</span>
    <?php
      if ($thema_kleur == 'licht') {
        echo '
          <p><label class="thema_kleur" id="thema_licht">Licht
            <input type="radio" name="thema" value="licht" checked="checked">
            <span class="checkmark"></span>
          </label></p>
          <p><label class="thema_kleur" id="thema_donker">Donker
            <input type="radio" name="thema" value="donker">
            <span class="checkmark"></span>
          </label></p>
        ';
      } else {
        echo '
          <p><label class="thema_kleur" id="thema_licht">Licht
            <input type="radio" name="thema" value="licht">
            <span class="checkmark"></span>
          </label></p>
          <p><label class="thema_kleur" id="thema_donker">Donker
            <input type="radio" name="thema" value="donker" checked="checked">
            <span class="checkmark"></span>
          </label></p>
        ';
      }
    ?>
    <span>Notificaties (n.v.t.)</span>
    <p><label class="thema_kleur" id="browsermeldingen">Mailnotificaties ontvangen
      <input type="checkbox" name="notificaties" value="toestaan">
      <span class="checkmark"></span>
    </label></p>

    <span>Tweetrapsauthenticatie (n.v.t.)</span>
    <p><label class="thema_kleur" id="two_factor">Tweetrapsauthenticatie gebruiken
      <input type="checkbox" name="notificaties" value="toestaan">
      <span class="checkmark"></span>
    </label></p>

    <p><a href="./home" id="account-annuleren">&#xf05e; Annuleren</a>
    <input type="submit" name="instellingen_submit" id="account-toepassen" value="&#xf0c7; Toepassen"/></p>
    <hr class="divider">
  </form>


  <div class="instellingen-info">
    <img src="./assets/images/logo-ma.png" alt="Mediacollege logo"/>
    <h3>Ma Inleversysteem</h3>
    <p>Versie 1.0.0</p>
    <p>
      © 2017 - <?php echo date('Y'); ?> RBR Development<br>
      <a href="https://ma-web.nl/" target="_blank">Mediacollege Amsterdam</a>
    <p>
  </div>

</div>


<?php
if(isset($_POST['instellingen_submit'])){
  if ($status > 1) {
    $thema = mysqli_real_escape_string($dbc,htmlentities($_POST['thema']));

    $themaQuery = "UPDATE docenten SET thema_kleur='$thema' WHERE gebruikersnaam='$gebruikersnaam'";
    $themaResult = mysqli_query($dbc,$themaQuery) or die ("Er is een fout opgetreden tijdens het aanpassen.");

    header("Location: ./home");
  } else {
    $thema = mysqli_real_escape_string($dbc,htmlentities($_POST['thema']));

    $themaQuery = "UPDATE leerlingen SET thema_kleur='$thema' WHERE gebruikersnaam='$gebruikersnaam'";
    $themaResult = mysqli_query($dbc,$themaQuery) or die ("Er is een fout opgetreden tijdens het aanpassen.");

    header("Location: ./home");
  }
}

?>
