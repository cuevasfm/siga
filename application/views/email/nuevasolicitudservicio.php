<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Correo de prueba</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    </head>
    <body>
        <div>
            <div style="font-size: 26px;font-weight: 700;letter-spacing: -0.02em;line-height: 32px;color: #41637e;font-family: sans-serif;text-align: center" align="center" id="emb-email-header">
                <img style="border: 0;-ms-interpolation-mode: bicubic;display: block;Margin-left: auto;Margin-right: auto;max-width: 281px" src="http://miguelcuevas.xyz/siga/media/imagotipoin.png">
            </div>
            <p style="Margin-top: 0;color: #000;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Hola: <?php echo $username; ?> </p> 
            <p style="Margin-top: 0;color: #000;font-family: Arial; font-size: 16px;line-height: 25px;Margin-bottom: 25px"> 
                Su solicitud se almacenó correctamente con #<?php echo $id; ?></p>
            <p style="Margin-top: 0;color: #000;font-family: Arial; font-size: 16px;line-height: 25px;Margin-bottom: 25px"> 
                Las observaciones del servicio solicitado fue: <?php echo $observaciones; ?> con un costo de: <?php echo $costo_neto; ?> para el vehiculo con
            placas: <?php echo $placas; ?> modelo: <?php echo $modelo; ?>, el usuario actual es: <?php echo $nombre; ?> <?php echo $ap_paterno; ?></p>
            
            <p style="Margin-top: 0;color: #000;font-family: Arial; font-size: 16px;line-height: 25px;Margin-bottom: 25px"> 
                El vehículo esta registrado en el proyecto: <?php echo $obra; ?> en el estado de: <?php echo $localizacion; ?>
                
               </p>
            
            <p style="Margin-top: 0;color: #565656;font-family: Arial; font-size: 16px;line-height: 25px;Margin-bottom: 25px"> 
                Cualquier duda o aclaración podrá hacerla directamente con el coordinador de flotillas </p>
            
        </div>
    </body>
</html>