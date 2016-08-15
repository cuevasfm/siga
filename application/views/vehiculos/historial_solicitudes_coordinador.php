<?php
setlocale(LC_ALL, "es_MX.UTF-8");
date_default_timezone_set("America/Mexico_City");
if (date('l') == 'Sunday' or date('l') == 'Monday' or date('l') == 'Tuesday' or date('l') == 'Wednesday' or date('l') == 'Thursday') {
    $fecha = strftime("%A, %d de %B de %Y", strtotime('next friday'));
    $fechasql = date("Y-m-d", strtotime('next friday'));
    //  echo '<div class="alert alert-warning" role="alert">Servicios programados para el: <strong>' . $fecha . '</strong></div>';
} elseif (date('l') == 'Friday') {
    $fecha = strftime("%A, %d de %B de %Y", strtotime('friday'));
    $fechasql = date("Y-m-d", strtotime('friday'));
    //  echo '<div class="alert alert-warning" role="alert">Servicios programados para el: <strong>' . $fecha . '</strong></div>';
} else {
    $fecha = strftime("%A, %d de %B de %Y", strtotime('last friday'));
    $fechasql = trim(date("Y-m-d", strtotime('last friday')));
    // echo '<div class="alert alert-warning" role="alert">Servicios programados para el: <strong>' . $fecha . '</strong></div>';
}
?>
<div class="page-header">
    <h3>Solicitudes de servicios / reparaciones programados para el: <?php echo $fecha; ?> <small><?php echo ''; ?></small></h3>
</div>
<?php
$query = $this->db->query('SELECT servicio_vehicular.idvehiculo, idservicio_vehicular, idsolicitante, costo_neto, observaciones, fecha_servicio, placas, nombre, ap_paterno, servicio_vehicular.mediode_pago, vehiculos.usuario_actual FROM `servicio_vehicular` join vehiculos on servicio_vehicular.idvehiculo = vehiculos.idvehiculo join usuarios on servicio_vehicular.idsolicitante = usuarios.id where servicio_vehicular.estatus_autorizacion = "0" and servicio_vehicular.fecha_servicio = "' . $fechasql . '" ORDER BY  idservicio_vehicular DESC');
$query_auto = $this->db->query('SELECT servicio_vehicular.idvehiculo, idservicio_vehicular, idsolicitante, costo_neto, observaciones, fecha_servicio, placas, nombre, ap_paterno, servicio_vehicular.mediode_pago, vehiculos.usuario_actual FROM `servicio_vehicular` join vehiculos on servicio_vehicular.idvehiculo = vehiculos.idvehiculo join usuarios on servicio_vehicular.idsolicitante = usuarios.id where servicio_vehicular.estatus_autorizacion = "1" and servicio_vehicular.fecha_servicio = "' . $fechasql . '" ORDER BY  idservicio_vehicular DESC');
if ($query->num_rows() > 0) {

    echo '<form method="post" action="' . base_url() . 'index.php/vehiculos/autorizarservicio">';
    echo '<table class="table table-hover" style="font-size: 12px">
    <caption class="text-center" style="color: black; font-size: 16px;"><strong>SOLICITUDES SIN AUTORIZAR</strong></caption>
    <tr>
        <th>IdServicio</th>
        <th>Bitácora de Mtto</th>
        <th>Solicitante</th>
        <th>Usuario</th>
        <th>Costo</th>
        <th>Servicio/Reparación</th>
        <th>Medio de pago</th> 
       
    </tr>';
    $costo_semana = 0;
    $costo_edenred = 0;
    $costo_transferencia = 0;
    $costo_transferencia_usuario = 0;
    $costo_no_especificado = 0;
    $balanceedenred = 0;
    foreach ($query->result() as $row2) {
        $queryusuariovehiculo = $this->db->query('SELECT nombre, ap_paterno, ap_materno FROM usuarios WHERE id = ' . $row2->usuario_actual);
        foreach ($queryusuariovehiculo->result() as $usuariov) {
            $usuarionombre = $usuariov->nombre;
            $usuarioap_paterno = $usuariov->ap_paterno;
            $usuarioap_materno = $usuariov->ap_materno;
        }
        if ($row2->mediode_pago == 0) {
            $mediodepago = 'No especificado';
        } elseif ($row2->mediode_pago == 1) {
            $mediodepago = 'EdenRed';
        } elseif ($row2->mediode_pago == 2) {
            $mediodepago = '<a target="_blank" href = "' . base_url() . 'index.php/vehiculos/solicituddepagos/' . $row2->idservicio_vehicular . '/' . $row2->mediode_pago . '/">SPEI Proveedor</a>';
        } elseif ($row2->mediode_pago == 3) {
            $mediodepago = 'SPEI usuario';
        }
        echo '<tr>';
        echo '<td>' . $row2->idservicio_vehicular . '</td>';
        // echo '<td><a href = "' . base_url() . 'index.php/bitacora/vehiculo/' . $row2->idvehiculo . '">' . $row2->placas . '</a></td>';
        echo '<td>' . $row2->placas . '</td>';
        echo '<td>' . $row2->nombre . ' ' . $row2->ap_paterno . '</td>';
        echo '<td>' . $usuarionombre . ' ' . $usuarioap_paterno . '</td>';
        echo '<td>' . money_format('%= (#6.2n', $row2->costo_neto) . '</td>';
        echo '<td>' . mb_strtoupper($row2->observaciones) . '</td>';
        echo '<td>' . $mediodepago . '</td>';
        echo '</tr>';
        if ($row2->mediode_pago == 1) {
            $costo_edenred = $costo_edenred + $row2->costo_neto;
        } elseif ($row2->mediode_pago == 2) {
            $costo_transferencia = $costo_transferencia + $row2->costo_neto;
        } elseif ($row2->mediode_pago == 3) {
            $costo_transferencia_usuario = $costo_transferencia_usuario + $row2->costo_neto;
        }
        $costo_semana = $costo_semana + $row2->costo_neto;
    }


    echo '</table> ';
    // echo '<dl class="dl-horizontal">';
    echo ' IMPORTE DE LA SOLICITUDES NO AUTORIZADAS DE ESTA SEMANA: <strong> ' . money_format('%= (#6.2n', $costo_semana) . '</strong> <br>';
    // echo ' Trasnferencia a Proveedor:<strong> ' . money_format('%= (#6.2n', $costo_transferencia) . '</strong><br>';
    // echo ' Trasnferencia a Usuario: <strong> ' . money_format('%= (#6.2n', $costo_transferencia_usuario) . '</strong><br>';
    // echo ' Total a Solicitar EdenRed: <strong> ' . money_format('%= (#6.2n', $costo_edenred) . '</strong><br>';
    // echo ' Importe EdenRed no ejecutado: <strong> ' . money_format('%= (#6.2n', $edenrednegativo) . '</strong><br>';
    //  echo ' Total a Solicitar EdenRed: <strong> ' . money_format('%= (#6.2n', $balanceedenred) . '</strong> <br>';
    // echo '</dl>';
    // echo '<button type="submit" class="btn btn-info">Autorizar servicios</button></form>';
    // echo 'El importe de solicitudes sin autorizar es: '.money_format('%= (#6.2n', $costo_semana);
} else {
    echo 'Todas las solicitudes de esta semana estan autorizadas';
}


