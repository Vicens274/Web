<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$rol = $is_logged_in ? $_SESSION['rol'] : '';
$usuario = $is_logged_in ? $_SESSION['username'] : '';
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #3552A6 !important; border-bottom: 2px solid white !important;">
    <div class="container-fluid">
        <a href="../../index.php">
            <img class="logo navbar-brand" style="margin-right: -2em !important;" src="../../Imagenes/logoGalileo.png"></img>
        </a>
        <button class="navbar-toggler" style="color: white !important; border-color: white !important; padding: 2px 3px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon-custom navbar-toggler-icon"></span>
        </button>
        <div class="menu-posicion collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="menu nav-link" aria-current="page" href="../../index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="menu nav-link" href="../../menu.php">Información</a>
                </li>
                <li class="nav-item">
                    <a class="menu nav-link" href="../../contactanos.php">Contáctanos</a>
                </li>
            </ul>
            <div>
                <?php if ($is_logged_in) : ?>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white !important;">
                                <?php echo $usuario; ?> 
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Rol: <?php echo $rol; ?></a></li>
                                <li><a class="dropdown-item" href="../../añadir/crud.php">Administradores</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../../añadir/logout.php">Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php else : ?>
                    <a class="d-flex" style="text-decoration: none !important;" href="../../categorias.php">
                        <button type="button" class="mayuscula btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background-color: #6BE5DA !important; color: #3552A6 !important; border-radius: 4px !important; border-color: #6BE5DA !important; font-weight: bold !important;">
                            Identifícate
                        </button>
                    </a>
                    <form id="loginForm"></form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>