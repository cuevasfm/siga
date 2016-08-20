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
    //   echo '<div class="alert alert-warning" role="alert">Servicios programados para el: <strong>' . $fecha . '</strong></div>';
}
$edenrednegativo = 0;
$fecha7m = date("Y-m-d", strtotime(" last friday"));
$query4 = $this->db->query('SELECT * FROM servicio_vehicular where estatus_autorizacion = 1 AND `check` = 0 AND fecha_autorizado <= "' . $fecha7m . '" ');
if ($query4->num_rows() > 0) {
    foreach ($query4->result() as $row0) {
        if ($row0->mediode_pago == 1) {
            $edenrednegativo = $edenrednegativo + $row0->costo_neto;
        }
    }
}
?>
<br>
<div class="col-xs-12">
    <div class="col-xs-3" >
        <img src="<?php echo base_url(); ?>media/logo_inca.jpg" width="180px">
    </div>
    <div class="col-xs-5" ><br>

    </div>
    <div class="col-xs-4" >
        <strong>FECHA DE SERVICIO: <?php echo $fecha; ?> </strong>
    </div>
</div>
<div class="col-xs-12" >
    <p class="text-center" style="font-size: 16px; color: #770b4b "><strong>PROGRAMACIÓN DE MANTENIMIENTO</strong></p>
</div>
<?php
// ------INICIO DE SOLITUDES POR AUTORIZAR--------
$query = $this->db->query('SELECT servicio_vehicular.idvehiculo, idservicio_vehicular, idsolicitante, costo_neto, observaciones, fecha_servicio, placas, nombre, ap_paterno, servicio_vehicular.mediode_pago, vehiculos.usuario_actual FROM `servicio_vehicular` join vehiculos on servicio_vehicular.idvehiculo = vehiculos.idvehiculo join usuarios on servicio_vehicular.idsolicitante = usuarios.id where servicio_vehicular.estatus_autorizacion = "0" and servicio_vehicular.fecha_servicio = "' . $fechasql . '" ORDER BY  idservicio_vehicular DESC');
if ($query->num_rows() > 0) {
    echo '<table class="table table-hover" style="font-size: 12px">
    <tr>
    <caption class="text-center" style="color: black; font-size: 14px;"><strong>IMPORTES TOTALES DE LOS SERVICIOS / REPARACIONES NO AUTORIZADOS</strong></caption>
        <th class="text-center" style="width: 5%; background-color: #770b4b !important; color: white !important;">ID </th>
        <th class="text-center" style="width: 12%; background-color: #770b4b !important; color: white !important;">PLACAS</th>
        <th class="text-center" style="width: 17%; background-color: #770b4b !important; color: white !important;">USUARIO ASIGNADO</th>
        <th class="text-center" style="width: 12%; background-color: #770b4b !important; color: white !important;">COSTO</th>
        <th class="text-center" style="width: 42%; background-color: #770b4b !important; color: white !important;">SERVICIO / REPARACIONES</th>
        <th class="text-center" style="width: 12%; background-color: #770b4b !important; color: white !important;">MEDIO DE PAGO</th>      

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
            $mediodepago = 'SPEI proveedor';
        } elseif ($row2->mediode_pago == 3) {
            $mediodepago = 'SPEI usuario';
        }
        echo '<tr>';
        echo '<td class="text-center">' . $row2->idservicio_vehicular . '</td>';
        echo '<td class="text-center">' . $row2->placas . '</td>';
        echo '<td class="text-center">' . mb_strtoupper($usuarionombre . ' ' . $usuarioap_paterno) . '</td>';
        echo '<td class="text-center">' . money_format('%= (#6.2n', $row2->costo_neto) . '</td>';
        echo '<td class="text-center">' . mb_strtoupper($row2->observaciones, 'UTF-8') . '</td>';
        //  echo '<td class="text-center">' . $row2->fecha_servicio . '</td>';
        echo '<td class="text-center">' . $mediodepago . '</td>';
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
    $balanceedenred = $costo_edenred - $edenrednegativo;

    echo '</table> ';
    ?>
    <table class="table table-hover" style="font-size: 12px;">
        <tr>
        <caption class="text-center" style="color: black; font-size: 16px;"><strong>IMPORTES TOTALES DE LA SOLICITUDES</strong></caption>
        <th class="text-center" style="width: 17%; background-color: gray !important; color: white !important; font-size: 12px;">IMPORTE DE SOLICITUDES:</th>
        <th class="text-center" style="width: 16%; background-color: gray !important; color: white !important; font-size: 12px;">TRANSFERENCIA A PROVEEDOR</th>
        <th class="text-center" style="width: 17%; background-color: gray !important; color: white !important; font-size: 12px;">TRANSFERENCIA A USUARIO:</th>
        <th class="text-center" style="width: 16%; background-color: gray !important; color: white !important; font-size: 12px;">SUBTOTAL A SOLICITAR EDENRED</th>
        <th class="text-center" style="width: 17%; background-color: gray !important; color: white !important; font-size: 12px;">IMPORTE EDENRED NO EJECUTADO </th>
        <th class="text-center" style="width: 17%; background-color: gray !important; color: white !important; font-size: 12px;">TOTAL A SOLICITAR EDENRED</th>
    </tr>
    <tr>
        <td class="text-center" style="font-size: 14px;"><?php echo money_format('%= (#6.2n', $costo_semana); ?></td>
        <td class="text-center" style="font-size: 14px;"><?php echo money_format('%= (#6.2n', $costo_transferencia); ?></td>
        <td class="text-center" style="font-size: 14px;"><?php echo money_format('%= (#6.2n', $costo_transferencia_usuario); ?></td>
        <td class="text-center" style="font-size: 14px;"><?php echo money_format('%= (#6.2n', $costo_edenred); ?></td>
        <td class="text-center" style="font-size: 14px;"><?php echo money_format('%= (#6.2n', $edenrednegativo); ?></td>
        <td class="text-center" style="font-size: 18px;"><strong><?php echo money_format('%= (#6.2n', $balanceedenred); ?></strong> </td>
    </tr>

    </table>

    <?php
