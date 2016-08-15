<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript">
    
    function solo_numero(val){
        numero = intToFloat(val,2);
        return numero;
    }
    function ValNumero(Control){
        Control.value=solo_numerico(Control.value);
    }
    
    function clabeinterbancaria(txb) {
        txb.value = txb.value.replace(/[^0-9]/, "");
    }
    function validarrfc(rfc) {
        rfc.value = rfc.value.replace(/[A-Z,Ñ,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]?[A-Z,0-9]?[0-9,A-Z]?"/, "");
    }
</script>
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
<h3>Editar servicio <small>ID:<?php echo $idservicio_vehicular . ' ' . $modelo; ?> </small></h3>
<div class="col-md-6">
    <form class="form-horizontal" method="post" action="<?php echo base_url() ?>index.php/vehiculos/actualizarservicio/<?php echo $idservicio_vehicular ?>">
        
        <div class="form-group">
            <label  class="col-sm-5 control-label">Costo Servicio</label>
            <div class="col-sm-7">
                <input type="number" name="costo_neto" onkeyUp="return ValNumero(this);" class="form-control" value="<?php echo $costo_neto; ?>" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-5 control-label">Estatus Autorización</label>
            <div class="col-sm-7">
                <select class="form-control" name="estatus_autorizacion">
                    <?php
                    $e0 = '';
                    $e1 = '';
                    if ($estatus_autorizacion == '0') {
                        $e0 = 'selected';
                    } elseif ($estatus_autorizacion == '1') {
                        $e1 = 'selected';
                    }
                    ?>

                    <option value="0" <?php echo $e0; ?>>No Autorizado</option>
                    <option value="1" <?php echo $e1; ?>>Autorizado</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-5 control-label"><abbr title="Dato de control">Finalizado</abbr></label>
            <div class="col-sm-7">
                <select class="form-control" name="check">
                    <?php
                    $f0 = '';
                    $f1 = '';
                    if ($check == '0') {
                        $f0 = 'selected';
                    } elseif ($check == '1') {
                        $f1 = 'selected';
                    }
                    ?>
                    <option value="0" <?php echo $f0; ?>>No</option>
                    <option value="1" <?php echo $f1; ?>>Si</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">Fecha Servicio:</label>
            <div class="col-sm-7">
                <input type="text" name="fecha_servicio" class="form-control" onkeyup="Validar(this, '-', patron, true)"  maxlength="10" name="fecha1" value="<?php echo $fecha_servicio; ?>" required placeholder="AAAA/MM/DD">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">Kilometraje Actual:</label>
            <div class="col-sm-7">
                <input type="number" name="kilometraje_actual" class="form-control" value="<?php echo $kilometraje_actual; ?>" placeholder="" >
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-5 control-label">Medio Pago:</label>
            <div class="col-sm-7">
                <select class="form-control" name="mediode_pago" onload="mediopago(this.value)" onchange="mediopago(this.value)" >
                    <?php
                    $s0 = '';
                    $s1 = '';
                    $s2 = '';
                    $s3 = '';
                    if ($mediode_pago == '0') {
                        $s0 = 'selected';
                    } elseif ($mediode_pago == '1') {
                        $s1 = 'selected';
                    } elseif ($mediode_pago == '2') {
                        $s2 = 'selected';
                    } elseif ($mediode_pago == '3') {
                        $s3 = 'selected';
                    }
                    ?>
                    <option value="0" <?php echo $s0; ?>>No especificado</option>
                    <option value="1" <?php echo $s1; ?>>EdenRed</option>
                    <option value="2" <?php echo $s2; ?>>Transferencia a proveedor</option>
                    <option value="3" <?php echo $s3; ?>>Transferencia a usuario</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-5 control-label">RFC Proveedor:</label>
            <div class="col-sm-7">
                <input type="text" name="rfc_proveedor" class="form-control" value="<?php echo $rfc_proveedor; ?>" placeholder maxlength="13" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">Nombre Del Beneficiario:</label>
            <div class="col-sm-7">
                <input type="text" name="nombre_proveedor" class="form-control" value="<?php echo $nombre_proveedor; ?>" placeholder maxlength="200" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">Banco:</label>
            <div class="col-sm-7">
                <input type="text" name="banco_proveedor" class="form-control" value="<?php echo $banco_proveedor; ?>" placeholder maxlength="40" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label"><abbr title="Clave Bancaria Estandarizada">Clabe</abbr></label>
            <div class="col-sm-7">
                <input type="text" name="clabe_proveedor" class="form-control" onkeyup="clabeinterbancaria(this)" value="<?php echo $clabe_proveedor; ?>" placeholder maxlength="18" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">Observaciones:</label>
            <div class="col-sm-7">
                <textarea name="observaciones" class="form-control" rows="2"><?php echo $observaciones; ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-danger">Guardar Cambios</button>
            </div>
        </div>
    </form>
    <br><br><br><br>
</div>

