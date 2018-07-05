<?php

// EXPLODE (LATER ALS ER MEERDERE KLASSEN GEBRUIKT WORDEN TOEPASSEN)
// $klassen = "SELECT * FROM uploads_opdrachten";
// $getKlassen = mysqli_query($dbc, $klassen);
// while($row = mysqli_fetch_array($getKlassen)) {$alleKlassen = $row['klas'];}
//
// $klasExplode = array();
// if(!empty($alleKlassen)){
//   $klasExplode = explode(",", $alleKlassen);
// }

// ALLE OPDRACHTEN VAN KLAS OPROEPEN
$opdrachten= "SELECT * FROM uploads_opdrachten WHERE (klas LIKE '$klasFunctie' OR klas LIKE 'MD2A,MD2B')";
$getOpdrachten = mysqli_query($dbc, $opdrachten);
while($row = mysqli_fetch_array($getOpdrachten)) {$id = $row['id']; $eindDatum = $row['datum']; $opdracht = $row['titel']; $beschrijving = $row['beschrijving']; $locatie = $row['locatie'];

  // CHECK OF AL IS INGELEVERD
  $ingeleverdStatus = "SELECT * FROM uploads_leerlingen WHERE opdracht_id='$id' AND gebruikersnaam='$gebruikersnaam'";
  $checkIngeleverdStatus = mysqli_query($dbc, $ingeleverdStatus);
  $getIngeleverdStatus = mysqli_num_rows($checkIngeleverdStatus);
  if ($getIngeleverdStatus > 0) {
    $inleverenStatus = 'Ingeleverd';
    $inleverenStatusButton = '&#xf021;&nbsp; Vernieuwen';
  } else {
    $inleverenStatus = 'Openstaand';
    $inleverenStatusButton = '&#xf093;&nbsp; Inleveren';
  }

  echo '
    <div class="sub-content-block">
      <i class="fa fa-file-pdf-o"></i>&nbsp; ' . $opdracht . '<span class="inlever-status">' . $inleverenStatus . '</span>
      <span class="titel">Datum: ' . $eindDatum .'</span>

      <div class="sub-content-block-buttons">
        <a href="' . $locatie . '" target="_blank" class="sub-content-block-opdracht">&#xf1c1;&nbsp; Bekijken</a>
        <a href="#inleveren' . $id. '" id="inleverenknop' . $id . '" class="sub-content-block-inleveren">' . $inleverenStatusButton . '</a>
      </div>
    </div>

    <div class="body-overlay" id="overlay' . $id . '"></div>
    <div class="inleveren-block" id="inleveren' . $id . '">
      <h1>Inleveren</h1>
      <div class="inleveren-block-content">
        Lever hier je opdracht in.
        <form method="post" enctype="multipart/form-data" action=" " onSubmit="window.location.reload()">
          <p><span class="item"><i class="fa fa-header" aria-hidden="true"></i></span><input type="text" name="inleveren-titel' . $id . '" id="inleveren-titel" placeholder="Titel" autocomplete="off" required/></p>
          <p><span class="item"><i class="fa fa-comment-o" aria-hidden="true"></i></span><input type="text" name="inleveren-beschrijving' . $id . '" id="inleveren-beschrijving" placeholder="Opmerking"/></p>
          <label for="inleveren-uploaden' . $id . '" class="inleveren-uploaden"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; Bestand selecteren</label>
          <input type="file" name="uploaden' . $id . '" id="inleveren-uploaden' . $id . '" accept="application/pdf" style="display:none;" onchange="readURL(this); required" />
          <span class="inleveren-info">Zorg ervoor dat het bestand een PDF-bestand is.</span>
          <p><button class="inleveren-annuleren" id="inleveren-annuleren' . $id . '">&#xf05e;&nbsp; Annuleren</button>
          <input type="submit" name="uploadenSubmit' . $id . '" id="inleveren-submit' . $id . '" value="&#xf093;&nbsp; Inleveren"/></p>
        </form>
      </div>
    </div>

    <script>
      $("#inleverenknop' . $id . '").click(function(){
        $("#overlay' . $id . '").css("opacity" , "1");
        $("#overlay' . $id . '").css("visibility" , "visible");
        $("#inleveren' . $id . '").css("top" , "calc(50% - 240px)");
        $("#inleveren' . $id . '").css("visibility" , "visible");
      });

      $("#inleveren-uploaden' . $id . '").change(function() {
        var i = $(this).prev("label").clone();
        var file = $("#inleveren-uploaden' . $id . '")[0].files[0].name;
        $(this).prev("label").text(file);
      });
    </script>';

    if(isset($_POST['uploadenSubmit' . $id])){
      $titel = mysqli_real_escape_string($dbc,htmlentities($_POST['inleveren-titel' . $id]));
      $beschrijving = mysqli_real_escape_string($dbc,htmlentities($_POST['inleveren-beschrijving' . $id]));
      $datum = date('d-m-Y');

      $name = explode(".", $_FILES['uploaden' . $id]['name']);
      $newfilename = $gebruikersnaam . '_' . $id . '_' . $opdracht . '.' . end($name);

      if ((isset($name)) & ($_FILES['uploaden' . $id]['type'] == 'application/pdf')) {
        if (!empty($name)){
          $locatie = './uploads/leerlingen/';
          if (move_uploaded_file($_FILES['uploaden' . $id]['tmp_name'], './uploads/leerlingen/' . $newfilename)){
            $insert = "INSERT INTO uploads_leerlingen VALUES(0, '$id', '$opdracht', '$datum', '$gebruikersnaam', '$locatie$newfilename', '$titel', '$beschrijving')";
            $insertResult = mysqli_query($dbc, $insert);
            $uploadenMelding = '
              <div class="body-overlay-melding"></div>
                <div class="inleveren-melding">
                  <h1>Gelukt</h1>
                  <button class="melding-weghalen">&#10005</button>
                  <div class="inleveren-melding-content">
                    Het bestand is geüpload.
                    <p><a href="' . $locatie.$newfilename . '" target="_blank">' . $newfilename . '</a></p>
                  </div>
                </div>
              </div>
            ';
          }
        }
      } else {
        $uploadenMelding = '
          <div class="body-overlay-melding"></div>
            <div class="inleveren-melding">
              <h1>Mislukt</h1>
              <button class="melding-weghalen">&#10005</button>
              <div class="inleveren-melding-content">
                <span>Ongeldig bestand.</span>
                <p>Alleen PDF-bestanden zijn toegestaan.</p>
              </div>
            </div>
          </div>
        ';
      }
    }
  }


?>
