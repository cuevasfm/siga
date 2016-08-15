<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<a class="btn btn-default" role="button" onclick="window.print();">Imprimir</a>
<img src="http://miguelcuevas.xyz/siga/media/imagotipoin.png" width="180px" alt="" style="display: block; margin: auto;"/>
<br>

<?php
echo '<br> Busqueda por fecha entre: ' . $fecha1 .' Y ' . $fecha2;
$query = $this->db->query('select idservicio_vehicular, servicio_vehicular.idvehiculo, costo_neto, fecha_servicio, observaciones, vehiculos.placas from servicio_vehicular join vehiculos on servicio_vehicular.idvehiculo = vehiculos.idvehiculo where `check` = 1 AND fecha_servicio BETWEEN"' . $fecha1 . '" AND "' . $fecha2 . '"');
setlocale(LC_MONETARY, 'es_MX');
$costo = 0;
if ($query->num_rows() > 0) {
    echo '<br><table class="table table-hover" style="font-size: 12px">
    <tr>
        <th>ID SERVICIO</th>
        <th>PLACAS</th>
        <th>COSTO</th>
        <th>FECHA DE SERVICIO</th>
        <th>SERVICIO / REPARACIÓN</th>

    </tr>';
 
    foreach ($query->result() as $row) {
        echo '<tr>';
        echo '<td>' . $row->idservicio_vehicular . '</td>';
        echo '<td>' . $row->placas . '</td>';
        echo '<td>' . money_format('%= (#7.2n', $row->costo_neto) . '</td>';
        echo '<td>' . $row->fecha_servicio . '</td>';
        echo '<td>' . mb_strtoupper($row->observaciones, 'UTF-8') . '</td>';
        echo '</tr>';
        $costo = $costo + $row->costo_neto;
    }
} else {
    echo 'no existen registros de servicio vehicular para este Vehículo';
}
echo '</table>';

?>
<h4><div class="alert alert-success" role="alert">Costo Total: <strong> <?php echo money_format('%=*(10.2n', $costo) ?></strong></div></h4>