//    echo '<br> <br> Importe de Solicitudes: <strong> ' . money_format('%= (#6.2n', $costo_semana) . '</strong> <br>';
//    echo ' Trasnferencia a Proveedor:<strong> ' . money_format('%= (#6.2n', $costo_transferencia) . '</strong><br>';
//    echo ' Trasnferencia a Usuario: <strong> ' . money_format('%= (#6.2n', $costo_transferencia_usuario) . '</strong><br>';
//    echo ' Subtotal a Solicitar EdenRed: <strong> ' . money_format('%= (#6.2n', $costo_edenred) . '</strong><br>';
//    echo ' Importe EdenRed no ejecutado: <strong> ' . money_format('%= (#6.2n', $edenrednegativo) . '</strong><br>';
//    echo ' Total a Solicitar EdenRed: <strong> ' . money_format('%= (#6.2n', $balanceedenred) . '</strong> <br>';
} else {
    echo 'Todas las solicitudes para esta semana estan autorizadas <br><br>';
}
// ------FIN--------
// ------INICIO DE SOLITUDES AUTORIZADAS--------
$queryautorizadas = $this->db->query('SELECT servicio_vehicular.idvehiculo, idservicio_vehicular, idsolicitante, costo_neto, observaciones, fecha_servicio, placas, nombre, ap_paterno, servicio_vehicular.mediode_pago, servicio_vehicular.fecha_autorizado, servicio_vehicular.fecha_solicitud, vehiculos.usuario_actual FROM `servicio_vehicular` join vehiculos on servicio_vehicular.idvehiculo = vehiculos.idvehiculo join usuarios on servicio_vehicular.idsolicitante = usuarios.id where `check` = 0 and `estatus_autorizacion` = "1" ORDER BY  idservicio_vehicular DESC');

