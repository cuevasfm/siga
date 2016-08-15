<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<br>
<a target="_blank" href="http://miguelcuevas.xyz/siga/index.php/imprimir/bitacorafechas/<?php echo $fecha1; ?>/<?php echo $fecha2; ?>">
    <button type="button" class="btn btn-info" >Imprimir <span class="glyphicon glyphicon-print" aria-hidden="true"></span></button> 
</a>
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
        <th>FECHA SERVICIO</th>
        <th>SERVICIO / REPARACIÓN</th>
        <th></th>
    </tr>';

    foreach ($query->result() as $row) {
        echo '<tr>';
        echo '<td>' . $row->idservicio_vehicular . '</td>';
        echo '<td>' . $row->placas . '</td>';
        echo '<td>' . money_format('%= (#7.2n', $row->costo_neto) . '</td>';
        echo '<td>' . $row->fecha_servicio . '</td>';
        echo '<td>' . mb_strtoupper($row->observaciones, 'UTF-8') . '</td>';
        //   echo '<td><a href="' . base_url() . 'index.php/sesion/usuario/' . $row->id . '">' . $row->nombre . ' ' . $row->ap_paterno . '</a></td>';
        echo '<td><a href="' . base_url() . 'index.php/bitacora/vehiculodetalle/' . $row->idvehiculo . '"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></td>';
        echo '</tr>';
        $costo = $costo + $row->costo_neto;
    }
} else {
    echo 'no existen registros de servicio vehicular para este Vehículo';
}
echo '</table>';

?>
<h4><div class="alert alert-success" role="alert">Costo Total: <strong> <?php echo money_format('%=*(10.2n', $costo) ?></strong></div></h4>
