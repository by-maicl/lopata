<?php
    include("../connect.php");

    date_default_timezone_set('Europe/Vilnius');
    $commFrom = $_COOKIE['user'];
    $commDate = date('H:i d.m.Y');
    $commText = $_POST['comm_text'];
    $postId = $_POST['post_id'];

    $addComm = mysqli_query($mysql, "INSERT INTO `post_comm` (`post_id`, `comm_from`, `comm_date`, `comm_text`) VALUES ('$postId', '$commFrom', '$commDate', '$commText')");

    $selCommQnt1 = mysqli_query($mysql, "SELECT * FROM `post` WHERE `post_id` = '$postId'");
    $selCommQnt = mysqli_fetch_assoc($selCommQnt1);
    $commQnt = $selCommQnt['post_comm'] + 1;
    mysqli_query($mysql, "UPDATE `post` SET `post_comm` = '$commQnt' WHERE `post_id` = '$postId'");

    mysqli_close($mysql);
    header('Location: content.php#' . $postId . '');
?>
