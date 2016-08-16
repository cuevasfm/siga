<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<div class="row">
    <div class="col-md-12"><h1>Bienvenido <?php echo $_SESSION['usuario']; ?>!</h1></div>
    <div class="col-md-1"></div>
    <div class="col-md-11">

        <div class="col-md-8">
            <h3>¿Como hacer una solicitud?<small> 15/08/2016 - 18:23:00 hrs - Miguel C. </small></h3>
            <img src="<?php echo base_url(); ?>/media/blog/banner-instrucciones.jpg" class="img-responsive" alt="Responsive image"><br>
            <p class="text-justify">
                Para realizar tu solicitud necesitas los siguientes datos:
            <ul>
                <li>Placas del vehículo que ingresará a servicio</li>
                <li>kilometraje actual</li>
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
            <a href="<?php echo base_url(); ?>index.php/vehiculos/solicitudservicio" class="btn btn-primary btn-lg btn-block" role="button">Solicitar Servicio / Reparación</a>
        </div>
        <hr>
    </div>
</div>