if ($queryautorizadas->num_rows() > 0) {
    echo '<table class="table table-hover" style="font-size: 12px">
        
    <tr>
     <caption class="text-center" style="width: 100%; font-size: 16px; background-color: #770b4b !important; color: white !important;">SOLICITUD DE SERVICIO / REPARACION AUTORIZADO</caption>
        <th class="text-center" style="width: 5%; background-color: #770b4b !important; color: white !important;">ID </th>
        <th class="text-center" style="width: 12%; background-color: #770b4b !important; color: white !important;">PLACAS</th>
        <th class="text-center" style="width: 17%; background-color: #770b4b !important; color: white !important;">USUARIO ASIGNADO</th>
        <th class="text-center" style="width: 12%; background-color: #770b4b !important; color: white !important;">COSTO</th>
        <th class="text-center" style="width: 42%; background-color: #770b4b !important; color: white !important;">SERVICIO / REPARACIONES</th>
        <th class="text-center" style="width: 12%; background-color: #770b4b !important; color: white !important;">MEDIO DE PAGO</th>      

    </tr>';
    $costo_semana = 0;
    $costo_edenred = 0;
    $costo_transferencia = 0;
    $costo_transferencia_usuario = 0;
    $costo_no_especificado = 0;
    $balanceedenred = 0;
    foreach ($queryautorizadas->result() as $row_au) {
        $queryusuariovehiculo = $this->db->query('SELECT nombre, ap_paterno, ap_materno FROM usuarios WHERE id = ' . $row_au->usuario_actual);
        foreach ($queryusuariovehiculo->result() as $usuariov) {
            $usuarionombre = $usuariov->nombre;
            $usuarioap_paterno = $usuariov->ap_paterno;
            $usuarioap_materno = $usuariov->ap_materno;
        }
        if ($row_au->mediode_pago == 0) {
            $mediodepago = 'No especificado';
        } elseif ($row_au->mediode_pago == 1) {
            $mediodepago = 'EdenRed';
        } elseif ($row_au->mediode_pago == 2) {
            $mediodepago = 'SPEI proveedor';
        } elseif ($row_au->mediode_pago == 3) {
            $mediodepago = 'SPEI usuario';
        }
        echo '<tr>';
        echo '<td class="text-center">' . $row_au->idservicio_vehicular . '</td>';
        echo '<td class="text-center">' . $row_au->placas . '</td>';
        echo '<td class="text-center">' . mb_strtoupper($usuarionombre . ' ' . $usuarioap_paterno) . '</td>';
        echo '<td class="text-center">' . money_format('%= (#6.2n', $row_au->costo_neto) . '</td>';
        echo '<td class="text-center">' . mb_strtoupper($row_au->observaciones, 'UTF-8') . '</td>';
        //  echo '<td class="text-center">' . $row2->fecha_servicio . '</td>';
        echo '<td class="text-center">' . $mediodepago . '</td>';
        echo '</tr>';
        if ($row_au->mediode_pago == 1) {
            $costo_edenred = $costo_edenred + $row_au->costo_neto;
        } elseif ($row_au->mediode_pago == 2) {
            $costo_transferencia = $costo_transferencia + $row_au->costo_neto;
        } elseif ($row_au->mediode_pago == 3) {
            $costo_transferencia_usuario = $costo_transferencia_usuario + $row_au->costo_neto;
        }
        $costo_semana = $costo_semana + $row_au->costo_neto;
    }
    $balanceedenred = $costo_edenred - $edenrednegativo;

    echo '</table> ';
    ?>
    <table class="table table-hover" style="font-size: 12px;">
        <tr>
        <caption class="text-center" style="color: black; font-size: 16px;"><strong>IMPORTES TOTALES DE LOS SERVICIOS / REPARACIONES AUTORIZADOS</strong></caption>
        <th class="text-center" style="width: 17%; background-color: gray !important; color: white !important; font-size: 12px;">IMPORTE DE SOLICITUDES:</th>
        <th class="text-center" style="width: 16%; background-color: gray !important; color: white !important; font-size: 12px;">TRANSFERENCIA A PROVEEDOR</th>
        <th class="text-center" style="width: 17%; background-color: gray !important; color: white !important; font-size: 12px;">TRANSFERENCIA A USUARIO:</th>
        <th class="text-center" style="width: 16%; background-color: gray !important; color: white !important; font-size: 12px;">SUBTOTAL A SOLICITAR EDENRED</th>
        <th class="text-center" style="width: 17%; background-color: gray !important; color: white !important; font-size: 12px;">IMPORTE EDENRED NO EJECUTADO </th>
        <th class="text-center" style="width: 17%; background-color: gray !important; color: white !important; font-size: 12px;">TOTAL A SOLICITAR EDENRED</th>
    </tr>
    <tr>
        <td class="text-center" style="font-size: 14px;"><?php echo money_format('%= (#6.2n', $costo_semana); ?></td>
        <td class="text-center" style="font-size: 14px;"><?php echo money_format('%= (#6.2n', $costo_transferencia); ?></td>
        <td class="text-center" style="font-size: 14px;"><?php echo money_format('%= (#6.2n', $costo_transferencia_usuario); ?></td>
        <td class="text-center" style="font-size: 14px;"><?php echo money_format('%= (#6.2n', $costo_edenred); ?></td>
        <td class="text-center" style="font-size: 14px;"><?php echo money_format('%= (#6.2n', $edenrednegativo); ?></td>
        <td class="text-center" style="font-size: 18px;"><strong><?php echo money_format('%= (#6.2n', $balanceedenred); ?></strong> </td>
    </tr>

    </table>

    <?php
//    echo '<br> <br> Importe de Solicitudes: <strong> ' . money_format('%= (#6.2n', $costo_semana) . '</strong> <br>';
//    echo ' Trasnferencia a Proveedor:<strong> ' . money_format('%= (#6.2n', $costo_transferencia) . '</strong><br>';
//    echo ' Trasnferencia a Usuario: <strong> ' . money_format('%= (#6.2n', $costo_transferencia_usuario) . '</strong><br>';
//    echo ' Subtotal a Solicitar EdenRed: <strong> ' . money_format('%= (#6.2n', $costo_edenred) . '</strong><br>';
//    echo ' Importe EdenRed no ejecutado: <strong> ' . money_format('%= (#6.2n', $edenrednegativo) . '</strong><br>';
//    echo ' Total a Solicitar EdenRed: <strong> ' . money_format('%= (#6.2n', $balanceedenred) . '</strong> <br>';
} else {
    echo 'No existen solicitudes autorizadas';
}

