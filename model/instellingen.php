<?php
if (isset($_SESSION['gebruikersnaam'])) {
  $gebruikersnaam = $_SESSION['gebruikersnaam'];
  $get_status = "SELECT status FROM docenten WHERE gebruikersnaam='$gebruikersnaam'
                  UNION ALL
                  SELECT status FROM leerlingen WHERE gebruikersnaam='$gebruikersnaam'";
  $status_result = mysqli_query($dbc, $get_status);
    while($row = mysqli_fetch_array($status_result)) {$status = $row['status'];}
if ($status == 1) {
  // THEMA KLEUR LEERLINGEN
  $get_thema = "SELECT thema_kleur FROM leerlingen WHERE gebruikersnaam='$gebruikersnaam'";
  $thema_result = mysqli_query($dbc, $get_thema);
  while($row = mysqli_fetch_array($thema_result)) {$thema_kleur = $row['thema_kleur'];}

    if ($thema_kleur == 'donker') {
      echo '
        <style>
          .home-content {background-color: #272727; color: #fff;}

          .sub-content-block, .sub-content-block-link {color: #fff;}
          .sub-content-block:nth-of-type(odd), .sub-content-block-link:nth-of-type(odd) {background: #2d2d2d;}
          .sub-content-block:nth-of-type(even), .sub-content-block-link:nth-of-type(even) {background: #272727;}
          .sub-content-block:hover, .sub-content-block.active, .sub-content-block-link:hover {background-color: #383838;}
          .sub-content-block.active i {color: #fff;}
          .sub-content-block-opdracht:hover {background-color: #272727;}

          .inleveren-block-content, .opdrachten-leerling-block-content, .taak-aanmaken-block-content {background-color: #272727; color: #fff;}
          input[type="text"], input[type="password"], input[type="email"] {background-color: #272727; color: #fff;}
          input[type="text"]:focus, input[type="password"]:focus, #taak_beschrijving:focus {border-bottom: 2px solid #fff;}
          .inleveren-annuleren:hover {background-color: #383838;}
          .inleveren-melding-content {background-color: #272727; color: #fff;}

          .opdrachten-leerling-block-uploads, .opdrachten-leerling-block-taken {background: #2d2d2d;}

          .opdrachten-leerling-block-taken.active .taak-details {border-top: 2px solid #272727;}

          .account-content, #taak_datum, #taak_beschrijving {background-color: #272727; color: #fff;}
          #account-username, #account-student, #account-class, #account-email, #account-birth , #account-group, #account-password, #account-password-confirm {border-bottom: 2px solid #2d2d2d;}

          #volledigeklas tr:nth-child(odd){background-color: #2d2d2d;}

          .thema_kleur {background-color: #2d2d2d; color: #fff;}
          .checkmark {background-color: #272727;}
          .divider {border-color: #2d2d2d;}


          .over-ons-content {background-color: #272727; color: #fff;}
          .over-ons-content p {background-color: #2d2d2d;}


          ::-webkit-scrollbar-track {background: #383838;}
        </style>';
    }
  } else {
    // THEMA KLEUR DOCENTEN
    $get_thema = "SELECT thema_kleur FROM docenten WHERE gebruikersnaam='$gebruikersnaam'";
    $thema_result = mysqli_query($dbc, $get_thema);
    while($row = mysqli_fetch_array($thema_result)) {$thema_kleur = $row['thema_kleur'];}

      if ($thema_kleur == 'donker') {
        echo '
          <style>
            .home-content {background-color: #272727; color: #fff;}

            .sub-content-block {color: #fff;}
            .sub-content-block:nth-of-type(odd){background: #2d2d2d;}
            .sub-content-block:nth-of-type(even){background: #272727;}
            .sub-content-block:hover, .sub-content-block.active {background-color: #383838;}
            .sub-content-block.active i {color: #fff;}
            .sub-content-block-opdracht:hover {background-color: #272727;}
            .sub-content-block-uploaden {background-color: #2d2d2d; color: #fff;}
            textarea, #title {background-color: #2d2d2d; color: #fff;}

            .inleveren-block-content {background-color: #272727; color: #fff;}
            input[type="text"], input[type="password"], input[type="email"] {background-color: #272727; color: #fff;}
            input[type="text"]:focus, input[type="password"]:focus, textarea:focus {border-bottom: 2px solid #fff;}
            .inleveren-annuleren:hover {background-color: #383838;}
            .inleveren-melding-content {background-color: #272727; color: #fff;}
            .klassen {border-bottom: 1px solid #383838;}
            .slider {background-color: #383838;}


            .account-content {background-color: #272727; color: #fff;}
            #account-username, #account-student, #account-class, #account-email, #account-birth , #account-group, #account-password, #account-password-confirm {border-bottom: 2px solid #2d2d2d;}

            #volledigeklas tr:nth-child(odd){background-color: #2d2d2d;}

            .thema_kleur {background-color: #2d2d2d; color: #fff;}
            .checkmark {background-color: #272727;}
            .divider {border-color: #2d2d2d;}


            .over-ons-content {background-color: #272727; color: #fff;}
            .over-ons-content p {background-color: #2d2d2d;}


            ::-webkit-scrollbar-track {background: #383838;}
          </style>';
      }
  }
}
?>
