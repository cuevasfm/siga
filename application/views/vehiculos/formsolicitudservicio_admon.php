<br>
<script>


    function clabeinterbancaria(txb) {
        txb.value = txb.value.replace(/[^0-9]/, "");
    }

    function kilometraje(txb) {
        txb.value = txb.value.replace(/[^0-9]/, "");
    }

    function medioDePago(val) {
        if (val == "1" || val == "0") {
            document.getElementById('rfc').value = "";
            document.getElementById('nombre').value = "";
            document.getElementById('banco').value = "";
            document.getElementById('clabe').value = "";
            document.getElementById("rfc").disabled = true;
            document.getElementById("nombre").disabled = true;
            document.getElementById("banco").disabled = true;
            document.getElementById("clabe").disabled = true;
        } else if (val == "3") {
            document.getElementById('rfc').value = "";
            document.getElementById('nombre').value = "";
            document.getElementById('banco').value = "";
            document.getElementById('clabe').value = "";
            document.getElementById("rfc").disabled = true;
            document.getElementById("nombre").disabled = false;
            document.getElementById("banco").disabled = false;
            document.getElementById("clabe").disabled = false;
        } else {
            document.getElementById('rfc').value = "";
            document.getElementById('nombre').value = "";
            document.getElementById('banco').value = "";
            document.getElementById('clabe').value = "";
            document.getElementById("rfc").disabled = false;
            document.getElementById("nombre").disabled = false;
            document.getElementById("banco").disabled = false;
            document.getElementById("clabe").disabled = false;
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
            xmlhttp.open("GET", "getvehiculo/" + str, true);
            xmlhttp.send();
        }
    }
</script>

<?php
// monday tuesday wednesday thursday friday saturday sunday
setlocale(LC_ALL, "es_MX.UTF-8");
date_default_timezone_set("America/Mexico_City");
$hora = date("H:i:s");
if (date('l') == 'Friday' or date('l') == 'Saturday' or date('l') == 'Sunday' or date('l') == 'Monday') {
    $fecha = strftime("%A, %d de %B de %Y", strtotime('next friday'));
    echo '<div class="alert alert-danger" role="alert">El servicio de programará el: <strong>' . $fecha . '</strong></div>';
} elseif (date('l') == 'Tuesday') {
    if ($hora < '17:00:00') {
        $fecha = strftime("%A, %d de %B de %Y", strtotime('next friday'));
        echo '<div class="alert alert-danger" role="alert">El servicio de programará el: <strong>' . $fecha . '</strong></div>';
    } else {
        $fecha = strftime("%A, %d de %B de %Y", strtotime('next friday + 7days'));
        echo '<div class="alert alert-danger" role="alert">El servicio de programará el: <strong>' . $fecha . '</strong></div>';
    }
} else {
    $fecha = strftime("%A, %d de %B de %Y", strtotime('next friday + 7days'));
    echo '<div class="alert alert-danger" role="alert">El servicio de programará el: <strong>' . $fecha . '</strong></div>';
}
?>

<h3>SOLICITUD DE SERVICIO / REPARACIÓN </h3>
<div class="col-md-12">
    <p class="text-justify">
        Para realizar tu solicitud necesitas los siguientes datos:
    <ul>
        <li>•Placas del vehículo que ingresará a servicio</li>
        <li>•kilometraje actual</li>
        <li>Costo de servicio, cotizado previamente por el proveedor servicio (no es necesario envíar cotización)</li>
        <li>Servicio / Reparación a realizar (DETALLAR EL SERVICIO)</li>
        <li>Medio de pago (Cuando se seleccione el pago por transferencia se habilitarán los campos para llenar los datos necesarios)</li>
    </ul>
    Todos los datos anteriores son necesarios para poder hacer la solicitud 
    <h4>Programación del servicio vehicular y fondeo de recursos</h4>
    <strong>Programación del servicio vehicular</strong><br>
    <p class="text-justify">
        Toda solicitud recibida hasta el día Martes a las 4:59:59 pm será programada para 
        ingreso a servicio los días Viernes de la semana en curso y las solicitudes recibidas 
        a partir de las 5:00 pm, serán programadas automáticamente para el siguiente Viernes.
    </p>
    <p class="text-justify">
        La autorización de los servicios se dará en un plazo máximo hasta el día Miércoles de la semana en curso que se ingresan los servicios. 
        El fondeo de los recursos por cualquier medio de pago será los días Viernes de la semana en curso en que se ingresa el vehículo a servicio. 
    </p>
</p>
</div>

