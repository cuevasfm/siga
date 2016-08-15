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
<h1>Agregar nuevo vehiculo</h1>

<div class="col-lg-8 col-md-10">
    <form class="form-horizontal" method="post" action="<?php echo base_url() ?>index.php/vehiculos/guardarvehiculo">
        <div class="form-group">
            <label class="col-sm-3 control-label">Placas</label>
            <div class="col-sm-9">
                <input type="placas" class="form-control" placeholder="123-KEW" style="text-transform: uppercase;" maxlength="9" required autofocus>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Placas</label>
            <div class="col-sm-9">
                <select name="marca" class="form-control" required="">
                    <?php
                    $query = $this->db->query('select * from marcasvehiculos');
                    if ($query->num_rows() > 0) {
                        foreach ($query->result() as $row) {
                            echo '<option value="' . $row->id . '">' . $row->marca . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Modelo</label>
            <div class="col-sm-9">
                <input type="text" name="modelo" style="text-transform: uppercase" maxlength="60" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Serie</label>
            <div class="col-sm-9">
                <input type="text" name="serie" style="text-transform: uppercase" maxlength="20" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Año</label>
            <div class="col-sm-9">
                <select name="anio" class="form-control" required>
                    <?php
                    $y = 2000;
                    $anio = date(Y) + 1;
                    while ($y <= $anio) {
                        echo '<option value="' . $y . '">' . $y . '</option>';
                        $y++;
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Agente seguro</label>
            <div class="col-sm-9">
                <input type="text"name="agente_seguro" style="text-transform: uppercase" maxlength="40" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Aseguradora</label>
            <div class="col-sm-9">
                <input type="text"name="emp_seguro" style="text-transform: uppercase" maxlength="40" class="form-control">
            </div>
        </div><div class="form-group">
            <label class="col-sm-3 control-label">Vencimiento seguro</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" onkeyup="Validar(this, '-', patron, true)"  maxlength="10" name="vencimiento_seguro" value="" required placeholder="AAAA-MM-DD">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Tarjeta de circulación</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" onkeyup="Validar(this, '-', patron, true)"  maxlength="10" name="tarjeta_circulacion" value="" required placeholder="AAAA-MM-DD">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Usuario actual</label>
            <div class="col-sm-9">
                <select name="usuario_actual" class="form-control">
                    <?php
                    $query = $this->db->query('select * from usuarios');
                    if ($query->num_rows() > 0) {
                        foreach ($query->result() as $row) {
                            echo '<option value="' . $row->id . '">' . $row->nombre . ' ' . $row->ap_paterno . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Próxima verificación</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" onkeyup="Validar(this, '-', patron, true)"  maxlength="10" name="proxima_verificacion" value="" required placeholder="AAAA-MM-DD">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-danger">Guardar Vehículo</button>
            </div>
        </div>
    </form>
</div>
