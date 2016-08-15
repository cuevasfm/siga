<?php
$id = $_SESSION['id'];
$query = $this->db->query('SELECT img_perfil FROM usuarios WHERE id = "' . $id . '"');
if ($query->num_rows() > 0) {
    foreach ($query->result() as $row) {
        $img_perfil = $row->img_perfil;
        if ($row->img_perfil == null) {
            $img_perfil = "ninguna.jpg";
        }
    }
}
?>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url() ?>"><img alt="INCA" width="25" height="25" src="<?php echo base_url() ?>/media/brand-inca.png"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Vehículos <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url() ?>index.php/vehiculos/nuevo">Agregar(admin)</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/vehiculos">Inventario(admin)</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/vehiculos/solicitudservicio">Solicitar servicio</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/vehiculos/historialsolicitudservicio">Historial de solicitudes </a></li>
                        <li><a href="<?php echo base_url() ?>index.php/bitacora">Bitácora de servicios</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/vehiculos/programaciondemantenimiento">Programación de mantenimiento</a></li>
                        <li><a href="<?php echo base_url() ?>">Polizas de seguro</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/vehiculos/asignacion/">Asignación vehicular</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/vehiculos/asigcoordinador/">Asignación de coordinador administrativo</a></li>
                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Obras <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url() ?>index.php/obras/nueva">Agregar</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/obras">Catalogo</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuarios <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url() ?>index.php/sesion/nuevo">Nuevo</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/sesion/">Listados</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Inventarios <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url() ?>">Por usuario</a></li>
                        <li><a href="<?php echo base_url() ?>">Por obra</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <!--                <li><a href="http://www.incamexico.com/es">Inca México</a></li>
                                <li><a href="<?php echo base_url() ?>" title="Notificaciones"><span class="glyphicon glyphicon-bell" aria-hidden="true"></span>(2)</a></li>-->
                <li><a class="navbar-brand" href="<?php echo base_url() ?>"><img alt="INCA" width="24" class="img-circle" src="<?php echo base_url() ?>subidas/<?php echo $img_perfil ?>"></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo strtoupper($_SESSION['nombre']); ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url() ?>index.php/dashboard/perfil"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Perfil</a></li>
                        <li><a href="<?php echo base_url() ?>"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span>Resguardo</a></li>
                        <li><a href="<?php echo base_url() ?>"><span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span>Notificaciones</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url() ?>index.php/sesion/cerrar"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<br><br>