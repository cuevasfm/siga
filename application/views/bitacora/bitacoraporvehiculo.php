<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$querydatosvehiculo = $this->db->query('SELECT * FROM vehiculos where idvehiculo = ' . $idvehiculo);
if ($querydatosvehiculo->num_rows() > 0) {
    foreach ($querydatosvehiculo->result() as $yrow) {
        $placas = $yrow->placas;
        $modelo = $yrow->modelo;
        $serie = $yrow->serie;
        $anio = $yrow->anio;
        $valor_factura = money_format('%= (#7.2n', $yrow->valor_factura);
    }
}
?>

<h3>Bitácora Vehicular <small>Detalle histórico</small></h3>
<div class="row">
        <div class="col-md-2"><strong>Datos del vehículo:</strong></h4></div>
        <div class="col-md-10">
            <div class="col-xs-6 col-md-6"><strong>Placas:</strong> <span class="label label-default"><?php echo $placas; ?></span></div>
            <div class="col-xs-6 col-md-6"><strong>Modelo:</strong> <span class="label label-default"><?php echo $modelo; ?></span></div>
            <div class="col-xs-6 col-md-6"><strong>Serie:</strong> <span class="label label-default"><?php echo $serie; ?></div>
            <div class="col-xs-6 col-md-6"><strong>Año:</strong> <span class="label label-default"><?php echo $anio; ?></span></div>
            <div class="col-xs-6 col-md-6"><strong>Valor Factura:</strong> <span class="label label-default"><?php echo $valor_factura; ?></span></div></div>
</div>
<br>

<div class="col-lg-12 col-md-12">
    <?php
    setlocale(LC_MONETARY, 'es_MX');
    $query = $this->db->query('SELECT * FROM servicio_vehicular WHERE idvehiculo = ' . $idvehiculo . ' AND `check` = 1 AND estatus_autorizacion = 1  ORDER BY idservicio_vehicular DESC');
    $costo = 0;
    if ($query->num_rows() > 0) {
        echo '<table class="table table-hover" style="font-size: 12px">
    <tr>
        <th>ID Servicio</th>
        <th>Costo</th>
        <th>Fecha Servicio</th>
        <th>kilometraje</th>
        <th>Observaciones</th>
        <th></th>
    </tr>';

        foreach ($query->result() as $row) {
            echo '<tr>';
            echo '<td>' . $row->idservicio_vehicular . '</td>';
            echo '<td>' . money_format('%= (#7.2n', $row->costo_neto) . '</td>';
            echo '<td>' . $row->fecha_servicio . '</td>';
            echo '<td>' . $row->kilometraje_actual . '</td>';
            echo '<td>' . $row->observaciones . '</td>';
            //   echo '<td><a href="' . base_url() . 'index.php/sesion/usuario/' . $row->id . '">' . $row->nombre . ' ' . $row->ap_paterno . '</a></td>';
            echo '<td><a href="' . base_url() . 'index.php/vehiculos/editarservicio/' . $row->idservicio_vehicular . '"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></td>';
            echo '</tr>';
            $costo = $costo + $row->costo_neto;
        }
    } else {
        echo 'no existen registros de servicio vehicular para este Vehículo';
    }
    echo '</table>';

//echo 'el costo de los servicios totales para éste vehículo es de: ' . money_format('%=*(10.2n', $costo);
    ?>
    <h4><div class="alert alert-success" role="alert">Costo Total: <strong> <?php echo money_format('%= (10.2n', $costo) ?></strong></div></h4>
    
</div>
<div class="col-md-12">
        <div class="page-header">
            <h3>Historial de usuarios del vehículo<small> </small></h3>
        </div>
        <table class="table table-hover" style="font-size:12px">
            <tr>
                <th>Vehiculo</th>
                <th>Placa</th>
                <th>Usuario</th>
                <th>Obra</th>
                <th>Fecha Asignado</th>
                <th>Kilometraje</th>
            </tr>
            <?php
            $queryusuariovehiculo = $this->db->query('SELECT idasignacion, vehiculos.modelo, vehiculos.placas, usuarios.nombre as usuario, usuarios.ap_paterno, obras.nombre, kilometraje, fecha FROM historial_asignacion_vehiculos join vehiculos on historial_asignacion_vehiculos.idvehiculo = vehiculos.idvehiculo join usuarios on historial_asignacion_vehiculos.idusuario = usuarios.id join obras on historial_asignacion_vehiculos.obra = obras.idobras WHERE vehiculos.idvehiculo = "'. $idvehiculo .'" order by idasignacion desc');

            if ($queryusuariovehiculo->num_rows() > 0) {

                foreach ($queryusuariovehiculo->result_array() as $db_historial) {
                    echo '<tr>';
                    echo '<td>' . $db_historial['modelo'] . '</td>';
                    echo '<td>' . $db_historial['placas'] . '</td>';
                    echo '<td>' . $db_historial['usuario'] . ' ' . $db_historial['ap_paterno'] . '</td>';
                    echo '<td>' . $db_historial['nombre'] . '</td>';
                    echo '<td>' . $db_historial['fecha'] . '</td>';
                    echo '<td>' . $db_historial['kilometraje'] . '</td>';
                    echo '</tr>';
                }
            }
            ?>
        </table>
    </div>