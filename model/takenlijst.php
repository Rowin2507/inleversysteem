<?php

$taak_leerling = "SELECT * FROM takenlijst_leerlingen WHERE gebruikersnaam='$gebruikersnaam' ORDER BY id DESC";
$getTaak_leerling = mysqli_query($dbc, $taak_leerling);
while($taak_row = mysqli_fetch_array($getTaak_leerling)) {
  $taak_naam = $taak_row['titel'];
  $taak_datum = $taak_row['datum'];
  $taak_beschrijving = $taak_row['beschrijving'];
  $taak_opdrachtgever = $taak_row['opdrachtgever'];
  $getTaak_status = $taak_row['status'];

if ($getTaak_status > 0) {
  $taak_status = 'Afgerond';
} else {
  $taak_status = 'In proces';
}

$get_opdrachtgever = "SELECT * FROM leerlingen WHERE gebruikersnaam='$taak_opdrachtgever'";
$get_taak_opdrachtgever = mysqli_query($dbc, $get_opdrachtgever);
while($row = mysqli_fetch_array($get_taak_opdrachtgever)) {$taak_voornaam = $row['voornaam']; $taak_tussenvoegsel = $row['tussenvoegsel']; $taak_achternaam = $row['achternaam'];}
  $taak_naam_opdrachtgever = $taak_voornaam . ' ' . $taak_tussenvoegsel . ' ' . $taak_achternaam;

echo '
  <div class="sub-content-block">
    <i class="fa fa-pencil-square-o"></i>&nbsp; ' . $taak_naam . '<span class="inlever-status">' . $taak_status . '</span>
  </div>';

}

?>
