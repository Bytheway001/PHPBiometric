<?php ob_start() ?>
<header>
<nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="#">ALIMENTOS LC</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
       <a class="nav-link" href="/">Inicio<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
       <a class="nav-link" href="/employees/login">Biometrico</a>
      </li>
      <li class="nav-item dropdown">
         <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">       Nómina
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/users/nomina">Reporte de Nómina</a>
          <a class="dropdown-item" href="/employees/newbaja">Registrar Baja</a>
        </div>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <a class='nav-link' href="/users/deauthenticate"><i class="fa fa-sign-out fa-lg"></i>Cerrar Sesión</a>
    </ul>
</nav>
</header>
<?php $navbar=ob_get_clean() ?>