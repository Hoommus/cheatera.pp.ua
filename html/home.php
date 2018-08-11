      <h3 class="mt-5">
     cheatera.pp.ua   
</h3><h5 class="mt-5">
	  	<?php
	session_start();
	if ($_SESSION['cheat'] == session_id())
  	{ ?>
	     <p>Welcome, <? echo  $_SESSION['xlogin'] ?>!</p>
	<? }
	else
	{ ?>
    <p>Для авторизации воспользуйтесь кнопкой</p></h5>
    <a href="/login.php" class="btn btn-warning" style="margin:20px;">INTRA</a>
	  <? } ?>
<!--       <p class="lead">Это тестовый сайт, тут пилятся новые штуки для читеров.</p> -->
<!--       <p>Читера находятся по адресу <a href="//cheatera.pp.ua">cheatera.pp.ua</a></p> -->