<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">INCA</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Vehículos <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Agregar</a></li>
                        <li><a href="#">Listados</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">E. Cómputo <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Agregar</a></li>
                        <li><a href="#">Listados</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mobiliario <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Agregar</a></li>
                        <li><a href="#">Listados</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="http://www.incamexico.com/es">Inca México</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo strtoupper($_SESSION['nombre']); ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php base_url() ?>index.php/dashboard/perfil">Perfil</a></li>
                        <li><a href="#">Resguardo</a></li>
                        <li><a href="#">Notificaciones</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="http://192.168.1.80/siga/index.php/sesion/cerrar">Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>