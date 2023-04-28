<?php
  include("../connect.php");

  date_default_timezone_set('Europe/Vilnius');
  $penaltDate = date('H:i d.m.Y');
  $penaltFrom = $_POST['penaltFrom'];
  $penaltCardFrom = $_POST['penaltCardFrom'];
  $penaltTo = $_POST['penaltTo'];
  $penaltSum = $_POST['penaltSum'];
  $penaltLastDate = $_POST['penaltLastDate'];
  $penaltText = $_POST['penaltText'];

  mysqli_query($mysql, "INSERT INTO `penalty` (`penalt_from`, `penalt_cardfrom`, `penalt_to`, `penalt_sum`, `penalt_text`, `penalt_date`) VALUES ('$penaltFrom', '$penaltCardFrom', '$penaltTo', '$penaltSum', '$penaltText', '$penaltDate')");

  mysqli_close($mysql);
  header('Location: admin.php');
?>
