<?php
 include("../connect.php");

 if($_COOKIE['user'] == ''){
   echo "<script>self.location='/index.php';</script>";
 } else {
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <link rel="shortcut icon" href="/images/2_green.png" type="image/x-icon">
    <link rel="stylesheet" href="/CSS/menu.css">
    <link rel="stylesheet" href="/CSS/upMenu.css">
    <link rel="stylesheet" href="/CSS/page.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&display=swap" rel="stylesheet">
    <meta charset="utf-8" />
    <title>Моя сторінка</title>
    <script src="https://kit.fontawesome.com/20e02f2fbf.js" crossorigin="anonymous"></script>
  </head>
  <body bgcolor="#191a19">

    <div class="upMenu">
      <p class="upMenuText">
        <a href="content.php"><img src="/images/2_green.png" width="40px" class="upMenuImg"><font color="white">Пітухск</font></a>
      </p>
    </div><br><br>

    <div class="menu"> <!--Меню-->
          <?php
          $role_sel = mysqli_query($mysql, "SELECT * FROM `user` WHERE `login` = '$_COOKIE[user]'");
          $role = mysqli_fetch_assoc($role_sel);
          ?>

           <ul>
             <li><a href="page.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-user"></i> Моя сторінка</p></a></li>
             <li><a href="content.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-house"></i> Головна</p></a></li>
             <li><a href="bank.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-building-columns"></i> Банк</p></a></li>
             <li><a href="#" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-file-circle-check"></i> Петиції</p></a></li>
             <li><a href="players.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-users"></i> Гравці</p></a></li>
             <li><a href="#" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-map-location-dot"></i> Мапа</p></a></li>
             <li><?php if ($role['role'] == 'admin') {
               echo '<a href="admin.php" target="content" id="text" class="panel"><p align="left"><i class="fa-solid fa-bars"></i> Панель</p></a>';
             } ?></li>
           </ul>
      </div>

<div class="content"> <!--Основная часть сайта-->

  <div class="profile">
    <img src="/images/ava_user.png" style="float:left; border-radius: 50px; margin-right:5px;" width="70px"><font color="white" size="5">Maicl_GraB</font>
    <font>
      <a href="/validatoin-form/exit.php" class="buttProf"><i class="fa-solid fa-door-open"></i> Вийти</a>
      <a href="#editProfile" class="buttProf"><i class="fa-regular fa-pen-to-square"></i> Змінити профиль</a>
    </font><br>
    <font color="#828282" size="3" style="clear: top">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis metus nunc, tempor in nisi mattis, sollicitudin ullamcorper quam. Morbi vulputate suscipit pellentesque. Duis sed lorem felis. Sed magna risus, auctor in mi ut, auctor interdum augue. Donec dignissim eros non varius eleifend. Morbi eget sem lobortis, consectetur massa non, pharetra est. Vivamus a nisl sed eros laoreet ultricies vel id diam. Mauris ut massa nulla. Nulla blandit gravida felis, et facilisis massa consequat ac.</font>
  </div><br>
  <div class="bankAccs">
    <font color="white" size="4">Банківскі рахунки:</font>
    <hr color="#414141">
    <div>
      <font color="white" class="cardName">Счёт майчела</font><br>
      <img src="../images/des_cards/des_green.svg" width="100%" class="cardDes">
      <font color="white" size="4" class="cardNumb">1111</font>
    </div>
    <div>
      <font color="white" class="cardName">МБК</font><br>
      <img src="../images/des_cards/des_blue.svg" width="100%" class="cardDes">
      <font color="white" size="4" class="cardNumb">7777</font>
    </div>
  </div>

</div>
</body>
</html>
<?php
  }
  mysqli_close($mysql);
?>
