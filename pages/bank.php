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
    <link rel="stylesheet" href="/CSS/bank.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&display=swap" rel="stylesheet">
    <meta charset="utf-8" />
    <title>Банк</title>
    <script src="https://kit.fontawesome.com/20e02f2fbf.js" crossorigin="anonymous"></script>
  </head>
  <body bgcolor="#191a19">

    <div class="upMenu"> <!--Верхнее меню-->
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

  <div class="windBack" id="windNewCard"> <!--Открытие нового счёта-->
    <font class="xmark" color="white" size="6"><a href=""><i class="fa-solid fa-xmark"></i></a></font>
    <div class="windTrans">
      <font color="white" size="5">Відкриття рахунку</font>
      <form class="" action="new_card.php" method="post"><br>
        <input type="text" name="card_name" class="pole1" maxlength="100" placeholder="Введіть назву рахунку" required><br><br>
        <i id="downArrowNewCard" class="fa-solid fa-chevron-down"></i>
        <select class="pole1" id="poleSel" name="card_des" required>
            <option value="des_green.svg">Зелений</option>
            <option value="des_blue.svg">Синій</option>
            <option value="des_orange.svg">Помаранчевий</option>
            <option value="des_purple.svg">Фіолетовий</option>
        </select><br><br>
        <button type="submit" class="OK">ОК</button><br><br>
      </form>
    </div>
  </div>

    <?php

      $balance = $sel_card1['card_balance']; //Транзакции
      $sel_trans = "SELECT * FROM `trans` WHERE `trans_from` = '$_COOKIE[user]' OR `trans_to` = '$_COOKIE[user]' ORDER BY `trans_id` DESC LIMIT 0,500";
      $sel_result = mysqli_query($mysql, $sel_trans);
      $sel_result1 = mysqli_fetch_assoc($sel_result);

      //Штрафы
      $penalty1 = mysqli_query($mysql, "SELECT * FROM `penalty` WHERE `penalt_to` = '$_COOKIE[user]' AND `penalt_status` = '1' ORDER BY `penalt_id` DESC");
      $penalty = mysqli_fetch_assoc($penalty1);
      //Количество штрафов
      $penaltyCount1 = mysqli_query($mysql, "SELECT COUNT(*) as count FROM `penalty` WHERE `penalt_to` = '$_COOKIE[user]' AND `penalt_status` = '1'");
      $penaltyCount = mysqli_fetch_assoc($penaltyCount1);

      $sel_card = mysqli_query($mysql, "SELECT * FROM `card` WHERE `card_user` = '$_COOKIE[user]' ORDER BY `card_id`"); //Проверка на наличие карты
      $sel_card1 = mysqli_fetch_assoc($sel_card);
      if ($sel_card1['card_user'] == '') {
        echo '<font size="5" color="white"><p align="center">У вас ще немає рахунку!</p></font><a href="#windNewCard"><button class="button" id="newNewCard">Відкрити рахунок</button></a>';
      } else {
     ?>

 <div class="blocks">


  <div class="cards"> <!--Счёта-->
    <?php foreach ($sel_card as $cardInf) { ?>
    <div class="card">
      <font color="white" size="3" class="cardName" onclick="trans()"><?= $cardInf['card_name'] ?></font>
      <font class="cardButt" size="3">
      <a href="#windDelCard-<?= $cardInf['card_number'] ?>"><i class="fa-regular fa-trash-can" id="cardDel"></i></a>
      <a href="#windEditCard-<?= $cardInf['card_number'] ?>"><i class="fa-regular fa-pen-to-square" id="cardEdit"></i></a>
      </font><br><br>
      <font color="white" class="cardBalance"><b><?= $cardInf['card_balance'] ?> ІР</b></font>
      <img src="../images/des_cards/<?= $cardInf['card_design'] ?>" width="110px" class="cardDes">
      <font color="white" size="4" class="cardNumb"><?= $cardInf['card_number'] ?></font>
    </div><br><br>

    <div class="windBack" id="windEditCard-<?= $cardInf['card_number'] ?>"> <!--Изменение счёта-->
      <font class="xmark" color="white" size="6"><a href=""><i class="fa-solid fa-xmark"></i></a></font>
      <div class="windTrans">
        <font color="white" size="5">Зміна рахунку</font>
        <form class="" action="edit_card.php" method="post"><br>
          <input type="text" name="new_card_name" class="pole1" maxlength="100" placeholder="Введіть нову назву рахунку" required><br><br>
          <i id="downArrowNewCard" class="fa-solid fa-chevron-down"></i>
          <select class="pole1" id="poleSel" name="card_des" required>
              <option value="des_green.svg">Зелений</option>
              <option value="des_blue.svg">Синій</option>
              <option value="des_orange.svg">Помаранчевий</option>
              <option value="des_purple.svg">Фіолетовий</option>
          </select><br><br>
          <input type="text" name="card_number" class="pole1" id="invisibleInput" value="<?= $cardInf['card_number'] ?>" readonly required>
          <button type="submit" class="OK">ОК</button><br><br>
        </form>
      </div>
    </div>

    <div class="windBack" id="windDelCard-<?= $cardInf['card_number'] ?>"> <!--Удаление счёта-->
      <font class="xmark" color="white" size="6"><a href=""><i class="fa-solid fa-xmark"></i></a></font>
      <div class="windTrans">
        <font color="white" size="5"><p align="center">Ви впевнені, що хочете закрити рахунок?</p></font>
        <form class="" action="del_card.php" method="post">
          <input type="text" name="card_number" class="pole1" id="invisibleInput" value="<?= $cardInf['card_number'] ?>" readonly required>
          <button type="submit" class="OK" id="okDelCard">Так</button>
        </form>
      </div>
    </div>
    <?php } ?>

    <a href="#windNewCard"><button class="button" id="cardNew"><i class="fa-solid fa-plus"></i></button></a>
  </div>

  <div class="buttAndTrans"> <!--Кнопки и транзакции-->
    <div class="buttons"> <!--Кнопки-->
      <a href="#windTrans"><button class="button"><i class="fa-solid fa-arrow-right-arrow-left"></i> Переказ</button></a>
      <a href="#windPenalt"><button class="button"><i class="fa-solid fa-money-bills"></i></i> Штрафи <?php if ($penaltyCount['count'] == 0) {echo '';} else {echo '(' . $penaltyCount['count'] . ')';} ?></button></a>
    </div><br>
    <div class="trans">
      <table>
        <tr>
          <th class="transFrom">Гравець та коментар</th>
          <th class="transDate">Дата</th>
          <th class="transSum">Сума</th>
        </tr>
      </table>
      <hr color="#212421">

      <?php

      ?>

      <table class="transInv" id="trans-<?= $sel_card1['card_number'] ?>">
        <?php foreach ($sel_result as $transInf) { ?>
        <tr>
          <td class="transFrom"><?php
            if ($_COOKIE['user'] == $transInf['trans_from']) {
              echo $transInf['card_from'] . ' <i class="fa-solid fa-angle-right"></i> <a href="page.php#' . $transInf['trans_to'] . '">' . $transInf['trans_to'] . '</a> <font color="#828282">(' . $transInf['card_to'] . ')</font>';
            } else {
              echo $transInf['card_to'] . ' <i class="fa-solid fa-angle-left"></i> <a href="page.php#' . $transInf['trans_from'] . '">' . $transInf['trans_from'] . '</a> <font color="#828282">(' . $transInf['card_from'] . ')</font>';
            }
          ?></td>
          <td class="transDate1"><?= $transInf['trans_date'] ?></td>
          <td class="transSum1"><?php
            if ($_COOKIE['user'] == $transInf['trans_from']) {
              echo '<font color="#a00000">-' . $transInf['trans_summa'] . ' ІР</font>';
            } else {
              echo '<font color="#4e9f3d">' . $transInf['trans_summa'] . ' ІР</font>';
            }
          ?></td>
        </tr>
        <tr>
          <td class="transFrom" id="transComm"><?php
            if ($transInf['trans_mess'] == '') {
              echo 'Немає коментаря';
            } else {
            echo $transInf['trans_mess']; }?></td>
        </tr>
      <?php } ?>
      </table>
    </div>
  </div>

 </div>

 <div class="windBack" id="windTrans"> <!--Окно перевода-->
   <font class="xmark" color="white" size="6"><a href=""><i class="fa-solid fa-xmark"></i></a></font>
   <div class="windTrans">
     <font color="white" size="5">Переказ</font>
     <form class="" action="trans_bank.php" method="post"><br>
       <i id="downArrow" class="fa-solid fa-chevron-down"></i>
       <select class="pole1" id="poleSel" name="card_from" required>
         <?php foreach ($sel_card as $transCardName): ?>
           <option value="<?= $transCardName['card_name'] ?>"><?= $transCardName['card_name'] ?></option>
         <?php endforeach; ?>
       </select><br><br>
       <input type="number" name="trans_to" class="pole1" maxlength="4" placeholder="Введіть номер карти отримувача" required><br><br>
       <input type="number" name="trans_summa" class="pole1" placeholder="Введіть суму" required><br><br>
       <input type="text" name="trans_mess" class="pole1" maxlength="50" placeholder="Коментар (необов'язково)"><br><br>
       <button type="submit" class="OK">ОК</button><br><br>
     </form>
   </div>
 </div>

 <div class="windBack" id="windPenalt"> <!--Штрафы-->
   <font class="xmark" color="white" size="6"><a href=""><i class="fa-solid fa-xmark"></i></a></font>
   <div class="windTrans">
     <font color="white" size="5">Штрафи:</font><br><br>
     <?php if ($penaltyCount['count'] == 0) {echo '<p align="center"><font size="4" color="#828282">У вас поки що немає штрафів :)</font></p>';} else { ?>
     <form action="payPenalt.php" method="post">
     <i id="downArrowPenalt" class="fa-solid fa-chevron-down"></i>
     <select class="pole1" id="poleSel" name="penaltCardTo" required>
       <?php foreach ($sel_card as $transCardName): ?>
         <option value="<?= $transCardName['card_name'] ?>"><?= $transCardName['card_name'] ?></option>
       <?php endforeach; ?>
     </select><br><br>
     <?php foreach ($penalty1 as $penalt) { ?>
       <font color="#828282">
       Отримувач:<br>
       Дата:<br>
       №:<br>
       Причина:<br>
       Сума:
       </font>
       <div class="fineInf">
         <font color="white"><?=
         $penalt['penalt_from'] . '<br>' .
         $penalt['penalt_date'] . '<br>' .
         $penalt['penalt_id'] . '<br>' .
         $penalt['penalt_text'] . '<br>' .
         $penalt['penalt_sum'] . ' ИР'
         ?></font>
       </div>
       <input type="text" name="penaltId" class="pole1" id="invisibleInput" value="<?= $penalt['penalt_id'] ?>" readonly required>
       <button type="submit" class="OK" id="penaltButt">Сплатити</button><br><br>
       <hr color="#414141">
     </form> <?php } ?>
   <?php } ?>
   </div>
 </div>

</div>
<?php } ?>
</body>
</html>
<?php
  }
  mysqli_close($mysql);
?>
