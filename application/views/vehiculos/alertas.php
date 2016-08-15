<h1>Vehiculos con seguro vencido o por vencer (30 días) </h1>
<?php
$fecha=(date('Y-m-d'));
$nuevafecha =strtotime ( '+30 day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
echo $nuevafecha;
//$query = $this->db->query('select * from vehiculos join marcasvehiculos on vehiculos.marca = marcasvehiculos.id JOIN usuarios ON vehiculos.usuario_actual = usuarios.id');
$query = $this->db->query('select * from vehiculos where vencimiento_seguro < "'.$nuevafecha.'"');
echo '<h1>Periodo del 24 al 30 de abril</h1>';
if ($query->num_rows() > 0) {
    echo '<table class="table table-hover" style="font-size: 12px">
    <tr>
        <th>Id</th>
        <th>Placas</th>
        <th>Modelo</th>
        <th>Serie</th>
        <th>Año</th>
        <th>Vencimiento del seguro</th>
        <th>Tarjeta de circulación</th>
        <th>Usuario Actual</th>
        <th></th>
        
    </tr>';

    foreach ($query->result() as $row) {
        echo '<tr>';
        echo '<td>' . $row->idvehiculo . '</td>';
        echo '<td>' . $row->placas . '</td>';
        echo '<td>' . $row->modelo . '</td>';
        echo '<td>' . $row->serie . '</td>';
        echo '<td>' . $row->anio . '</td>';
        echo '<td>' . $row->vencimiento_seguro . '</td>';
        echo '<td>' . $row->tarjeta_circulacion . '</td>';
        echo '<td>'.$row->usuario_actual.'</td>';
        echo '<td><input class="btn btn-default" type="button" value="Enviar correo"></td>';
        echo '</tr>';
    }
} else {
    echo 'Todos los vehiculo tienen la poliza de seguro vigente ';
}
echo '</table>';

echo '<h1>Vehiculos con tarjeta de circulación vencido o por vencer (30 días)</h1>';
//$query = $this->db->query('select * from vehiculos join marcasvehiculos on vehiculos.marca = marcasvehiculos.id JOIN usuarios ON vehiculos.usuario_actual = usuarios.id');
$query2 = $this->db->query('select * from vehiculos where tarjeta_circulacion < "'.$nuevafecha.'"');



if ($query2->num_rows() > 0) {
    echo '<table class="table table-hover" style="font-size: 12px">
    <tr>
        <th>Id</th>
        <th>Placas</th>
        <th>Modelo</th>
        <th>Serie</th>
        <th>Año</th>
        <th>Vencimiento del seguro</th>
        <th>Tarjeta de circulación</th>
        <th>Usuario Actual</th>
        <th></th>
        
    </tr>';

    foreach ($query2->result() as $row) {
        echo '<tr>';
        echo '<td>' . $row->idvehiculo . '</td>';
        echo '<td>' . $row->placas . '</td>';
        echo '<td>' . $row->modelo . '</td>';
        echo '<td>' . $row->serie . '</td>';
        echo '<td>' . $row->anio . '</td>';
        echo '<td>' . $row->vencimiento_seguro . '</td>';
        echo '<td>' . $row->tarjeta_circulacion . '</td>';
        echo '<td>'.$row->usuario_actual.'</td>';
        echo '<td><input class="btn btn-default" type="button" value="Enviar correo"></td>';
        echo '</tr>';
    }
} else {
    echo 'Todos los vehiculo tienen la poliza de seguro vigente ';
}
echo '</table>';

?>

<a href=""></a>
