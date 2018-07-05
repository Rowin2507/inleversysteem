
<?php

//CONFIGURATIE
include 'includes/config.php';

//HEAD
include 'views/head.html';

//HEADER
include 'views/header.html';

//SITE-CONTENT
$page = isset($_GET['page']) ? $_GET['page'] : 'index';

session_start();

switch ($page) {
  case 'index':
    include 'views/home.php';
  break;
  case 'inloggen':
    include 'views/inloggen.php';
  break;
  case 'instellen':
    include 'views/instellen.php';
  break;

  //OVERIGE PAGINA'S
  case 'account':
    include 'views/account.php';
  break;
  case 'klas':
    include 'views/klas.php';
  break;
  case 'instellingen':
    include 'views/instellingen.php';
  break;
  case 'over':
    include 'views/over.html';
  break;
  case 'browser-support':
    include 'views/browser-support.html';
  break;
  case 'bevestiging':
    include 'model/bevestiging.php';
  break;
  case 'aanmaken':
    include 'views/aanmaken.php';
  break;
  case 'uitloggen':
    include 'model/uitloggen.php';
  break;

  //STANDAARD PAGINA: 404 ERROR
  default:
    include 'error.html';
  break;
}

//INSTELLINGEN
include 'model/instellingen.php';

//FOOTER
include 'views/footer.html';

?>
