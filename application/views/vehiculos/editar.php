<script type="text/javascript">
    var patron = new Array(4, 2, 2)
    function Validar(elem, separador, pat, numerico) {
        if (elem.valoranterior != elem.value) {
            valor = elem.value;
            largo = valor.length;
            valor = valor.split(separador);
            valor2 = "";

            for (i = 0; i < valor.length; i++) {
                valor2 += valor[i];
            }

            if (numerico) {
                for (j = 0; j < valor2.length; j++) {
                    if (isNaN(valor2.charAt(j))) {
                        letra = new RegExp(valor2.charAt(j), "g");
                        valor2 = valor2.replace(letra, "");
                    }
                }
            }

            valor = "";
            valor3 = new Array();
            for (n = 0; n < pat.length; n++) {
                valor3[n] = valor2.substring(0, pat[n]);
                valor2 = valor2.substr(pat[n]);
            }

            for (q = 0; q < valor3.length; q++) {
                if (q == 0) {
                    valor = valor3[q];
                } else {
                    if (valor3[q] != "") {
                        if (valor3[1] > 12) {
                            valor = valor3[0];
                        } else if (valor3[2] > 31) {
                            valor = valor3[0] + separador + valor3[1];
                        } else {
                            valor += separador + valor3[q];
                        }

                    }
                }
            }

            elem.value = valor;
            elem.valoranterior = valor;
        }
    }
</script>
<br>
<br>
<div class="col-lg-12">

    <h2>Información general del vehiculo</h2>
    <?php
    $query_informacion_vehiculo = $this->db->query('select * from vehiculos where idvehiculo = ' . $id);
    $query2 = $this->db->query('select * from marcasvehiculos');
    if ($query_informacion_vehiculo->num_rows() > 0) {
        foreach ($query_informacion_vehiculo->result() as $row) {
            $idvehiculo = $row->idvehiculo;
            $placas = $row->placas;
            $marca = $row->marca;
            $modelo = $row->modelo;
            $serie = $row->serie;
            $anio = $row->anio;
            $agente_seguro = $row->agente_seguro;
            $emp_seguro = $row->emp_seguro;
            $vencimiento_seguro = $row->vencimiento_seguro;
            $tarjeta_circulacion = $row->tarjeta_circulacion;
            $usuario_actual = $row->usuario_actual;
            $poliza_archivo = $row->poliza_archivo;
            $proxima_verificacion = $row->proxima_verificacion;
        }
    }
    $query_marcasid = $this->db->query('select * from marcasvehiculos where id = ' . $marca);
    if ($query_marcasid->num_rows() > 0) {
        foreach ($query_marcasid->result() as $row3) {
            $idmarca = $row3->id;
            $marcavehiculo = $row3->marca;
        }
    }
    ?>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Datos del vehículo</h3>
            </div>
            <div class="panel-body">
                <div class="col-sm-4">
                    <ul class="list-group">
                        <li class="list-group-item">Placas: <?php echo $placas; ?></li>
                        <li class="list-group-item">Marca: <?php echo $marcavehiculo; ?></li>
                        <li class="list-group-item">Modelo: <?php echo $modelo; ?></li>
                        <li class="list-group-item">Serie: <?php echo $serie; ?></li>
                        <li class="list-group-item">Año: <?php echo $anio; ?></li>
                    </ul>   
                </div>
                <div class="col-sm-4">
                    <ul class="list-group">
                        <li class="list-group-item">Agente de seguro: <?php echo $agente_seguro; ?></li>
                        <li class="list-group-item">Aseguradora: <?php echo $emp_seguro; ?></li>
                        <li class="list-group-item">Vencimiento seguro: <?php echo $vencimiento_seguro; ?></li>
                        <li class="list-group-item">Tarjeta de circulación: <?php echo $tarjeta_circulacion; ?></li>
                        <li class="list-group-item">Usuario actual: <?php echo $usuario_actual; ?></li>
                    </ul>   
                </div>
                <div class="col-sm-4">
                    <ul class="list-group">
                        <li class="list-group-item">Próxima verificación: <?php echo $proxima_verificacion; ?></li>
                        <li class="list-group-item">Estatus: Activo</li>
                        <li class="list-group-item">Poliza de seguro: no existe</li>
                        <li class="list-group-item">Factura: </li>
                        <li class="list-group-item">Precio: </li>
                    </ul>   
                </div>

            </div>
        </div>
    </div>
    <!--    <div class="col-md-6">
            <div class="panel panel-default">
                <dl class="dl-horizontal ">
                    <dt>Placas</dt>
                    <dd><?php echo $placas; ?></dd>
                    <dt>Marca</dt>
                    <dd><?php echo $marcavehiculo; ?></dd>
                    <dt>Modelo</dt>
                    <dd><?php echo $modelo; ?></dd>
                    <dt>Serie</dt>
                    <dd><?php echo $serie; ?></dd>
                    <dt>Año</dt>
                    <dd><?php echo $anio; ?></dd>
                    <dt>Agente de seguro</dt>
                    <dd><?php echo $agente_seguro; ?></dd>
                    <dt>Aseguradora</dt>
                    <dd><?php echo $emp_seguro; ?></dd>
                    <dt>Vencimiento de seguro</dt>
                    <dd><?php echo $vencimiento_seguro; ?></dd>
                    <dt>Tarjeta de circulación</dt>
                    <dd><?php echo $tarjeta_circulacion; ?></dd>
                    <dt>Usuario actual</dt>
                    <dd><?php echo $usuario_actual; ?></dd>
                    <dt>Proxima verificación</dt>
                    <dd><?php echo $proxima_verificacion; ?></dd>
                    <dt>Estatus</dt>
                    <dd><?php echo $proxima_verificacion; ?></dd>
                    <dt>Poliza de seguro</dt>
                    <dd><?php echo $proxima_verificacion; ?></dd>
                </dl> 
            </div>
        </div>-->

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <a class="btn btn-default btn-lg btn-block" href="<?php echo base_url() . 'index.php/bitacora/vehiculo/' . $id . '/'; ?>" role="button">
                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Bitácora
                </a>
                <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#editarVehiculo">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar vehículo
                </button>
                <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#polizaSeguro">
                    <span class="glyphicon glyphicon-open-file" aria-hidden="true"></span> Poliza de seguro
                </button>
                <button type="button" class="btn btn-danger btn-lg btn-block" data-toggle="modal" data-target="#vendido">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Vehículo vendido
                </button>
                <button type="button" class="btn btn-warning btn-lg btn-block" data-toggle="modal" data-target="#reporteSiniestro">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Reporte de siniestro
                </button>                
            </div>
        </div>
    </div>

