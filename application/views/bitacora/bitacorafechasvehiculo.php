<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo '<br> Busqueda por fecha entre: ' . $fecha1 .' Y ' . $fecha2;
$query = $this->db->query('select * from servicio_vehicular where idvehiculo = '. $idvehiculo .' AND estatus_autorizacion = 1 AND `check` = 1 AND fecha_servicio BETWEEN"' . $fecha1 . '" AND "' . $fecha2 . '"');
setlocale(LC_MONETARY, 'es_MX');
$costo = 0;
if ($query->num_rows() > 0) {
    echo '<br><table class="table table-hover" style="font-size: 12px">
    <tr>
        <th>ID Servicio</th>
        <th>ID Vehiculo</th>
        <th>Costo</th>
        <th>Fecha Servicio</th>
        <th>Observaciones</th>
        <th></th>
    </tr>';

    foreach ($query->result() as $row) {
        echo '<tr>';
        echo '<td>' . $row->idservicio_vehicular . '</td>';
        echo '<td>' . $row->idvehiculo . '</td>';
        echo '<td>' . money_format('%=*(#7.2n', $row->costo_neto) . '</td>';
        echo '<td>' . $row->fecha_servicio . '</td>';
        echo '<td>' . $row->observaciones . '</td>';
        //   echo '<td><a href="' . base_url() . 'index.php/sesion/usuario/' . $row->id . '">' . $row->nombre . ' ' . $row->ap_paterno . '</a></td>';
        echo '<td><a href="' . base_url() . 'index.php/bitacora/vehiculodetalle/' . $row->idservicio_vehicular . '"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></td>';
        echo '</tr>';
        $costo = $costo + $row->costo_neto;
    }
} else {
    echo 'no existen registros de servicio vehicular para este Vehículo';
}
echo '</table>';

?>
<h4><div class="alert alert-success" role="alert">Costo Total: <strong> <?php echo money_format('%=*(10.2n', $costo) ?></strong></div></h4>
