<?php
/* DARÁ LA OPCION DE ASIGNAR CORDINADOR ADMINISTRATIVO A UN VEHICULO
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$query_coordinadores = $this->db->query('select * from usuarios where nivel = "coordinador administrativo"');
$query_vehiculos = $this->db->query('select * from vehiculos where estatus1 = 1');
$query_historial_asignacion_admon = $this->db->query('SELECT usuarios.nombre, usuarios.ap_materno, usuarios.ap_paterno, vehiculos.placas, vehiculos.modelo, idhistorial_admon FROM historial_coordinador_admon join usuarios on coordinador = id join vehiculos on vehiculo = idvehiculo order by idhistorial_admon desc limit 0,130 ');
?>

<br><br>
<div class="col-md-8">
    <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/vehiculos/guardar_asignarcoordinador">
        <div class="form-group">
            <label  class="col-sm-2 control-label">Coordinador Administrativo:</label>
            <div class="col-sm-10">
                <select name="coordinador" class="form-control" required="">
                    <?php
                    if ($query_coordinadores->num_rows() > 0) {
                        echo '<option value=""></option>';
                        foreach ($query_coordinadores->result() as $row) {
                            echo '<option value="' . $row->id . '">' . $row->nombre . ' ' . $row->ap_paterno . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">Vehículo:</label>
            <div class="col-sm-10">
                <select name="vehiculo" class="form-control" required="">
                    <?php
                    if ($query_vehiculos->num_rows() > 0) {
                        echo '<option value=""></option>';
                        foreach ($query_vehiculos->result() as $row) {
                            echo '<option value="' . $row->idvehiculo . '">' . $row->placas . ' ' . $row->modelo . ' Usuario:' . $row->usuario_actual . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Asignar Coordinador</button>
            </div>
        </div>
    </form> 
    
    
    <?php

if ($query_historial_asignacion_admon->num_rows() > 0) {
    ?>

    <h3>Historial de asiganción de coordinador administrativo</h3>
    <table class="table" style="font-size: 12px">
        <tr>
            <th>ID</th>
            <th>Coordinador Administrativo</th>
            <th>Vehiculo</th>
        </tr>

        <?php
        foreach ($query_historial_asignacion_admon->result() as $row2) {
            echo '<tr>';
            echo '<td>' . $row2->idhistorial_admon . '</td>';
            echo '<td>' . $row2->nombre . ' ' . $row2->ap_paterno . ' ' . $row2->ap_materno . '</td>';
            echo '<td>' . $row2->placas . ' ' . $row2->modelo . '</td>';
            echo '</tr>';
        }
        ?>
    </table>
    <?php
}  
?>
    
    
</div>


