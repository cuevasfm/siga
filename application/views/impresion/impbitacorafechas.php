<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<br>
<div class="col-xs-12">
    <div class="col-xs-3" >
        <img src="<?php echo base_url(); ?>media/logo_inca.jpg" width="180px">
    </div>
    <div class="col-xs-5" ><br>

    </div>
    <div class="col-xs-4" >
        <strong>Servicios realizados entre: <?php echo $fecha1; ?> y <?php echo $fecha2; ?> </strong>
    </div>
</div>
<br><br><br>  
<?php
//echo '<br> Busqueda por fecha entre: ' . $fecha1 .' Y ' . $fecha2;
$query = $this->db->query('select idservicio_vehicular, servicio_vehicular.idvehiculo, costo_neto, fecha_servicio, observaciones, vehiculos.placas, servicio_vehicular.mediode_pago from servicio_vehicular join vehiculos on servicio_vehicular.idvehiculo = vehiculos.idvehiculo where `check` = 1 AND fecha_servicio BETWEEN"' . $fecha1 . '" AND "' . $fecha2 . '"');
setlocale(LC_MONETARY, 'es_MX');
$costo = 0;
if ($query->num_rows() > 0) {
    echo '<br><table class="table table-hover" style="font-size: 12px">
        <caption class="text-center" style="color: black; font-size: 14px;"><strong>BUSQUEDA DE LOS SERVICIOS / REPARACIONES</strong></caption>
    <tr>
        <th class="text-center" style="width: 7%; background-color: #770b4b !important; color: white !important;">ID</th>
        <th class="text-center" style="width: 11%; background-color: #770b4b !important; color: white !important;">PLACAS</th>
        <th class="text-center" style="width: 11%; background-color: #770b4b !important; color: white !important;">COSTO</th>        
        <th class="text-center" style="width: 60%; background-color: #770b4b !important; color: white !important;">SERVICIO / REPARACIÓN</th>
        <th class="text-center" style="width: 11%; background-color: #770b4b !important; color: white !important;">MEDIO DE PAGO</th>

    </tr>';

    foreach ($query->result() as $row) {
        if ($row->mediode_pago == 0) {
            $mediodepago = 'No especificado';
        } elseif ($row->mediode_pago == 1) {
            $mediodepago = 'EdenRed';
        } elseif ($row->mediode_pago == 2) {
            $mediodepago = 'SPEI proveedor';
        } elseif ($row->mediode_pago == 3) {
            $mediodepago = 'SPEI usuario';
        }
        echo '<tr class="text-center">';
        echo '<td class="text-center">' . $row->idservicio_vehicular . '</td>';
        echo '<td class="text-center">' . $row->placas . '</td>';
        echo '<td class="text-center">' . money_format('%= (#7.2n', $row->costo_neto) . '</td>';
        echo '<td>' . mb_strtoupper($row->observaciones, 'UTF-8') . '</td>';
        echo '<td class="text-center">' . $mediodepago . '</td>';
        echo '</tr>';
        $costo = $costo + $row->costo_neto;
    }
} else {
    echo 'no existen registros de servicio vehicular para este Vehículo';
}
echo '</table>';
?>
<h4><div class="alert alert-success" role="alert">Costo Total: <strong> <?php echo money_format('%=*(10.2n', $costo) ?></strong></div></h4>