if ($query_auto->num_rows() > 0) {

    echo '<form method="post" action="' . base_url() . 'index.php/vehiculos/autorizarservicio">';
    echo '<table class="table table-hover" style="font-size: 12px">
    <caption class="text-center" style="color: black; font-size: 16px;"><strong>SOLICITUDES AUTORIZADAS</strong></caption>
    <tr>
        <th>IdServicio</th>
        <th>Bitácora de Mtto</th>
        <th>Solicitante</th>
        <th>Usuario</th>
        <th>Costo</th>
        <th>Servicio/Reparación</th>
        <th>Medio de pago</th> 
       
    </tr>';
    $costo_semana = 0;
    $costo_edenred = 0;
    $costo_transferencia = 0;
    $costo_transferencia_usuario = 0;
    $costo_no_especificado = 0;
    $balanceedenred = 0;
    foreach ($query_auto->result() as $row2) {
        $queryusuariovehiculo = $this->db->query('SELECT nombre, ap_paterno, ap_materno FROM usuarios WHERE id = ' . $row2->usuario_actual);
        foreach ($queryusuariovehiculo->result() as $usuariov) {
            $usuarionombre = $usuariov->nombre;
            $usuarioap_paterno = $usuariov->ap_paterno;
            $usuarioap_materno = $usuariov->ap_materno;
        }
        if ($row2->mediode_pago == 0) {
            $mediodepago = 'No especificado';
        } elseif ($row2->mediode_pago == 1) {
            $mediodepago = 'EdenRed';
        } elseif ($row2->mediode_pago == 2) {
            $mediodepago = '<a target="_blank" href = "' . base_url() . 'index.php/vehiculos/solicituddepagos/' . $row2->idservicio_vehicular . '/' . $row2->mediode_pago . '/">SPEI Proveedor</a>';
        } elseif ($row2->mediode_pago == 3) {
            $mediodepago = 'SPEI usuario';
        }
        echo '<tr>';
        echo '<td>' . $row2->idservicio_vehicular . '</td>';
        // echo '<td><a href = "' . base_url() . 'index.php/bitacora/vehiculo/' . $row2->idvehiculo . '">' . $row2->placas . '</a></td>';
        echo '<td>' . $row2->placas . '</td>';
        echo '<td>' . $row2->nombre . ' ' . $row2->ap_paterno . '</td>';
        echo '<td>' . $usuarionombre . ' ' . $usuarioap_paterno . '</td>';
        echo '<td>' . money_format('%= (#6.2n', $row2->costo_neto) . '</td>';
        echo '<td>' . mb_strtoupper($row2->observaciones) . '</td>';
        echo '<td>' . $mediodepago . '</td>';
        echo '</tr>';
        if ($row2->mediode_pago == 1) {
            $costo_edenred = $costo_edenred + $row2->costo_neto;
        } elseif ($row2->mediode_pago == 2) {
            $costo_transferencia = $costo_transferencia + $row2->costo_neto;
        } elseif ($row2->mediode_pago == 3) {
            $costo_transferencia_usuario = $costo_transferencia_usuario + $row2->costo_neto;
        }
        $costo_semana = $costo_semana + $row2->costo_neto;
    }


    echo '</table> ';
    // echo '<dl class="dl-horizontal">';
    echo ' IMPORTE DE LA SOLICITUDES AUTORIZADAS DE ESTA SEMANA: <strong> ' . money_format('%= (#6.2n', $costo_semana) . '</strong> <br>';
    // echo ' Trasnferencia a Proveedor:<strong> ' . money_format('%= (#6.2n', $costo_transferencia) . '</strong><br>';
    // echo ' Trasnferencia a Usuario: <strong> ' . money_format('%= (#6.2n', $costo_transferencia_usuario) . '</strong><br>';
    // echo ' Total a Solicitar EdenRed: <strong> ' . money_format('%= (#6.2n', $costo_edenred) . '</strong><br>';
    // echo ' Importe EdenRed no ejecutado: <strong> ' . money_format('%= (#6.2n', $edenrednegativo) . '</strong><br>';
    //  echo ' Total a Solicitar EdenRed: <strong> ' . money_format('%= (#6.2n', $balanceedenred) . '</strong> <br>';
    // echo '</dl>';
    // echo '<button type="submit" class="btn btn-info">Autorizar servicios</button></form>';
    // echo 'El importe de solicitudes sin autorizar es: '.money_format('%= (#6.2n', $costo_semana);
} else {
    echo 'Todas las solicitudes de esta semana estan autorizadas';
}