<div class="col-lg-12 col-md-12">
    <form enctype="multipart/form-data" method="post" action="<?php echo base_url() ?>index.php/vehiculos/almacenarservicionuevo">
        <div class="form-group col-md-12">
            <label>SELECCIONA EL VEHÍCULO:</label>
            <select name="idvehiculo" class="form-control" required="" onchange="mostrarVehiculo(this.value)" >
                <?php
                $query = $this->db->query('select * from vehiculos where coordinador_administrativo = '.$_SESSION[id]);
                if ($query->num_rows() > 0) {
                    echo '<option value=""></option>';
                    foreach ($query->result() as $row) {
                        echo '<option value="' . $row->idvehiculo . '">' . $row->placas . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="col-md-12" id="txtvehiculo"> 

        </div>
        <hr>
        <!-- usuario.id  -->
        <div class="form-group col-md-6">
            <label>KILOMETRAJE ACTUAL</label>
            <div class="input-group">
                <input type="text" name="kilometraje_actual" onkeyup="kilometraje(this)" required="" style="text-transform: uppercase" maxlength="6" class="form-control" placeholder="18559">
                <span class="input-group-addon">KM</span>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label>COSTO DEL SERVICIO: </label>
            <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="number"  name="costo_neto" required=""  class="form-control" placeholder=" ejemplo: 2953.83 o 952.35 o 625">
                <span class="input-group-addon">pesos</span>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label>SERVICIO / REPARACIÓN</label>
            <textarea name="observaciones" rows="1" class="form-control" required="" style="text-transform: uppercase"></textarea>
        </div>
        <div class="form-group col-md-6">
            <label for="exampleInputFile">COTIZACIÓN</label>
            <input type="file" accept="application/pdf" name="cotizacion">
            <p class="help-block">La cotización tendrá que ser en formato pdf.</p>
        </div>

        <hr>

        <div class="form-group col-md-12">
            <label>MEDIO DE PAGO:</label>
            <select class="form-control" name="mediode_pago" onchange="medioDePago(this.value)">
                <option value="0">NO ESPECIFICADO</option>
                <option value="1" selected="">EDENRED</option>
                <option value="2">TRANSFERENCIA A PROVEEDOR</option>
                <option value="3">TRASNFERENCIA A USUARIO</option>
            </select>
        </div>

        <div class="form-group col-md-6">
            <label>RFC PROVEEDOR:</label>
            <input id="rfc" type="text" name="rfc_proveedor" required="" maxlength="13" class="form-control"  disabled="" style="text-transform: uppercase">
        </div>
        <div class="form-group col-md-6">
            <label>NOMBRE DEL BENEFICIARIO:</label>
            <input id="nombre" type="text" name="nombre_proveedor" required=""  maxlength="200" class="form-control" disabled="" style="text-transform: uppercase">
        </div>
        <div class="form-group col-md-6">
            <label>BANCO:</label>
            <input id="banco" type="text" name="banco_proveedor" required=""  maxlength="40" class="form-control" disabled="">
        </div>
        <div class="form-group col-md-6">
            <label>CLABE:</label>
            <input id="clabe" type="text" name="clabe_proveedor" onkeyup="clabeinterbancaria(this)" required="" style="text-transform: uppercase" maxlength="18" class="form-control" disabled="">
        </div>
        <br>
        <div class="form-group col-xs-12">
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Solicitar servicio </button>
        </div>

    </form>

    <!-- Button trigger modal -->
<!--    <button type="button" class="btn btn-primary col-lg-3" data-toggle="modal" data-target="#myModal">
        Instrucciones 
    </button>-->

    <br>
    <br>
    <hr>
</div>
<div class="col-lg-12 col-md-12">

<!--     Modal instrucciones de uso para la solicitud de servicio vehicular 
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Instrucciones para la solicitud de servicio vehicular</h4>
                </div>
                <div class="modal-body">
                    Necesitas tener la siguiente información
                    <ul>
                        <li>Placas del vehiculo el cual se hará su servicio</li>
                        <li>Tipo de Servicio</li>
                        <li>kilometraje actual</li>
                        <li>Proyecto en el que se usa el vehiculo</li>
                        <li>Costo de servicio, cotizado previamente por el proveedor
                            servicio</li>
                        <li>Observaciones y/o especificaciones del servicio a 
                            ralizar al vehiculo</li>
                    </ul>
                    <h4>Fecha de programación de fondeo y servicio vehicular</h4>
                    <h5>Solicitud ingresada entre viernes y martes</h5>
                    La solicitud de realizada dentro de los días viernes, sabado, 
                    domingo, lunes o martes, se programará la fecha para fondeo
                    y servicio vehicular  para el viernes siguiente, por ejemplo:
                    si solicitas el servicio el viernes, 06 de mayo de 2016 ó 
                    domingo, 8 de mayo de 2016, el servicio se programa automaticamente
                    para el viernes 13 de mayo de 2016.
                    <h5>Solicitud ingresada en miercoles ó jueves</h5>
                    La solicitud se realiza en miercoles o jueves, se programará
                    para el siguiente viernes + 7 días, por ejemplo: si la solicitud 
                    se realiza el miercoles, 11 de mayo ó el jueves, 12 de mayo de 2016
                    el servicio se programará para el 20 de mayo de 2016.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>-->


    <br>
    <br>
</div>
