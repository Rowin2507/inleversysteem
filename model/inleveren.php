<?php

session_start();

include '../includes/config.php';

if (mysqli_connect_errno()) {echo 'MySQLi Connection was not established: ' . mysqli_connect_error();}


if(isset($_POST['submit'])){
  $description = mysqli_real_escape_string($dbc,htmlentities($_POST['inleveren-uploaden']));
  $target = 'pdf/' . $_FILES['pdf']['name'];
  $temp = $_FILES['image']['tmp_name'];
  if (!empty($description)) {
      if (move_uploaded_file($temp, $target)) {
          $query = "INSERT INTO slb-inleversysteem,'$titel','$beschrijving')";
          $result = mysqli_query($dbc,$query) or die('Error querying!');
      }else{
        echo '<br> Upload mislukt';}
  }

}

 ?>
