<br>
<?php
$query = $this->db->query('select * from servicio_vehicular where idservicio_vehicular = ' . $idservicio);
if ($query->num_rows() > 0) {
    foreach ($query->result() as $row) {
        $idservicio_vehicular = $row->idservicio_vehicular;
        $idvehiculo = $row->idvehiculo;
        $idsolicitante = $row->idsolicitante;
        $costo_neto = $row->costo_neto;
        $observaciones = $row->observaciones;
        $estatus_autorizacion = $row->estatus_autorizacion;
        $idquien_autorizo = $row->idquien_autorizo;
        $estatus_servicio = $row->estatus_servicio;
        $check = $row->check;
        $fecha_servicio = $row->fecha_servicio;
        $kilometraje_actual = $row->kilometraje_actual;
        $proyecto = $row->proyecto;
        $cotizacion = $row->cotizacion;
    }
} else {
    echo 'nada';
}
?>
<h3>Revisión general de la solicitud de servicio vehicular</h3>
<div class="col-md-12">
    <form method="post" action="<?php echo base_url() ?>index.php/vehiculos/actualizarvehiculo/<?php echo trim($idservicio) ?>">
        <div class="form-group col-md-4">
            <label>Id Servicio Vehicular</label>
            <input type="number" class="form-control" value="<?php echo trim($idservicio_vehicular) ?>" disabled="">
        </div>
        <div class="form-group col-md-4">
            <label>Id Vehiculo</label>
            <input type="number" class="form-control" value="<?php echo $idvehiculo ?>" disabled="">
        </div>
        <div class="form-group col-md-4">
            <label>Id Solicitante</label>
            <input type="number" class="form-control" value="<?php echo $idsolicitante ?>" disabled="">
        </div>
        <div class="form-group col-md-4">
            <label>Costo Neto</label>
            <input type="number" class="form-control" value="<?php echo $costo_neto ?>">
        </div>
        <div class="form-group col-md-4">
            <label>Fecha de servicio</label>
            <input type="date" class="form-control" value="<?php echo $fecha_servicio ?>">
        </div>
        <div class="form-group col-md-4">
            <label>Kilometraje Actual</label>
            <input type="text" class="form-control" value="<?php echo $kilometraje_actual ?>">
        </div>
        <div class="form-group col-md-12">
            <label>Observaciones</label>
            <textarea name="observaciones" class="form-control" required="" style="text-transform: uppercase"><?php echo $observaciones ?></textarea>
        </div>
        <div class="form-group col-md-4">
            <label>Autorización de servicio</label>
            <div class="radio">
                <label class="radio">
                    <input type="radio" name="estatus_autorizacion" value="1" checked=""> Si
                </label>
            </div>
            <div class="radio">
                <label class="radio">
                    <input type="radio" name="estatus_autorizacion" value="0" checked=""> No
                </label>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label>Check Trámite</label>
            <div class="radio">
                <label class="radio">
                    <input type="radio" name="check" value="1" checked=""> Si
                </label>
            </div>
            <div class="radio">
                <label class="radio">
                    <input type="radio" name="check" value="0" checked=""> No
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-default">Guardar Cambios</button>
    </form>  
</div>


