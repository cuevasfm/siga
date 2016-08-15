<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<h3>Solicitudes vehiculares pendientes de finalizar</h3>';
// segundo query
$query2 = $this->db->query('SELECT servicio_vehicular.idvehiculo, idservicio_vehicular, idsolicitante, costo_neto, observaciones, fecha_servicio, placas, nombre, ap_paterno, servicio_vehicular.mediode_pago FROM `servicio_vehicular` join vehiculos on servicio_vehicular.idvehiculo = vehiculos.idvehiculo join usuarios on servicio_vehicular.idsolicitante = usuarios.id where `check` = 0 and `estatus_autorizacion` = "1" ORDER BY  idservicio_vehicular DESC');
//$query2 = $this->db->query('select * from servicio_vehicular where `check` = 0 and `estatus_autorizacion` = "1"  ORDER BY idservicio_vehicular DESC ');
if ($query2->num_rows() > 0) {
    echo '<form method="post" action="' . base_url() . 'index.php/vehiculos/finalizarservicio">';
    echo '<table class="table table-hover" style="font-size: 12px">
    <tr>
        <th>Id servicio</th>
        <th>Bitácora de mantenimiento</th>
        <th>Solicitante</th>
        <th>Costo</th>
        <th>Observaciones</th>     
        <th>Fecha de servicio</th>     
        <th>Medio de pago</th> 
    </tr>';
    $costo_semana = 0;
    $costo_edenred = 0;
    $costo_transferencia= 0;
    $costo_transferencia_usuario = 0; 
    $costo_no_especificado = 0; 
    foreach ($query2->result() as $row) {
        if ($row->mediode_pago == 0) {
            $mediodepago = 'No Especificado';
        }elseif ($row->mediode_pago == 1) {
            $mediodepago = 'EdenRed';
        }elseif ($row->mediode_pago == 2) {
            $mediodepago = 'SPEI Proveedor';
        }elseif ($row->mediode_pago == 3) {
            $mediodepago = 'SPEI Usuario';
        }
        echo '<tr>'; 
        echo '<td>' . $row->idservicio_vehicular . '</td>';
        echo '<td><a href = "' . base_url() . 'index.php/bitacora/vehiculo/' . $row->idvehiculo . '">' . $row->placas . '</a></td>';
        echo '<td>' . $row->nombre . ' ' . $row->ap_paterno . '</td>';
        echo '<td>' . money_format('%= (#6.2n', $row->costo_neto) . '</td>';
        echo '<td>' . $row->observaciones . '</td>';
        echo '<td>' . $row->fecha_servicio . '</td>';
        echo '<td>' . $mediodepago. '</td>';
        //   echo '<td>' . $row->kilometraje_actual . '</td>';
        echo '</tr>'; 
        if ($row->mediode_pago == 1) {
            $costo_edenred = $costo_edenred + $row->costo_neto;
        }elseif ($row->mediode_pago == 2) {
            $costo_transferencia = $costo_transferencia + $row->costo_neto;
        }elseif ($row->mediode_pago == 3) {
            $costo_transferencia_usuario = $costo_transferencia_usuario + $row->costo_neto;
        }
        $costo_semana = $costo_semana + $row->costo_neto;
    }
    echo '</table>';
    echo '<p class="lead"> Total de esta lista: <strong> ' . money_format('%= (#6.2n', $costo_semana) . '</strong></p>';
    echo '<p class="lead"> Total de EdenRed: <strong> ' . money_format('%= (#6.2n', $costo_edenred) . '</strong></p>';
    echo '<p class="lead"> Total de Transferencia a Proveedor: <strong> ' . money_format('%= (#6.2n', $costo_transferencia) . '</strong></p>';
    echo '<p class="lead"> Total de Trasnferencia a Usuario: <strong> ' . money_format('%= (#6.2n', $costo_transferencia_usuario) . '</strong></p>';
    echo '<button type="submit" class="btn btn-default">Finalizar servicios</button></form>';
} else {
    echo 'Todos los servicios autorizados estan finalizados';
}
echo '<br>';