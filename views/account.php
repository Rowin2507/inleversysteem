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
      while($row = mysqli_fetch_array($result)) {$voornaam = $row['voornaam']; $tussenvoegsel = $row['tussenvoegsel']; $achternaam = $row['achternaam']; $klasFunctie = $row['klasFunctie'];
            $mailadres = $row['mailadres']; }
  } else {
    $query = "SELECT * FROM leerlingen WHERE gebruikersnaam='$gebruikersnaam'";
    $result = mysqli_query($dbc, $query);
      while($row = mysqli_fetch_array($result)) {$voornaam = $row['voornaam']; $tussenvoegsel = $row['tussenvoegsel']; $achternaam = $row['achternaam']; $klasFunctie = $row['klasFunctie'];
            $mailadres = $row['mailadres']; $geboortedatum = $row['geboortedatum'];  $groep = $row['groep']; }
  }
}
echo "<style>html, body {margin: 0; height: 100%; overflow-y: auto;} footer {background-color: black; padding: 20px 0; bottom: 0; position: relative;}</style>";
?>

<div class="account-titel">
  <h1><?php echo $voornaam . " " . $tussenvoegsel . " " . $achternaam . " | " . $klasFunctie; ?></h1>
  <content>Bekijk of bewerk je account op deze pagina.</content>
</div>

<div class="account-content">
  <h2>ACCOUNTOVERZICHT</h2>
  <form method="post">
    <span>Naam</span>
    <p><input type="text" name="student" id="account-student" value="<?php echo $voornaam . ' ' . $tussenvoegsel . ' ' . $achternaam; ?>" readonly/></p>
    <span>Gebruikersnaam</span>
    <p><input type="text" name="username" id="account-username" value="<?php echo $gebruikersnaam; ?>" readonly/></p>
    <span>Mailadres</span>
    <p><input type="email" name="mail" id="account-email" value="<?php echo $mailadres; ?>" readonly/></p>
    <span>Klas/ functie</span>
    <p><input type="text" name="class" id="account-class" value="<?php echo $klasFunctie; ?>" readonly/></p>
    <span>Geboortedatum</span>
    <p><input type="text" name="birth" id="account-birth" placeholder="-" value="<?php echo $geboortedatum; ?>" readonly/></p>
    <span>Groepje</span>
    <p><input type="text" name="group" id="account-group" placeholder="-" value="<?php echo $groep; ?>" readonly/></p>
    <span>Wachtwoord</span>
    <p><input type="password" name="password" id="account-password" placeholder="Nieuw wachtwoord" autocomplete="off" required/></p>
    <span>Wachtwoord bevestigen</span>
    <p><input type="password" name="password" id="account-password-confirm" placeholder="Bevestig wachtwoord" autocomplete="off" required/></p>
    <!-- <div class="g-recaptcha" data-sitekey="6LfGrTgUAAAAAA8_X3PIj6WVZJ4Zz9PfAN2ol10q"></div> -->
    <p><a href="./home" id="account-annuleren">&#xf05e; Annuleren</a>
    <input type="submit" name="submit" id="account-toepassen" value="&#xf0c7; Toepassen"/></p>
  </form>
</div>


<?php
if(isset($_POST['submit'])){

  $wachtwoord = mysqli_real_escape_string($dbc,htmlentities($_POST['password']));
  $hashed_wachtwoord = hash('sha512', $wachtwoord);

  $get_hashcode = "SELECT hashcode FROM docenten WHERE gebruikersnaam='$gebruikersnaam' UNION SELECT hashcode FROM leerlingen WHERE gebruikersnaam='$gebruikersnaam'";
  $result_hashcode = mysqli_query($dbc, $get_hashcode);
  $row = mysqli_fetch_array($result_hashcode);
  $hashcode = $row['hashcode'];

  $wachtwoordQuery = "UPDATE leerlingen SET wachtwoord='$hashed_wachtwoord' WHERE gebruikersnaam='$gebruikersnaam' AND hashcode='$hashcode'";
  $wachtwoordResult = mysqli_query($dbc,$wachtwoordQuery) or die ("Er is een fout opgetreden tijdens het aanpassen.");

  header("Location: ./home");
}

?>
