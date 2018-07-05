<?php

header("Content-type: text/html; charset=iso-8859-1;");

while($row = mysqli_fetch_array($getGroep)) {
    $groepje = $row['groep'];

    $groepsleden = "SELECT * FROM leerlingen WHERE groep='$groepje'";
    $getGroepsleden = mysqli_query($dbc, $groepsleden);


    echo '

    <div class="taak-aanmaken-block">
      <h1>Taak aanmaken</h1>
      <button class="melding-weghalen">&#10005;</button>
      <div class="taak-aanmaken-block-content">

        Taken aanmaken voor ' . $groepje . '.

        <form method="post" enctype="multipart/form-data" action=" " onSubmit="window.location.reload()">
          <p><span class="item"><i class="fa fa-header" id="title-icon"></i></span><input type="text" name="taak_titel" id="taak_titel" placeholder="Titel" autocomplete="off" required/>
          <span class="item"><i class="fa fa-calendar" id="date-icon"></i></span><input type="date" name="taak_datum" id="taak_datum" title="Taak deadline" autocomplete="off" required/></p>
          <p><span class="item"><i class="fa fa-comment-o" id="description-icon"></i></span><textarea name="taak_beschrijving" id="taak_beschrijving" placeholder="Beschrijving" required></textarea></p>

          <p><select name="leerling">
              <option>&#xf2c0;&nbsp; Groepslid selecteren</option>';

            while ($row = mysqli_fetch_array($getGroepsleden)) {
                $leerlingnummer = $row['gebruikersnaam'];
                $voornaam = $row['voornaam'];
                $tussenvoegsel = $row['tussenvoegsel'];
                $achternaam = $row['achternaam'];

                echo '<option value="' . $leerlingnummer . '">&#xf2c0;&nbsp; ' . $voornaam . ' ' . $tussenvoegsel . ' ' . $achternaam . '</option>';
            }

            echo '

             </select></p>

          <p><input type="submit" name="toevoegen" id="toevoegen" value="&#xf08d;&nbsp; Aanmaken"/></p>
        </form>

      </div>
    </div>';

    //TAKEN UPLOAD
    if (isset($_POST['toevoegen'])) {
        $taak_titel = mysqli_real_escape_string($dbc, htmlentities($_POST['taak_titel']));
        $taak_beschrijving = mysqli_real_escape_string($dbc, htmlentities($_POST['taak_beschrijving']));
        $taak_datum = mysqli_real_escape_string($dbc, htmlentities($_POST['taak_datum']));
        $leerlingnummer = mysqli_real_escape_string($dbc, htmlentities($_POST['leerling']));

        if (isset($taak_titel)) {
            if (!empty($taak_titel)) {
                $insert = "INSERT INTO takenlijst_leerlingen VALUES(0, '$leerlingnummer', '$taak_datum', '$taak_titel', '$taak_beschrijving', '$gebruikersnaam', '0')";
                $insertResult = mysqli_query($dbc, $insert);

                $uploadMeldingTaken = '
                      <div class="body-overlay-melding"></div>
                        <div class="inleveren-melding">
                          <h1>Gelukt</h1>
                          <button class="melding-weghalen">&#10005</button>
                          <div class="inleveren-melding-content">
                            Taak is toegevoegd.
                          </div>
                        </div>
                      </div>
                      ';
            }
        } else {
            $uploadMeldingTaken = '
               <div class="body-overlay-melding"></div>
                 <div class="inleveren-melding">
                   <h1>Mislukt</h1>
                   <button class="melding-weghalen">&#10005</button>
                   <div class="inleveren-melding-content">
                     Taak toevoegen mislukt.
                   </div>
                 </div>
               </div>
             ';
        }
    }


    echo $uploadMeldingTaken;
}
?>

