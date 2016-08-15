<br>
<?php
setlocale(LC_ALL, "es_MX.UTF-8");
date_default_timezone_set("America/Mexico_City");
if (date('l') == 'Sunday' or date('l') == 'Monday' or date('l') == 'Tuesday' or date('l') == 'Wednesday' or date('l') == 'Thursday') {
    $fecha = strftime("%A, %d de %B de %Y", strtotime('next friday'));
    $fechasql = date("Y-m-d", strtotime('next friday'));
    echo '<div class="alert alert-warning" role="alert">Servicios programados para el: <strong>' . $fecha . '</strong></div>';
} elseif (date('l') == 'Friday') {
    $fecha = strftime("%A, %d de %B de %Y", strtotime('friday'));
    $fechasql = date("Y-m-d", strtotime('friday'));
    echo '<div class="alert alert-warning" role="alert">Servicios programados para el: <strong>' . $fecha . '</strong></div>';
} else {
    $fecha = strftime("%A, %d de %B de %Y", strtotime('last friday'));
    $fechasql = trim(date("Y-m-d", strtotime('last friday')));
    echo '<div class="alert alert-warning" role="alert">Servicios programados para el: <strong>' . $fecha . '</strong></div>';
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


<?php
echo '<h3>Solicitudes vehiculares pendientes de autorización <a href="http://miguelcuevas.xyz/siga/index.php/imprimir/mttoxautorizar" target="_blank">
    <button type="button" class="btn btn-info" >Imprimir <span class="glyphicon glyphicon-print" aria-hidden="true"></span></button> 
</a></h3>';
//$query = $this->db->query('select * from vehiculos join marcasvehiculos on vehiculos.marca = marcasvehiculos.id JOIN usuarios ON vehiculos.usuario_actual = usuarios.id');
//$query = $this->db->query('select * from servicio_vehicular where fecha_servicio >= "' . $dia1 . '" and fecha_servicio <= "' . $dia2 . '"');
//$query = $this->db->query('select * from servicio_vehicular where `estatus_autorizacion` = "0" and `fecha_servicio` =  "' . $fechasql . '" ORDER BY idservicio_vehicular DESC ');
$query = $this->db->query('SELECT servicio_vehicular.idvehiculo, idservicio_vehicular, idsolicitante, costo_neto, observaciones, fecha_servicio, placas, nombre, ap_paterno, servicio_vehicular.mediode_pago, vehiculos.usuario_actual FROM `servicio_vehicular` join vehiculos on servicio_vehicular.idvehiculo = vehiculos.idvehiculo join usuarios on servicio_vehicular.idsolicitante = usuarios.id where servicio_vehicular.estatus_autorizacion = "0" and servicio_vehicular.fecha_servicio = "' . $fechasql . '" ORDER BY  idservicio_vehicular DESC');
if ($query->num_rows() > 0) {

    echo '<form method="post" action="' . base_url() . 'index.php/vehiculos/autorizarservicio">';
    echo '<table class="table table-hover" style="font-size: 12px">
    <tr>
        <th>IdServicio</th>
        <th>Bitácora de Mtto</th>
        <th>Solicitante</th>
        <th>Usuario</th>
        <th>Costo</th>
        <th>Servicio/Reparación</th>
        <th>Medio de pago</th> 
        <th>Autorizar</th>        
        <th>Editar</th>
    </tr>';     
    $costo_semana = 0;
    $costo_edenred = 0;
    $costo_transferencia = 0;
    $costo_transferencia_usuario = 0;
    $costo_no_especificado = 0;
    $balanceedenred = 0;
    foreach ($query->result() as $row2) {
        $queryusuariovehiculo = $this->db->query('SELECT nombre, ap_paterno, ap_materno FROM usuarios WHERE id = '. $row2->usuario_actual);
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
        echo '<td><a href = "' . base_url() . 'index.php/bitacora/vehiculo/' . $row2->idvehiculo . '">' . $row2->placas . '</a></td>';
        echo '<td>' . $row2->nombre . ' ' . $row2->ap_paterno . '</td>';
        echo '<td>' . $usuarionombre . ' ' . $usuarioap_paterno . '</td>';
        echo '<td>' . money_format('%= (#6.2n', $row2->costo_neto) . '</td>';
        echo '<td>' . mb_strtoupper($row2->observaciones) . '</td>';
        echo '<td>' . $mediodepago . '</td>';
        echo '<td><input type = "checkbox" name = "check[' . $row2->idservicio_vehicular . ']" value = "' . $row2->idservicio_vehicular . '" ' . '></td>';
        echo '<td><a href = "' . base_url() . 'index.php/vehiculos/editarservicio/' . $row2->idservicio_vehicular . ' "><button type = "button" class = "btn btn-default" aria-label = "Left Align"><span class = "glyphicon glyphicon-pencil" aria-hidden = "true"></span></button></a>';
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
    // echo '<dl class="dl-horizontal">';
    echo ' Importe de Solicitudes: <strong> ' . money_format('%= (#6.2n', $costo_semana) . '</strong> <br>';
    echo ' Trasnferencia a Proveedor:<strong> ' . money_format('%= (#6.2n', $costo_transferencia) . '</strong><br>';
    echo ' Trasnferencia a Usuario: <strong> ' . money_format('%= (#6.2n', $costo_transferencia_usuario) . '</strong><br>';
    echo ' Total a Solicitar EdenRed: <strong> ' . money_format('%= (#6.2n', $costo_edenred) . '</strong><br>';
    echo ' Importe EdenRed no ejecutado: <strong> ' . money_format('%= (#6.2n', $edenrednegativo) . '</strong><br>';
  //  echo ' Total a Solicitar EdenRed: <strong> ' . money_format('%= (#6.2n', $balanceedenred) . '</strong> <br>';
    //   echo '</dl>';
    echo '<button type="submit" class="btn btn-info">Autorizar servicios</button></form>';
//    echo 'El importe de solicitudes sin autorizar es: '.money_format('%= (#6.2n', $costo_semana);
} else {
    echo 'No existen solicitudes por autorizar';
}
echo '<br>';
//tercer query





echo '<h3>Solicitudes vehiculares pendientes de finalizar</h3>';
// segundo query
$query2 = $this->db->query('SELECT servicio_vehicular.idvehiculo, idservicio_vehicular, idsolicitante, costo_neto, observaciones, fecha_servicio, placas, nombre, ap_paterno, servicio_vehicular.mediode_pago, servicio_vehicular.fecha_autorizado, servicio_vehicular.fecha_solicitud, vehiculos.usuario_actual FROM `servicio_vehicular` join vehiculos on servicio_vehicular.idvehiculo = vehiculos.idvehiculo join usuarios on servicio_vehicular.idsolicitante = usuarios.id where `check` = 0 and `estatus_autorizacion` = "1" ORDER BY  idservicio_vehicular DESC');
//$query2 = $this->db->query('select * from servicio_vehicular where `check` = 0 and `estatus_autorizacion` = "1"  ORDER BY idservicio_vehicular DESC ');
if ($query2->num_rows() > 0) {
    echo '<form method="post" action="' . base_url() . 'index.php/vehiculos/finalizarservicio">';
    echo '<table class="table table-hover" style="font-size: 12px">
    <tr>
        <th>Id servicio</th>
        <th>Bitácora de Mtto</th>
        <th>Solicitante</th>
        <th>Costo</th>
        <th>Servicio/Reparación</th>
        <th>Solicitado</th>
        <th>Fecha de servicio</th>     
        <th>Autorizado</th> 
        <th>Medio de pago</th> 
        <th>Finalizar</th>
    </tr>';
    $costo_semana = 0;
    $costo_edenred = 0;
    $costo_transferencia = 0;
    $costo_transferencia_usuario = 0;
    $costo_no_especificado = 0;
    foreach ($query2->result() as $row) {
        if ($row->mediode_pago == 0) {
            $mediodepago = 'No especificado';
        } elseif ($row->mediode_pago == 1) {
            $mediodepago = 'EdenRed';
        } elseif ($row->mediode_pago == 2) {
            $mediodepago = '<a target="_blank" href = "' . base_url() . 'index.php/vehiculos/solicituddepagos/' . $row->idservicio_vehicular . '/' . $row->mediode_pago . '/">SPEI Proveedor</a>';
        } elseif ($row->mediode_pago == 3) {
            $mediodepago = 'SPEI usuario';
        }
        echo '<tr>';
        echo '<td>' . $row->idservicio_vehicular . '</td>';
        echo '<td><a href = "' . base_url() . 'index.php/bitacora/vehiculo/' . $row->idvehiculo . '">' . $row->placas . '</a></td>';
        echo '<td>' . $row->nombre . ' ' . $row->ap_paterno . '</td>';
        echo '<td>' . money_format('%= (#6.2n', $row->costo_neto) . '</td>';
        echo '<td>' . $row->observaciones . '</td>';
        echo '<td>' . $row->fecha_solicitud . '</td>';
        echo '<td>' . $row->fecha_servicio . '</td>';
        echo '<td>' . $row->fecha_autorizado . '</td>';
        echo '<td>' . $mediodepago . '</td>';

        //   echo '<td>' . $row->kilometraje_actual . '</td>';
        echo '<td><input type = "checkbox" name = "check[' . $row->idservicio_vehicular . ']" value = "' . $row->idservicio_vehicular . '" ' . '></td>';
        echo '<td><a href = "' . base_url() . 'index.php/vehiculos/editarservicio/' . $row->idservicio_vehicular . ' "><button type = "button" class = "btn btn-default" aria-label = "Left Align"><span class = "glyphicon glyphicon-pencil" aria-hidden = "true"></span></button></a>';
        echo '</tr>';
        if ($row->mediode_pago == 1) {
            $costo_edenred = $costo_edenred + $row->costo_neto;
        } elseif ($row->mediode_pago == 2) {
            $costo_transferencia = $costo_transferencia + $row->costo_neto;
        } elseif ($row->mediode_pago == 3) {
            $costo_transferencia_usuario = $costo_transferencia_usuario + $row->costo_neto;
        }
        $costo_semana = $costo_semana + $row->costo_neto;
    }
    echo '</table>';
    echo '<p"> Total de esta lista: <strong> ' . money_format('%= (#6.2n', $costo_semana) . '</strong></p>';
    echo '<p"> Total de EdenRed: <strong> ' . money_format('%= (#6.2n', $costo_edenred) . '</strong></p>';
    echo '<p> Total de Transferencia a Proveedor: <strong> ' . money_format('%= (#6.2n', $costo_transferencia) . '</strong></p>';
    echo '<p> Total de Trasnferencia a Usuario: <strong> ' . money_format('%= (#6.2n', $costo_transferencia_usuario) . '</strong></p>';
    echo '<button type="submit" class="btn btn-info">Finalizar servicios</button></form>';
} else {
    echo 'Todos los servicios autorizados estan finalizados';
}
echo '<br>';

echo '<h3>Solicitudes re-agendadas ó fuera de fecha</h3>';
//$query3 = $this->db->query('select * from servicio_vehicular where `estatus_autorizacion` = "0" and `fecha_servicio` !=  "' . $fechasql . '" ORDER BY idservicio_vehicular DESC ');
$query3 = $this->db->query('SELECT servicio_vehicular.idvehiculo, idservicio_vehicular, idsolicitante, costo_neto, observaciones, fecha_servicio, placas, nombre, ap_paterno, servicio_vehicular.mediode_pago, vehiculos.usuario_actual FROM `servicio_vehicular` join vehiculos on servicio_vehicular.idvehiculo = vehiculos.idvehiculo join usuarios on servicio_vehicular.idsolicitante = usuarios.id where `check` = 0 and `estatus_autorizacion` = "0" and servicio_vehicular.fecha_servicio != "' . $fechasql . '" ORDER BY  idservicio_vehicular DESC');

if ($query3->num_rows() > 0) {
    echo '<table class="table table-hover" style="font-size: 12px">
    <tr>
        <th>IdServicio</th>
        <th>Bitácora de Mtto</th>
        <th>Solicitante</th>
        <th>Costo</th>
        <th>Servicio/Reparación</th>
        <th>Fecha de servicio</th>     
        <th>Medio de pago</th> 
        <th>Editar</th>
    </tr>';
    $costo_semana = 0;

    foreach ($query3->result() as $row4) {
        if ($row4->mediode_pago == 0) {
            $mediodepago = 'No especificado';
        } elseif ($row4->mediode_pago == 1) {
            $mediodepago = 'EdenRed';
        } elseif ($row4->mediode_pago == 2) {
            $mediodepago = '<a target="_blank" href = "' . base_url() . 'index.php/vehiculos/solicituddepagos/' . $row4->idservicio_vehicular . '/' . $row4->mediode_pago . '/">SPEI Proveedor</a>';
        } elseif ($row4->mediode_pago == 3) {
            $mediodepago = 'SPEI usuario';
        }
        echo '<tr>';
        echo '<td>' . $row4->idservicio_vehicular . '</td>';
        echo '<td><a href = "' . base_url() . 'index.php/bitacora/vehiculo/' . $row4->idvehiculo . '">' . $row4->placas . '</a></td>';
        echo '<td>' . $row4->nombre . ' ' . $row4->ap_paterno . '</td>';
        echo '<td>' . money_format('%= (#6.2n', $row4->costo_neto) . '</td>';
        echo '<td>' . $row4->observaciones . '</td>';
        echo '<td>' . $row4->fecha_servicio . '</td>';
        echo '<td>' . $mediodepago . '</td>';
        //  echo '<td>' . $row->kilometraje_actual . '</td>';
        echo '<td><a href = "' . base_url() . 'index.php/vehiculos/editarservicio/' . $row4->idservicio_vehicular . ' "><button type = "button" class = "btn btn-default" aria-label = "Left Align"><span class = "glyphicon glyphicon-pencil" aria-hidden = "true"></span></button></a>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo 'No existen solicitudes por autorizar';
}
echo '<br>';
?>
<a href="http://miguelcuevas.xyz/siga/index.php/imprimir/progdemtto" target="_blank">
    <button type="button" class="btn btn-info" >Imprimir Todo <span class="glyphicon glyphicon-print" aria-hidden="true"></span></button> 
</a>
