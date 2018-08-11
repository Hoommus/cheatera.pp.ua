<header>
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="/"><img width="17px" src="//cheatera.pp.ua/icon_uf.png"></img></a>
<!--     <a class="navbar-brand" href="/">Cheatera.pp.ua</a> -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item <? if ($_GET['course'] == 'bastards') echo "active" ?>">
          <a class="nav-link" href="/bastards/">Bastards</a>
        </li>
        <li class="nav-item <? if ($_GET['course'] == 'students') echo "active" ?>">
          <a class="nav-link" href="/students/">Students</a>
        </li>
        <?php if ($_GET['course'] != '404' && $_GET['course']) { ?>
          <li class="nav-item <? if ($_GET['page'] == 'projects') echo "active" ?>">
            <a class="nav-link" href="/<?php echo $_GET['course']?>/projects/">Projects</a>
          </li>
          <li class="nav-item <? if ($_GET['page'] == 'cheat') echo "active" ?>">
            <a class="nav-link" href="/<?php echo $_GET['course']?>/cheat/">-42</a>
          </li>
        <? } ?>
      </ul>
<!--   
      <form class="form-inline mt-2 mt-md-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
-->
       <a class="nav-link disabled" href="https://t.me/unit2k17" target="_blank">Telegram Chat</a>
    </div>
  </nav>
</header>