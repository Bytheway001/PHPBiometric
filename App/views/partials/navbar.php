<?php ob_start() ?>
<nav class="navbar navbar-static-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="/"><?= TEXT['home'] ?></a></li>
        <li><a href="/employees/login"><?= TEXT['biometric'] ?></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= TEXT['payroll'] ?><span class="caret"></span></a>
          <ul class="dropdown-menu">

            <li><a href="/users/nomina"><?= TEXT['payroll_report'] ?></a></li>
          </ul> 
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= TEXT['settings'] ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
           <li><a href="/devices"><?= TEXT['devices'] ?></a></li>
           <li><a href="/feriados"><?= TEXT['holidays'] ?></a></li>
           <li><a href="/settings"><?= TEXT['setup'] ?></a></li>
         </ul>
       </li>
       <li><a href="/users/help"><?= TEXT['help'] ?></a></li>
     </ul>
     <ul class="nav navbar-nav navbar-right">
      <li><a href="/users/deauthenticate"><?= TEXT['logout'] ?></a></li>

      <p class="navbar-text"><span id='time'>60:00</span></p>
    </ul>
  </div> 
</div>
</nav>
<?php $navbar=ob_get_clean() ?>