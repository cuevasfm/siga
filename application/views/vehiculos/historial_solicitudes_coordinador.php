<div class="page-header">
    <h2>Historial de solicitudes de servicios / reparaciones <small>Coodinador Administrativo</small></h2>
</div>

<?php
$query = $this->db->query('select idservicio_vehicular, placas, fecha_solicitud, estatus_autorizacion, costo_neto, observaciones, mediode_pago, modelo, usuario, nombre, ap_paterno, ap_materno, email from servicio_vehicular join vehiculos on servicio_vehicular.idvehiculo = vehiculos.idvehiculo join usuarios on   vehiculos.usuario_actual = usuarios.id where idsolicitante = ' . $_SESSION['id']);

if ($query->num_rows() > 0) {
    echo '<table class="table table-hover" style="font-size: 12px">
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
    </tr>';

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
        }elseif ($row->mediode_pago == 2) {
            $mediodepago = 'Trasnferencia Proveedor';
        }elseif ($row->mediode_pago == 3) {
            $mediodepago = 'Trasnferencia Usuario';
        }else{
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
echo '</table>';
?>