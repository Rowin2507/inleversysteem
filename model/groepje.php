<?php


$groepsleden = "SELECT * FROM leerlingen WHERE groep='$groepje'";
$getGroepsleden = mysqli_query($dbc, $groepsleden);
  while($row = mysqli_fetch_array($getGroepsleden)) {$leerlingnummer = $row['gebruikersnaam']; $voornaam = $row['voornaam']; $tussenvoegsel = $row['tussenvoegsel']; $achternaam = $row['achternaam']; $klasFunctie = $row['klasFunctie'];
    echo '
      <a href="#leerling-ingeleverde-opdrachten' . $leerlingnummer . '" class="sub-content-block-link" id="opdrachten-leerling' . $leerlingnummer . '">&#xf2c0;&nbsp; ' . $voornaam . ' ' . $tussenvoegsel . ' ' . $achternaam . ' | ' . $klasFunctie . '</a>

      <div class="body-overlay" id="overlay' . $leerlingnummer . '"></div>
      <div class="opdrachten-leerling-block" id="leerling-ingeleverde-opdrachten' . $leerlingnummer . '">
        <h1>' . $voornaam . ' ' . $tussenvoegsel . ' ' . $achternaam . '</h1>
        <button class="melding-weghalen">&#10005</button>
        <div class="opdrachten-leerling-block-content">
          Bekijk alle taken &amp; uploads van ' . $voornaam . ' ' . $tussenvoegsel . ' ' . $achternaam . '.
          <h2>TAKENLIJST</h2>
      ';

    $taak_leerling = "SELECT * FROM takenlijst_leerlingen WHERE gebruikersnaam='$leerlingnummer' ORDER BY id DESC";
    $getTaak_leerling = mysqli_query($dbc, $taak_leerling);
    while($taak_row = mysqli_fetch_array($getTaak_leerling)) {
      $taak_naam = $taak_row['titel'];
      $taak_datum = $taak_row['datum'];
      $taak_beschrijving = $taak_row['beschrijving'];
      $taak_opdrachtgever = $taak_row['opdrachtgever'];
      $getTaak_status = $taak_row['status'];


      if ($getTaak_status > 0) {
        $taak_status = '&#xf274;&nbsp; Afgerond';
      } else {
        $taak_status = '&#xf272;&nbsp; In proces';
      }

      $get_opdrachtgever = "SELECT * FROM leerlingen WHERE gebruikersnaam='$taak_opdrachtgever'";
      $get_taak_opdrachtgever = mysqli_query($dbc, $get_opdrachtgever);
      while($row = mysqli_fetch_array($get_taak_opdrachtgever)) {$taak_voornaam = $row['voornaam']; $taak_tussenvoegsel = $row['tussenvoegsel']; $taak_achternaam = $row['achternaam'];}
        $taak_naam_opdrachtgever = $taak_voornaam . ' ' . $taak_tussenvoegsel . ' ' . $taak_achternaam;

      echo '
        <div class="opdrachten-leerling-block-taken" title="Details bekijken">
          ' . $taak_naam . '
          <span class="taken_status">' . $taak_status . '</span>

          <div class="taak-details" title="">
            <p>Toegewezen door<b> ' . $taak_naam_opdrachtgever . '</b> <time>Deadline: ' . $taak_datum . '</time></p>
            <p>' . $taak_beschrijving . '</p>

          </div>
        </div>';
    }
    if(!mysqli_num_rows($getTaak_leerling) > 0){
      echo '
        <div class="opdrachten-leerling-block-taken">
          Er zijn nog geen taken toegewezen.
        </div>';
    }

    echo '<h2>UPLOADS</h2>';

    $opdracht_leerling = "SELECT * FROM uploads_leerlingen WHERE gebruikersnaam='$leerlingnummer' ORDER BY id DESC";
    $getOpdracht_leerling = mysqli_query($dbc, $opdracht_leerling);
    while($opdracht_row = mysqli_fetch_array($getOpdracht_leerling)) {$opdracht_naam = $opdracht_row['opdracht_naam']; $opdracht_locatie = $opdracht_row['locatie'];

      echo '
        <div class="opdrachten-leerling-block-uploads">
          ' . $opdracht_naam . '
          <a href="' . $opdracht_locatie .'" target="_blank" class="button">&#xf1c1;&nbsp; Bekijken</a>
          <span class="opdracht_datum">20-03-2018</span>
        </div>';
    }
    if(!mysqli_num_rows($getOpdracht_leerling) > 0){
      echo '
        <div class="opdrachten-leerling-block-taken">
          Er zijn nog geen uploads.
        </div>';
    }


    echo '
        </div>
      </div>

      <script>
        $("#opdrachten-leerling' . $leerlingnummer . '").click(function(){
          $("#overlay' . $leerlingnummer . '").css("opacity" , "1");
          $("#overlay' . $leerlingnummer . '").css("visibility" , "visible");
          $("#leerling-ingeleverde-opdrachten' . $leerlingnummer . '").css("top" , "calc(50% - 240px)");
          $("#leerling-ingeleverde-opdrachten' . $leerlingnummer . '").css("visibility" , "visible");
        });
      </script>';

    }

 ?>