</div>
<div class="col-lg-12">
    <br>    <h2>Fotografias del auto</h2>
    <?php
    $queryfotos_vehiculos = $this->db->query('select * from fotos_vehiculos where idvehiculo = ' . $id);
    if ($queryfotos_vehiculos->num_rows() > 0) {
        foreach ($queryfotos_vehiculos->result() as $row7) {
            echo '<div class="col-sm-6 col-md-4"><div class="thumbnail">';
            echo '<img src="' . base_url() . '/subidas/vehiculos/' . $row7->nombre_url . '" alt="...">';
            echo '<div class="caption">';
            echo '<h5>' . $row7->nombre_url . '</h5>';
            echo '<p>Imagen subida por: ' . $row7->idusuario . ' </p>';
            echo '<p>Fecha: ' . $row7->fecha . ' </p>';
            echo '<p><a href="' . base_url() . 'index.php/vehiculos/eliminarfotovehiculo/' . $row7->nombre_url . '/' . $row7->idfotos_vehiculos . '/' . $id . '" class="btn btn-danger" role="button">Eliminar</a></p>';
            echo '</div></div></div>';
        }
    } else {
        echo '<h4> No existen registros de fotografias para este vehiculo</h4>';
    }
    ?>

    <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
            <h3>Subir Imagen</h3>
            <?php echo form_open_multipart(base_url() . 'index.php/vehiculos/imgauto/' . trim($id)); ?>
            <input type="file" name="userfile" size="20" />
            <br /><br />
            <input type="submit" value="Cargar Foto" />
            <?= form_close() ?>        
        </div>
    </div>



</div>

