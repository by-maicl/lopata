<?php
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  include("../connect.php");
 ?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <link rel="shortcut icon" href="/images/2_green.png" type="image/x-icon">
  <link rel="stylesheet" href="/CSS/menu.css">
  <link rel="stylesheet" href="/CSS/upMenu.css">
  <link rel="stylesheet" href="/CSS/players.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&display=swap" rel="stylesheet">
  <meta charset="utf-8" />
 <title>Игроки</title>
 <script src="https://kit.fontawesome.com/20e02f2fbf.js" crossorigin="anonymous"></script>
</head>
  <body bgcolor="#191a19">

    <div class="upMenu">
      <p class="upMenuText">
        <a href="content.php"><img src="/images/2_green.png" width="40px" class="upMenuImg"><font color="white">Питухск</font></a>
      </p>
    </div><br><br>

    <div class="menu"> <!--Меню-->
        <?php
        $role_sel = mysqli_query($mysql, "SELECT * FROM `user` WHERE `login` = '$_COOKIE[user]'");
        $role = mysqli_fetch_assoc($role_sel);
        ?>

         <ul>
           <li><a href="page.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-user"></i> Моя страница</p></a></li>
           <li><a href="content.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-house"></i> Главная</p></a></li>
           <li><a href="bank.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-building-columns"></i> Банк</p></a></li>
           <li><a href="#" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-file-circle-check"></i> Петиции</p></a></li>
           <li><a href="players.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-users"></i> Игроки</p></a></li>
           <li><a href="#" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-map-location-dot"></i> Карта</p></a></li>
           <li><?php if ($role['role'] == 'admin') {
             echo '<a href="admin.php" target="content" id="text" class="panel"><p align="left"><i class="fa-solid fa-bars"></i> Панель</p></a>';
           } ?></li>
         </ul>
         </div>

         <div class="content"> <!--Основная часть сайта-->

           <div class="search">
               <form action="players.php" method="post">
               <input type="text" name="search" placeholder="Введите запрос" required class="pole1">
               <button type="submit" id="searchButt"></button>
               <label for="#searchButt" class="button"><i class="fa-solid fa-magnifying-glass"></i></label>
             </form>
           </div>
           <?php
             $player = $_POST['search'];
             $selPlayer1 = mysqli_query($mysql, "SELECT * FROM `user` WHERE `login` = '$player'");
             $selPlayer = mysqli_fetch_assoc($selPlayer1);
             echo '<p><font color="white">' . $selPlayer['login'] . ' ' . $selPlayer['role'] . '</font></p>'
           ?>

         </div>

  </body>
</html>
