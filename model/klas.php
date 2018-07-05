<?php

header("Content-type: text/html; charset=iso-8859-1;");

if ($status == 1) {
  $groepsleden= "SELECT * FROM leerlingen WHERE klasFunctie='$klasFunctie'";
} else {
  $groepsleden= "SELECT * FROM leerlingen";
}
$getGroepsleden = mysqli_query($dbc, $groepsleden);
  while($row = mysqli_fetch_array($getGroepsleden)) {$voornaam = $row['voornaam']; $tussenvoegsel = $row['tussenvoegsel']; $achternaam = $row['achternaam'];
    $klasFunctie = $row['klasFunctie']; $gebruikersnaam = $row['gebruikersnaam']; $geboortedatum = $row['geboortedatum']; $groep = $row['groep'];
    echo '
      <tr>
        <td data-label="Naam">' . $voornaam . ' ' . $tussenvoegsel . ' ' . $achternaam . '</td>
        <td data-label="Leerlingnummer">' . $gebruikersnaam . '</td>
        <td data-label="Geboortedatum">' . $geboortedatum . '</td>
        <td data-label="Groep">' . $groep . '</td>
        <td data-label="Klas">' . $klasFunctie . '</td>
      </tr>'
      ;}

 ?>
