<br>
<img src="<?php base_url() ?>/siga/subidas/sistema/logoinca.png" alt="Logo INCA" >
<br>

<?php
echo $idservicio;
echo 'Este es el usuario: ' . $idusuario;
echo 'Este es el nombre: ' . $nombreusuario;



$query = $this->db->query('select * from servicio_vehicular where idservicio_vehicular = "' . $idservicio . '"');
if ($query->num_rows() > 0) {
    foreach ($query->result() as $row) {
        $id = $row->idservicio_vehicular;
        $idvehiculo = $row->idvehiculo;
        $solicitante = $row->idsolicitante;
        $costo_neto = $row->costo_neto;
        $observaciones = $row->observaciones;
        $estatus_autorizacion = $row->estatus_autorizacion;
        $quien_autorizo = $row->idquien_autorizo;
        $estatus_servicio = $row->estatus_servicio;
        if ($row->check == 0) {
            $pagado = 'check: NO';
        } else {
            $pagado = 'check: SI';
        }
        $fecha_servicio = $row->fecha_servicio;
        $kilometraje_actual = $row->kilometraje_actual;
        $proyecto = $row->proyecto;
    }
} else {
    echo 'no existe registro de esta solicitud';
}

$queryvehiculo = $this->db->query('select * from vehiculos where idvehiculo = "' . $idvehiculo . '"');
if ($queryvehiculo->num_rows() > 0) {
    foreach ($queryvehiculo->result() as $row2) {
        $placas = $row2->placas;
        $modelo = $row2->modelo;
        $serie = $row2->serie;
    }
} else {
    echo 'no existe registro de esta solicitud';
}
$queryusuario = $this->db->query('select * from usuarios where id = "' . $solicitante . '"');
if ($queryusuario->num_rows() > 0) {
    foreach ($queryusuario->result() as $row3) {
        $idusuario = $row3->id;
        $usuario = $row3->usuario;
        $nombre = $row3->nombre . ' ' . $row3->ap_paterno;
        $email = $row3->email;
        $nivel = $row3->nivel;
    }
} else {
    echo 'no existe registro de esta solicitud';
}
?>

<h3>SERVICIO VEHICULAR CON ID: <?php echo $id; ?></h3> 
<h3>DATOS DE VEHICULO: </h3>
<table class="table">
    <tr>
        <th>Id</th>
        <th>PLACAS</th>
        <th>MODELO</th>
        <th>SERIE</th>  
    </tr>
    <tr>
        <td><?php echo $idvehiculo; ?></td>
        <td><?php echo $placas; ?></td>
        <td><?php echo $modelo; ?></td>
        <td><?php echo $serie; ?></td>        
    </tr>
</table>
<h3>DETALLES DEL SERVICIO: </h3> 
<table class="table">
    <tr>
        <th># SERVICIO</th>
        <th>OBSERVACIONES</th>
        <th>COSTO</th>
        <th>FECHA DE SERVICIO</th> 
        <th>AUTORIZADO</th> 
        
    </tr>
    <tr>
        <td><?php echo $idservicio; ?></td>
        <td><?php echo $observaciones; ?></td>
        <td><?php echo $costo_neto; ?></td>
        <td><?php echo $fecha_servicio; ?></td>
        <td><?php echo $estatus_autorizacion; ?></td>

    </tr>
</table>
<h3>USUARIO SOLICITANTE: </h3> 
<table class="table">
    <tr>
        <th>ID USUARIO</th>
        <th>USUARIO</th>
        <th>NOMBRE</th>
        <th>EMAIL</th> 
        <th>NIVEL</th> 
    </tr>
    <tr>
        <td><?php echo $idusuario; ?></td>
        <td><?php echo $usuario; ?></td>
        <td><?php echo $nombre; ?></td>
        <td><?php echo $email; ?></td>
        <td><?php echo $nivel; ?></td>

    </tr>
</table>
