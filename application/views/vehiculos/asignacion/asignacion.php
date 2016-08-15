<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$queryvehiculo = $this->db->query('select idvehiculo, placas, modelo, serie from vehiculos');
$queryusuarios = $this->db->query('select id, usuario, nombre, ap_paterno, email from usuarios order by nombre asc');
$queryobra = $this->db->query('select * from obras');
?>

<script>
    function mostrarUsuario(str) {
        if (str == "") {
            document.getElementById("txtusuario").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("txtusuario").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "../getusuario/" + str, true);
            xmlhttp.send();
        }
    }
    function mostrarVehiculo(str) {
        if (str == "") {
            document.getElementById("txtvehiculo").innerHTML = "Selecciona un vehículo";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("txtvehiculo").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "../getvehiculo/" + str, true);
            xmlhttp.send();
        }
    }
    function mostrarObra(str) {
        if (str == "") {
            document.getElementById("txtobra").innerHTML = "Selecciona una obra";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("txtobra").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "../getobra/" + str, true);
            xmlhttp.send();
        }
    }
</script>
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h1>Asignación Vehicular<small></small></h1>
        </div>
        <div class="col-md-10">
            <form class="form-horizontal" method="post" action="<?php echo base_url() ?>index.php/vehiculos/asignarvehiculo">

                <div class="form-group">
                    <label class="col-sm-2 control-label">Vehículo</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="idvehiculo" required="" onchange="mostrarVehiculo(this.value)" autofocus="">
                            <option value=""></option>
                            <?php
                            if ($queryvehiculo->num_rows() > 0) {
                                foreach ($queryvehiculo->result() as $db_vehiculo) {
                                    echo '<option value="' . $db_vehiculo->idvehiculo . '">' . $db_vehiculo->placas . ' ' . $db_vehiculo->modelo . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-2 control-label">Usuarios</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="idusuario" onchange="mostrarUsuario(this.value)">
                            <option value="0"></option>
                            <?php
                            if ($queryusuarios->num_rows() > 0) {
                                foreach ($queryusuarios->result() as $db_usuario) {
                                    echo '<option value="' . $db_usuario->id . '">' . $db_usuario->nombre . ' ' . $db_usuario->ap_paterno . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-2 control-label">Obra</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="idobra" required="" onchange="mostrarObra(this.value)">
                            <option value="0"></option>
                            <?php
                            if ($queryobra->num_rows() > 0) {
                                foreach ($queryobra->result() as $db_obra) {
                                    echo '<option value="' . $db_obra->idobras . '">' . $db_obra->nombre . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Kilometraje</label>
                    <div class="col-sm-10">
                        <input name="kilometraje" type="number" class="form-control"  placeholder="ejemplo: 122556 ó 95858" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Obervaciones</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="2" name="observaciones" placeholder="Observaciones del vehiculo - máximo 300 caracteres " maxlength="300"></textarea>
                    </div>
                </div>


                <div class="col-md-4" id="txtvehiculo"> 
                    <!--                    <h3>Vehículo</h3>
                                        <dl class="dl-horizontal">
                                            <dt>ID del vehiculo:</dt><dd>  </dd>
                                            <dt>Placa:</dt><dd>  </dd>
                                            <dt>Modelo:</dt><dd> </dd>
                                            <dt>Serie:</dt><dd>  </dd>
                                            <dt>ID de usuario actual:</dt><dd> </dd>
                                            <dt>Obra asignada:</dt><dd>  </dd>
                                        </dl>-->
                </div>
                <div class="col-md-4" id="txtusuario"> 

                </div>
                <div class="col-md-4" id="txtobra"> 

                </div>
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-11">
                        <button type="submit" class="btn btn-primary btn-lg">Asignar</button>
                    </div>
                </div>

            </form>
        </div>


    </div>
    <div class="col-md-12">
        <div class="page-header">
            <h3>Últimas asignaciones vehiculares<small> </small></h3>
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
            $query_historial_asignacion_ultimos = $this->db->query('SELECT idasignacion, vehiculos.modelo, vehiculos.placas, usuarios.nombre as usuario, usuarios.ap_paterno, obras.nombre, kilometraje, fecha FROM historial_asignacion_vehiculos join vehiculos on historial_asignacion_vehiculos.idvehiculo = vehiculos.idvehiculo join usuarios on historial_asignacion_vehiculos.idusuario = usuarios.id join obras on historial_asignacion_vehiculos.obra = obras.idobras order by idasignacion desc limit 30');

            if ($query_historial_asignacion_ultimos->num_rows() > 0) {

                foreach ($query_historial_asignacion_ultimos->result_array() as $db_historial) {
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
</div>
