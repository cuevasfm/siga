<br>
<img src="<?php base_url() ?>/siga/subidas/sistema/logoinca.png" alt="Logo INCA" >
<br>
<?php
echo $idservicio;
echo 'Este es el usuario: ' . $idusuario;
echo 'Este es el nombre: ' . $nombreusuario;


$query = $this->db->query('select * from servicio_vehicular where id = "' . $idservicio . '"');
if ($query->num_rows() > 0) {
    foreach ($query->result() as $row) {
        echo 'ID:'.$id = $row->id . '<br>';
        echo 'ID VEHICULO'.$idvehiculo = $row->idvehiculo . '<br>';
        echo 'TIPO DE SERVICIO: '.$tipo_servicio = $row->tipo_servicio . '<br>';
        echo 'SOLICITANTE'.$solicitante = $row->solicitante . '<br>';
        echo 'COSTO DEL SERVICIO: '.$costo_neto = $row->costo_neto . '<br>';
        echo 'OBSERVACIONES: '.$observaciones = $row->observaciones . '<br>';
        echo 'ESTATUSO DE AUTORIZACIÓN: '.$estatus_autorizacion = $row->estatus_autorizacion . '<br>';
        echo 'AUTORIZÓ '.$quien_autorizo = $row->quien_autorizo . '<br>';
        echo 'ESTATUS DE SERVICIO '.$estatus_servicio = $row->estatus_servicio . '<br>';
        if ($row->pagado == NULL) {
            echo $pagado = 'PAGADO: NO <br>';
        }
        echo 'FEHCA DE SERVICIO: '.$fecha_servicio = $row->fecha_servicio . '<br>';
        echo 'KILOMETRAJE: '.$kilometraje_actual = $row->kilometraje_actual . ' Kilometros <br>';
        echo 'PROYECTO '.$proyecto = $row->proyecto . '<br>';
    }
} else {
    echo 'no existe registro de esta solicitud';
}