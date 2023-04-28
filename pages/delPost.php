<?php

  include("../connect.php");

  $post_id = $_POST['post_id'];

  mysqli_query($mysql, "DELETE FROM `post` WHERE `post_id` = '$post_id'");
  mysqli_query($mysql, "DELETE FROM `post_comm` WHERE `post_id` = '$post_id'");

  mysqli_close($mysql);
  header('Location: content.php');

?>
