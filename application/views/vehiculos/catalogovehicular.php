
<?php

$query = $this->db->query('select * from vehiculos join marcasvehiculos on vehiculos.marca = marcasvehiculos.id JOIN usuarios ON vehiculos.usuario_actual = usuarios.id order by vehiculos.placas asc ');
?>
<h3>Total de flotilla vehicular INCA: <?php echo $query->num_rows(); ?></h3>
<?php
if ($query->num_rows() > 0) {
    echo '<table class="table table-hover" style="font-size: 12px">
    <tr>
        
        <th>Placas</th>
        <th>Marca</th>
        <th>Modelo</th>
      
        <th>Año</th>
        <th>Vencimiento del seguro</th>
        <th>Tarjeta de circulación</th>
        <th>Usuario Actual</th>
        <th></th>
        <th></th>
        
    </tr>';

    foreach ($query->result() as $row) {
        echo '<tr>';
      //  echo '<td>' . $row->idvehiculo . '</td>';
        echo '<td>' . $row->placas . '</td>';
        echo '<td>' . $row->marca . '</td>';
        echo '<td>' . $row->modelo . '</td>';
      //echo '<td>' . $row->serie . '</td>';
        echo '<td>' . $row->anio . '</td>';
        echo '<td>' . $row->vencimiento_seguro . '</td>';
        echo '<td>' . $row->tarjeta_circulacion . '</td>';
        echo '<td><a href="' . base_url() . 'index.php/sesion/usuario/' . $row->id . '">' . $row->nombre . ' ' . $row->ap_paterno . '</a></td>';
        echo '<td><a href="' . base_url() . 'index.php/vehiculos/vehiculo/' . $row->idvehiculo . '"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></td>';
        echo '<td><a href="' . base_url() . 'index.php/vehiculos/editar/' . $row->idvehiculo . '"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>';
      //echo '<td><a href="' . base_url() . 'index.php/vehiculos/eliminar/' . $row->idvehiculo . '"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>';
        echo '</tr>';
    }
} else {
    echo 'no existen resultados para esta solicitud ';
}
echo '</table>';
?>

<a href=""></a>