<!-- Modal -->
<div class="modal fade" id="editarVehiculo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Editar datos del vehículo</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="<?php echo base_url() ?>index.php/vehiculos/actualizarvehiculo/<?php echo trim($id) ?>">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Placas</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="placas" value="<?php echo $placas; ?>">
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="col-sm-4 control-label">Marca</label>
                        <div class="col-sm-8">
                            <select name="marca" class="form-control" required="">
                                <?php
                                if ($query2->num_rows() > 0) {
                                    foreach ($query2->result() as $row2) {
                                        if ($marca == $row2->id) {
                                            echo '<option value="' . $row2->id . '"  selected>' . $row2->marca . '</option>';
                                        } else {
                                            echo '<option value="' . $row2->id . '">' . $row2->marca . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Modelo o submarca</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="modelo" value="<?php echo $modelo; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">No. de serie</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="serie" value="<?php echo $serie; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Año</label>
                        <div class="col-sm-8">
                            <select name="anio" class="form-control" required="">
                                <?php
                                $y = 2000;
                                $anio = date(Y) + 1;
                                while ($y <= $anio) {
                                    if ($y == $row->anio) {
                                        echo '<option value="' . $y . '" selected>' . $y . '</option>';
                                        $y++;
                                    } else {
                                        echo '<option value="' . $y . '">' . $y . '</option>';
                                        $y++;
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Agente de seguro</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="agente_seguro" value="<?php echo $agente_seguro; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Aseguradora</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="emp_seguro" value="<?php echo $emp_seguro; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Vencimiento del seguro</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" onkeyup="Validar(this, '-', patron, true)"  maxlength="10" name="vencimiento_seguro" value="<?php echo $vencimiento_seguro; ?>" required placeholder="AAAA-MM-DD">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Vencimiento de la tarjeta de circulacion </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" onkeyup="Validar(this, '-', patron, true)"  maxlength="10" name="tarjeta_circulacion" value="<?php echo $tarjeta_circulacion; ?>" required placeholder="AAAA-MM-DD">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Usuario actual</label>
                        <div class="col-sm-8">
                            <select name="usuario_actual" class="form-control" required="">
                                <?php
                                $query5 = $this->db->query('select * from usuarios');
                                if ($query5->num_rows() > 0) {
                                    foreach ($query5->result() as $row4) {
                                        if ($usuario_actual == $row4->id) {
                                            echo '<option value="' . $row4->id . '" selected>' . $row4->nombre . ' ' . $row4->ap_paterno . '</option>';
                                        } else {
                                            echo '<option value="' . $row4->id . '">' . $row4->nombre . ' ' . $row4->ap_paterno . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Proxima fecha para la verificación</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" onkeyup="Validar(this, '-', patron, true)"  maxlength="10" name="proxima_verificacion" value="<?php echo $proxima_verificacion; ?>" required placeholder="AAAA-MM-DD">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-default">Actualizar</button> 
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>
<!--Dar de baja el vehiculo-->
<div class="modal fade" id="vendido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Vehículo vendido</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Fecha:</label>
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" required name="fecha">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Comprador:</label>
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" required name="fecha">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Importe de compra:</label>
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" required name="fecha">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Detalles de venta:</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" rows="2" maxlength="50"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Contrato de venta:</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="file" required accept="application/pdf">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-default">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="alert alert-warning" role="alert"><strong>¡Advertencia! </strong>Al finalizar el reporte esta aceptando dar de baja la unidad</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!--Reporte de siniestro-->
<div class="modal fade" id="reporteSiniestro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Reporte de siniestro</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Tipo:</label>
                        <div class="col-sm-8">
                            <select class="form-control">
                                <option>Siniestro</option>
                                <option>Robo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Fecha:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" required name="fecha">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Numero de reporte aseguradora:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" required name="reporte_aseguradora">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Fecha:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Observaciones:</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" rows="2" maxlength="250"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Dar de baja el vehículo:</label>
                        <div class="col-sm-8">
                            <label class="radio-inline">
                                <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1"> Si
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="0" checked> No
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Reporte de siniestro:</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="file" required accept="application/pdf">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-default">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="polizaSeguro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Reporte de siniestro</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Detalle de dar de baja:</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="file" required accept="application/pdf">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-default">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
