<?php
if(!isset($_SESSION['gebruikersnaam'])) {
  header("Location: ./inloggen");
} else {
  $gebruikersnaam = $_SESSION['gebruikersnaam'];
  $query = "SELECT voornaam, tussenvoegsel, achternaam, klasFunctie, status FROM docenten WHERE gebruikersnaam='$gebruikersnaam'
            UNION ALL
            SELECT voornaam, tussenvoegsel, achternaam, klasFunctie, status FROM leerlingen WHERE gebruikersnaam='$gebruikersnaam'";
  $result = mysqli_query($dbc, $query);
    while($row = mysqli_fetch_array($result)) {$voornaam = $row['voornaam']; $tussenvoegsel = $row['tussenvoegsel']; $achternaam = $row['achternaam']; $klasFunctie = $row['klasFunctie']; $status = $row['status'];}
}
echo "<style>html, body {margin: 0; height: 100%; overflow: hidden} footer {display: none;}</style>";
?>
<header>
  <img src="./assets/images/logo-full.png" alt="Mediacollege logo"/>
  <div class="account-dropdown-button">
    <a href="./account" class="account">&#xf2c0;&nbsp; <?php echo $voornaam . " " . $tussenvoegsel . " " . $achternaam; ?></a>
    <div class="account-dropdown">
      <h3>
        <span class="naam"><?php echo $voornaam; ?></span>
        <br><span class="klas"><?php echo $klasFunctie; ?></span>
      </h3>
      <span class="gebruikersnaam"><?php echo $gebruikersnaam; ?></span>
      <a href="./account" class="account-link">&#xf05a;&nbsp; Accountoverzicht</a>
    </div>
  </div>
  <a href="./uitloggen" class="uitloggen">&#xf08b; Uitloggen</a>
</header>
<nav>
  <?php
    if ($status == 1) {
      echo '
      <a href="./home" class="nav-item" id="first-nav-item"><i class="fa fa-home" id="home"></i><span>Home</span></a>
      <a href="./klas" class="nav-item"><i class="fa fa-list-ol" id="klas"></i><span>Klas</span></a>
      <a href="./account" class="nav-item"><i class="fa fa-info-circle" id="account"></i><span>Account</span></a>
      <a href="./instellingen" class="nav-item"><i class="fa fa-cog" id="instellingen"></i><span>Instellingen</span></a>
      <div id="datum"></div>
      <div id="copyright" class="side-nav-copyright"></div>';
    } else {
      echo '
      <a href="./home" class="nav-item" id="first-nav-item"><i class="fa fa-home" id="home"></i><span>Home</span></a>
      <a href="./klas" class="nav-item"><i class="fa fa-list-ol" id="klas"></i><span>Klas</span></a>
      <a href="./account" class="nav-item"><i class="fa fa-info-circle" id="account"></i><span>Account</span></a>
      <a href="./instellingen" class="nav-item"><i class="fa fa-cog" id="instellingen"></i><span>Instellingen</span></a>
      <div id="datum"></div>
      <div id="copyright" class="side-nav-copyright"></div>';
    }
  ?>
</nav>



<div class="home-content" id="klas-pagina">
  <table id="volledigeklas">
    <tr>
      <th>Naam</th>
      <th>Leerlingnummer</th>
      <th>Geboortedatum</th>
      <th>Groep</th>
      <th>Klas</th>
    </tr>
    <?php include "model/klas.php"; ?>
</table>
</div>