// -------- FIN ---------
// 
// 
// ------INICIO DE SOLITUDES REAGENDADAS, O REZAGADAS--------

$queryreagendadas = $this->db->query('SELECT servicio_vehicular.idvehiculo, idservicio_vehicular, idsolicitante, costo_neto, observaciones, fecha_servicio, placas, nombre, ap_paterno, servicio_vehicular.mediode_pago, vehiculos.usuario_actual FROM `servicio_vehicular` join vehiculos on servicio_vehicular.idvehiculo = vehiculos.idvehiculo join usuarios on servicio_vehicular.idsolicitante = usuarios.id where `check` = 0 and `estatus_autorizacion` = "0" and servicio_vehicular.fecha_servicio != "' . $fechasql . '" ORDER BY  idservicio_vehicular DESC');

if ($queryreagendadas->num_rows() > 0) {
    echo '<table class="table table-hover" style="font-size: 12px">
        
    <tr>
     <caption class="text-center" style="width: 100%; font-size: 16px; background-color: #770b4b !important; color: white !important;">SOLICITUDES DE SERVICIO / REPARACIÓN FUERA DE FECHA O REAGENDADOS</caption>
        <th class="text-center" style="width: 5%; background-color: #770b4b !important; color: white !important;">ID </th>
        <th class="text-center" style="width: 12%; background-color: #770b4b !important; color: white !important;">PLACAS</th>
        <th class="text-center" style="width: 17%; background-color: #770b4b !important; color: white !important;">USUARIO ASIGNADO</th>
        <th class="text-center" style="width: 12%; background-color: #770b4b !important; color: white !important;">COSTO</th>
        <th class="text-center" style="width: 42%; background-color: #770b4b !important; color: white !important;">SERVICIO / REPARACIONES</th>
        <th class="text-center" style="width: 12%; background-color: #770b4b !important; color: white !important;">MEDIO DE PAGO</th>      

    </tr>';
    $costo_semana = 0;
    $costo_edenred = 0;
    $costo_transferencia = 0;
    $costo_transferencia_usuario = 0;
    $costo_no_especificado = 0;
    $balanceedenred = 0;
    foreach ($queryreagendadas->result() as $row_re) {
        $queryusuariovehiculo = $this->db->query('SELECT nombre, ap_paterno, ap_materno FROM usuarios WHERE id = ' . $row_re->usuario_actual);
        foreach ($queryusuariovehiculo->result() as $usuariov) {
            $usuarionombre = $usuariov->nombre;
            $usuarioap_paterno = $usuariov->ap_paterno;
            $usuarioap_materno = $usuariov->ap_materno;
        }
        if ($row_re->mediode_pago == 0) {
            $mediodepago = 'No especificado';
        } elseif ($row_re->mediode_pago == 1) {
            $mediodepago = 'EdenRed';
        } elseif ($row_re->mediode_pago == 2) {
            $mediodepago = 'SPEI proveedor';
        } elseif ($row_re->mediode_pago == 3) {
            $mediodepago = 'SPEI usuario';
        }
        echo '<tr>';
        echo '<td class="text-center">' . $row_re->idservicio_vehicular . '</td>';
        echo '<td class="text-center">' . $row_re->placas . '</td>';
        echo '<td class="text-center">' . mb_strtoupper($usuarionombre . ' ' . $usuarioap_paterno) . '</td>';
        echo '<td class="text-center">' . money_format('%= (#6.2n', $row_re->costo_neto) . '</td>';
        echo '<td class="text-center">' . mb_strtoupper($row_re->observaciones, 'UTF-8') . '</td>';
        //  echo '<td class="text-center">' . $row2->fecha_servicio . '</td>';
        echo '<td class="text-center">' . $mediodepago . '</td>';
        echo '</tr>';
        if ($row_re->mediode_pago == 1) {
            $costo_edenred = $costo_edenred + $row_re->costo_neto;
        } elseif ($row_re->mediode_pago == 2) {
            $costo_transferencia = $costo_transferencia + $row_re->costo_neto;
        } elseif ($row_re->mediode_pago == 3) {
            $costo_transferencia_usuario = $costo_transferencia_usuario + $row_re->costo_neto;
        }
        $costo_semana = $costo_semana + $row_re->costo_neto;
    }
    $balanceedenred = $costo_edenred - $edenrednegativo;

    echo '</table> ';
    ?>
    <table class="table table-hover" style="font-size: 12px;">
        <tr>
        <caption class="text-center" style="color: black; font-size: 16px;"><strong>IMPORTES TOTALES DE LOS SERVICIOS / REPARACIONES FUERA DE FECHA O REAGENDADOS</strong></caption>
        <th class="text-center" style="width: 17%; background-color: gray !important; color: white !important; font-size: 12px;">IMPORTE DE SOLICITUDES:</th>
        <th class="text-center" style="width: 16%; background-color: gray !important; color: white !important; font-size: 12px;">TRANSFERENCIA A PROVEEDOR</th>
        <th class="text-center" style="width: 17%; background-color: gray !important; color: white !important; font-size: 12px;">TRANSFERENCIA A USUARIO:</th>
        <th class="text-center" style="width: 16%; background-color: gray !important; color: white !important; font-size: 12px;">EDENRED</th>
    </tr>
    <tr>
        <td class="text-center" style="font-size: 14px;"><?php echo money_format('%= (#6.2n', $costo_semana); ?></td>
        <td class="text-center" style="font-size: 14px;"><?php echo money_format('%= (#6.2n', $costo_transferencia); ?></td>
        <td class="text-center" style="font-size: 14px;"><?php echo money_format('%= (#6.2n', $costo_transferencia_usuario); ?></td>
        <td class="text-center" style="font-size: 14px;"><?php echo money_format('%= (#6.2n', $costo_edenred); ?></td>
    </tr>

    </table>

    <?php
//    echo '<br> <br> Importe de Solicitudes: <strong> ' . money_format('%= (#6.2n', $costo_semana) . '</strong> <br>';
//    echo ' Trasnferencia a Proveedor:<strong> ' . money_format('%= (#6.2n', $costo_transferencia) . '</strong><br>';
//    echo ' Trasnferencia a Usuario: <strong> ' . money_format('%= (#6.2n', $costo_transferencia_usuario) . '</strong><br>';
//    echo ' Subtotal a Solicitar EdenRed: <strong> ' . money_format('%= (#6.2n', $costo_edenred) . '</strong><br>';
//    echo ' Importe EdenRed no ejecutado: <strong> ' . money_format('%= (#6.2n', $edenrednegativo) . '</strong><br>';
//    echo ' Total a Solicitar EdenRed: <strong> ' . money_format('%= (#6.2n', $balanceedenred) . '</strong> <br>';
} else {
    echo 'No existen solicitudes reagendadas o fuera de fecha';
}

// -------- FIN ---------
?>

