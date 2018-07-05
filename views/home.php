
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

echo "<style>html, body {margin: 0; height: 100%;} footer {display: none;}</style>"; ?>
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


<div class="home-content">
  <div class="content-block" id="opdrachten-block">
    <h2>Opdrachten</h2>
    <?php include "model/opdrachten.php"; ?>
  </div>


<?php
// UPLOAD MELDING (GELUKT - MISLUKT)
echo $uploadenMelding;
?>
<p>In deze versie zijn er nog enkele bugs en werken veel onderdelen nog niet volledig. <i class="em em-disappointed"></i></p>

<div class="nieuwe-taak">
  <div class="nieuwe-taak-info">
    <span>Taak toevoegen</span>
  </div>
  <div class="nieuwe-taak-plus">
    <img src="./assets/images/plus-icon.png" alt="Toevoegen_icon"/>
  </div>
</div>

<div class="body-overlay-taak">
  <div class="body-overlay-taak-content">
    <img src="./assets/images/taak-icon.svg" alt="Taak_icon"/>
    <p>Nieuwe taak toevoegen voor groepsleden.</p>
  </div>
</div>

<?php
  $groep = "SELECT groep FROM leerlingen WHERE gebruikersnaam='$gebruikersnaam'";
  $getGroep = mysqli_query($dbc, $groep);

  include "model/taken.php";


  if ($status == 1) {
    // GROEP LEERLINGEN
    echo '<div class="groep-takenlijst">';
    $groep = "SELECT groep FROM leerlingen WHERE gebruikersnaam='$gebruikersnaam'";
    $getGroep = mysqli_query($dbc, $groep);
      while($row = mysqli_fetch_array($getGroep)) {$groepje = $row['groep'];
        echo '
          <div class="content-block" id="groep-block">
            <h2>Groep: ' . $groepje . '</h2>';
            include "model/groepje.php";
        echo '</div>';}

        echo '
          <div class="content-block" id="takenlijst-block">
            <h2>Takenlijst</h2>';
            include "model/takenlijst.php";
        echo '</div>
            </div>';

  } else {
    // UPLOAD DOCENTEN
    echo '
      <div class="content-block" id="docenten-upload-block">
        <h2>Nieuwe opdracht</h2>
        <div class="sub-content-block-uploaden">
          <form method="post" enctype="multipart/form-data" action=" " onSubmit="window.location.reload()">
            <p><span class="item"><i class="fa fa-header" id="title-icon"></i></span><input type="text" name="titel" id="title" placeholder="Titel" autocomplete="off" required/></p>
            <p><span class="item"><i class="fa fa-comment-o" id="description-icon"></i></span><textarea name="beschrijving" id="description" placeholder="Beschrijving" required></textarea></p>

            <label for="uploaden-toevoegen" class="uploaden-toevoegen"><i class="fa fa-file-pdf-o"></i>&nbsp; Bestand selecteren</label>
            <input type="file" name="upload" id="uploaden-toevoegen" accept="application/pdf" style="display:none;" onchange="readURL(this); required" />
            <span class="uploaden-info">Zorg ervoor dat het bestand een PDF-bestand is.</span>

            <label>
              <span class="klassen">MD2A</span>
              <label class="switch">
                <input type="checkbox" name="klassen[]" value="MD2A" checked>
                <span class="slider round"></span>
              </label>
            </label>
            <label>
              <span class="klassen">MD2B</span>
              <label class="switch">
                <input type="checkbox" name="klassen[]" value="MD2B">
                <span class="slider round"></span>
              </label>
            </label>

            <p><input type="submit" name="toevoegen" id="toevoegen" value="&#xf1d9;&nbsp; Toevoegen"/></p>
          </form>
        </div>
      </div>';

    //DOCENTEN UPLOAD
    if (isset($_POST['toevoegen'])){
      $titel = mysqli_real_escape_string($dbc,htmlentities($_POST['titel']));
      $beschrijving = mysqli_real_escape_string($dbc,htmlentities($_POST['beschrijving']));
      $klas = "";
      if(isset($_POST['klassen'])){ $klas = implode(',',$_POST['klassen']); }
      $datum = date('d-m-Y');
      $name = $datum . '_' . $_FILES['upload']['name'];
      $temp_name = $_FILES['upload']['tmp_name'];
//        $finfo = finfo_open(FILEINFO_MIME_TYPE);
//          $file = finfo_file($finfo, $_FILES['upload']['tmp_name'];);
//          switch ($file) {
//             case 'application/pdf':
//             default:
//              die("Alleen PDF-bestanden zijn toegestaan");
//          }


       if (isset($name)){
         if (!empty($name)){
             $locatie = './uploads/opdrachten/';
             if (move_uploaded_file($temp_name, $locatie.$name)){
                $insert = "INSERT INTO uploads_opdrachten VALUES(0, '$datum', '$gebruikersnaam', '$locatie$name', '$titel', '$beschrijving', '$klas')";
                $insertResult = mysqli_query($dbc, $insert);
                $uploadenMeldingDocent = '
                  <div class="body-overlay-melding"></div>
                    <div class="inleveren-melding">
                      <h1>Gelukt</h1>
                      <button class="melding-weghalen">&#10005</button>
                      <div class="inleveren-melding-content">
                        Het bestand is geüpload.
                        <p><a href="' . $locatie.$name . '" target="_blank">' . $locatie.$name . '</a></p>
                      </div>
                    </div>
                  </div>
                  ';
             }
           }
       } else {
         $uploadenMeldingDocent = '
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


    echo $uploadenMeldingDocent;

  }
?>





</div>