$query = $this->db->query('select idservicio_vehicular, placas, fecha_solicitud, estatus_autorizacion, costo_neto, observaciones, mediode_pago, modelo, usuario, nombre, ap_paterno, ap_materno, email from servicio_vehicular join vehiculos on servicio_vehicular.idvehiculo = vehiculos.idvehiculo join usuarios on   vehiculos.usuario_actual = usuarios.id where idsolicitante = ' . $_SESSION['id'] . ' ORDER BY idservicio_vehicular DESC ');

if ($query->num_rows() > 0) {
    ?>
<br><br>
    <h3>Historial de las ultimas solicitudes de servicios / reparaciones <small></small></h3>
    <table class="table table-hover" style="font-size: 12px">
        <tr>
            <th>Id </th>
            <th>Placas</th>
            <th>fecha solicitud</th>
            <th>Servicio / Reparación</th>
            <th>Costo total</th>
            <th>modelo</th>
            <th>Usuario</th>
            <th>E-mail Usuario</th>
            <th>Medio de pago</th>
            <th>Autorizado</th>
            <th></th>
        </tr>
        <?php
        foreach ($query->result() as $row) {
            echo '<tr>';
            echo '<td>' . $row->idservicio_vehicular . '</td>';
            echo '<td>' . $row->placas . '</td>';
            echo '<td>' . $row->fecha_solicitud . '</td>';
            echo '<td>' . $row->observaciones . '</td>';
            echo '<td>' . $row->costo_neto . '</td>';
            echo '<td>' . $row->modelo . '</td>';
            echo '<td>' . $row->nombre . ' ' . $row->ap_paterno . ' ' . $row->ap_materno . '</td>';
            echo '<td>' . $row->email . '</td>';
            if ($row->mediode_pago == 1) {
                $mediodepago = 'EdenRed';
            } elseif ($row->mediode_pago == 2) {
                $mediodepago = 'Trasnferencia Proveedor';
            } elseif ($row->mediode_pago == 3) {
                $mediodepago = 'Trasnferencia Usuario';
            } else {
                $mediodepago = 'No especificado';
            }
            echo '<td>' . $mediodepago . '</td>';
            if ($row->estatus_autorizacion == 0) {
                $autorizado = 'No';
            } else {
                $autorizado = 'Si';
            }
            echo '<td>' . $autorizado . '</td>';
            echo '</tr>';
        }
    } else {
        echo 'no existen resultados para esta solicitud ';
    }
    ?></table>