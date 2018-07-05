<?php

session_start();

include '../includes/config.php';


//RECPATCHA PROCES
if(isset($_POST['g-recaptcha-response'])){
  $captcha=$_POST['g-recaptcha-response'];
}
if(!$captcha){
  header("Location: ../inloggen");
  $_SESSION['recaptcha_error_msg'] = "Recaptcha niet aangevinkt";
  unset($_SESSION["login_error_msg"]);
}
$secretKey = "6LfGrTgUAAAAAMI5_V7LCqaquVwDdpNEUMFXKS2V";
$ip = $_SERVER['REMOTE_ADDR'];
$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
$responseKeys = json_decode($response,true);
if(intval($responseKeys["success"]) !== 1) {
  echo '<h2>Jij bent een spammer!!</h2>';
} else {

  //INLOGGEN PROCES
  if (mysqli_connect_errno()) {echo 'MySQLi Connection was not established: ' . mysqli_connect_error();}

  if(isset($_POST['submit'])){

  $_SESSION['gebruikersnaam'] = $_POST['gebruikersnaam'];

  $gebruikersnaam = mysqli_real_escape_string($dbc,$_POST['username']);
  $wachtwoord = mysqli_real_escape_string($dbc,$_POST['password']);

  // $username = mysqli_real_escape_string($dbc,htmlentities($_POST['username']));
  // $password = mysqli_real_escape_string($dbc,htmlentities($_POST['password']));
  $hashed_wachtwoord = hash('sha512', $wachtwoord);

  $sel_user = " SELECT gebruikersnaam, wachtwoord FROM docenten WHERE gebruikersnaam='$gebruikersnaam' AND wachtwoord='$hashed_wachtwoord'
                UNION ALL
                SELECT gebruikersnaam, wachtwoord FROM leerlingen WHERE gebruikersnaam='$gebruikersnaam' AND wachtwoord='$hashed_wachtwoord'";

  $run_user = mysqli_query($dbc, $sel_user);
  $check_user = mysqli_num_rows($run_user);

  $get_status = "SELECT status FROM docenten WHERE gebruikersnaam='$gebruikersnaam' UNION SELECT status FROM leerlingen WHERE gebruikersnaam='$gebruikersnaam'";
  $result_status = mysqli_query($dbc, $get_status);
  $row = mysqli_fetch_array($result_status);
  $status = $row['status'];


  if($check_user> 0 && $status> 0){
    $_SESSION['gebruikersnaam']=$gebruikersnaam;
    header("Location: ../home");
  } else {
    header("Location: ../inloggen");
    $_SESSION['login_error_msg'] = "Inloggegevens onjuist!";
    unset($_SESSION["recaptcha_error_msg"]);
    }
  }else {
    header("Location: ./home");
  }

}









?>
