<?php
 include("../connect.php");

 if($_COOKIE['user'] == ''){
   echo "<script>self.location='/index.php';</script>";
 } else {

 $sel_user = mysqli_query($mysql, "SELECT * FROM `user` WHERE `login` = '$_COOKIE[user]'");
 $sel = mysqli_fetch_assoc($sel_user);
?>
<!DOCTYPE html>
<html lang="ru">
 <head>
   <link rel="shortcut icon" href="/images/2_green.png" type="image/x-icon">
   <link rel="stylesheet" href="/CSS/menu.css">
   <link rel="stylesheet" href="/CSS/upMenu.css">
   <link rel="stylesheet" href="/CSS/content.css">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&display=swap" rel="stylesheet">
   <meta charset="utf-8" />
  <title>Головна</title>
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
        <li><a href="market.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-cart-shopping"></i> Ринок</p></a></li>
        <li><a href="#" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-file-circle-check"></i> Петиції</p></a></li>
        <li><a href="players.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-users"></i> Гравці</p></a></li>
        <li><a href="#" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-map-location-dot"></i> Мапа</p></a></li>
        <li><?php if ($role['role'] == 'admin') {
          echo '<a href="admin.php" target="content" id="text" class="panel"><p align="left"><i class="fa-solid fa-bars"></i> Панель</p></a>';
        } ?></li>
      </ul>
      </div>


      <div class="content"> <!--Основная часть сайта-->

   <?php
   $post_sel = mysqli_query($mysql, "SELECT * FROM `post` ORDER BY `post_id` DESC");
   $post_sel1 = mysqli_fetch_assoc($post_sel);
   ?>

   <div class="sortBy">
     <p><font color="grey" size="3">Сортировать по:</font></p>
     <select class="pole2" name="">
       <option value="">Дате загрузки</option>
       <option value="">Популярности</option>
     </select>
   </div>

   <div> <!--Новый пост-->
      <form id="upload" action="new_post.php" method="post" enctype="multipart/form-data">
        <div class="post">
         <img src="../images/ava_user.png" width="50px" height="50px" id="ava"> <textarea name="post_text" placeholder="Що нового, <?php echo $_COOKIE['user'] ?>?" class="pole1" id="new_post_pole" maxlength="5000" required></textarea>
         <font class="but_new">
           <input id="file-input" type="file" name="file" class="button" accept="image/*">
           <label for="file-input"><i class="fa-solid fa-image" id="but_new1"></i></label>
           <button type="submit" class="button" id="but_upl"></button>
           <label for="but_upl"><i class="fa-solid fa-arrow-right" id="but_new2"></i></label>
         </font>
         <div id="load"></div>
        </div>
      </form>
      <br>

      <script type="text/javascript">
        let load = document.querySelector('#load');

        document.querySelector('#file-input').addEventListener('change', function(e) {
          let tgt = e.target || window.event.srcElement,
                files = tgt.files;

          load.innerHTML = '';

          if(files && files.length) {
            for(let i = 0; i < files.length; i++) {
                let $self = files[i],
                        fr = new FileReader();
                fr.onload = function(e) {
                load.insertAdjacentHTML('beforeEnd', `<div class="load-img"><img src="${e.srcElement.result}"/></div>`);
                }
                fr.readAsDataURL(files[i]);
            };
          }
        });


        var textarea = document.querySelector('textarea');
        textarea.addEventListener('keyup', function(){
        if(this.scrollTop > 0){
          this.style.height = this.scrollHeight + "px";
        }
        });
      </script>
    </div>

      <!--Посты-->
      <?php
        foreach ($post_sel as $posts) {
      ?>

     <div class="post" id="<?= $posts['post_id'] ?>">
       <font color="white" size="4">
       <img src="../images/ava_user.png" width="50px" height="50px" id="ava"> <B><?= $posts['post_from'] ?></B></font><br>
       <font color="grey" size="2"><?= $posts['post_date'] ?></font><br>
       <p class="post_text"><font color="white" size="3"><?= $posts['post_text']  ?></font></p>

       <?php
         if ($posts['post_file'] == '') {} else { ?>
           <img src="<?php echo 'post_file/' . $posts['post_file']; ?>" class="post_file"> <?php
         }
        ?>

       <hr color="#414141">
       <font class="like" size="4"><i class="fa-regular fa-heart"></i> 6
       </font>
       <font size="4" class="additButt">
       <?php
        if ($role['role'] == 'admin' or $posts['post_from'] == $_COOKIE['user']) {
          echo '<a href="#postEdit-' . $posts['post_id'] . '"><i class="fa-regular fa-pen-to-square" id="postEdit"></i></a> <a href="#postDel-' . $posts['post_id'] . '"><i class="fa-regular fa-trash-can" id="postDel"></i></a>';
        }
       ?></font>
       <details>
         <summary class="watch_comm"><font size="4">
           <?php if ($posts['post_comm'] == 0) {
            echo 'Переглянути коментарі'; } else echo 'Переглянути коментарі (' . $posts['post_comm'] . ')';
           ?>
          </font></summary>
         <br><div class="comm">
             <form action="sent_comm.php" method="post">
              <img src="../images/ava_user.png" width="35px" height="35px" id="ava">
              <input type="text" name="comm_text" placeholder="Залиште коментар..." class="pole1" id="pole_comm" maxlength="500" required>
              <input type="text" name="post_id" class="pole1" id="invisibleInput" value="<?= $posts['post_id'] ?>" readonly required>
              <button type="submit" name="button" style="display:none;"></button>
              <script type="text/javascript">
                $(document).keydown(function(e) {
                  if(e.keyCode === 13) {
                    $("#searchForm").submit();
                  }
                });
              </script>
            </form>
            <br>

               <?php
                $postId = $posts['post_id'];
                $selComm = mysqli_query($mysql, "SELECT * FROM `post_comm` WHERE `post_id` = '$postId' ORDER BY `id` DESC");
                $selComm1 = mysqli_fetch_assoc($selComm);

                foreach ($selComm as $comms) {
               ?>

             <font color="white" size="3">
             <img src="../images/ava_user.png" width="35px" height="35px" id="ava"> <B><?= $comms['comm_from'] ?></B><br></font>
             <font color="grey" size="2"><?= $comms['comm_date'] ?></font><br>
             <font color="white" size="3"><?= $comms['comm_text'] ?></font><br><br>

             <?php } ?>
           </div>
       </details>
     </div><br>

     <div class="windBack" id="postEdit-<?= $posts['post_id'] ?>"> <!--Изменение поста-->
       <font class="xmark" color="white" size="6"><a href=""><i class="fa-solid fa-xmark"></i></a></font>
       <div class="wind">
         <font color="white" size="5">Зміна публікації</font>
         <form action="editPost.php" method="post"><br>
           <textarea name="editPostText" placeholder="Введіть новий вміст" class="pole2" id="editPostPole" maxlength="5000" required><?= $posts['post_text'] ?></textarea>
             <script type="text/javascript">
               var textarea = document.querySelector("#editPostPole");
               textarea.addEventListener('keyup', function(){
               if(this.scrollTop > 0){
                 this.style.height = this.scrollHeight + "px";
               }
               });
             </script>
             <font color="grey" size="2"><p align="center">(Якщо не видно повніть, натисніть стрілку вниз)</p></font>
           <input type="text" name="postId" class="pole1" id="invisibleInput" value="<?= $posts['post_id'] ?>" readonly required><br>
           <button type="submit" class="OK">ОК</button>
         </form>
       </div>
     </div>

     <div class="windBack" id="postDel-<?= $posts['post_id'] ?>"> <!--Удаление поста-->
       <font class="xmark" color="white" size="6"><a href=""><i class="fa-solid fa-xmark"></i></a></font>
       <div class="wind" id="windDel">
         <font color="white" size="5"><p align="center">Видалити публікацію?</p></font>
         <form action="delPost.php" method="post">
           <input type="text" name="post_id" class="pole1" id="invisibleInput" value="<?= $posts['post_id'] ?>" readonly required>
           <button type="submit" class="OK" id="okDel">Так</button>
         </form>
       </div>
     </div>
     <?php } ?>

</div>
 </body>
</html>
 <?php } ?>
