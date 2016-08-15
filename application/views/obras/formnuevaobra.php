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


<div class="col-md-8">
    <h3>Agregar nuevo contrato y/o proyecto u oficina</h3>
    <form class="form-horizontal" method="post" action="<?php echo base_url() ?>index.php/obras/guardarobra">
        <div class="form-group">
            <label class="col-sm-3 control-label">Nombre</label>
            <div class="col-sm-9">
                <input type="text" name="nombre"class="form-control" maxlength="199" required>
            </div>

        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Localizado:</label>
            <div class="col-sm-9">
                <select name="localizacion" class="form-control">
                    <option value="Aguascalientes" selected>Aguascalientes</option>
                    <option value="Baja California">Baja California</option>
                    <option value="Baja California Sur">Baja California Sur</option>
                    <option value="Campeche">Campeche</option>
                    <option value="Chihuahua">Chihuahua</option>
                    <option value="Ciudad de México">Ciudad de México</option>
                    <option value="Coahuila de Zaragoza">Coahuila de Zaragoza</option>
                    <option value="Colima">Colima</option>
                    <option value="Durango">Durango</option>
                    <option value="Guanajuato">Guanajuato</option>
                    <option value="Guerrero">Guerrero</option>
                    <option value="Hidalgo">Hidalgo</option>
                    <option value="Jalisco">Jalisco</option>
                    <option value="México">México</option>
                    <option value="Michoacán de Ocampo">Michoacán de Ocampo</option>
                    <option value="Morelos">Morelos</option>
                    <option value="Nayarit">Nayarit</option>
                    <option value="Nuevo León">Nuevo León</option>
                    <option value="Oaxaca">Oaxaca</option>
                    <option value="Puebla">Puebla</option>
                    <option value="Querétaro de Arteaga">Querétaro de Arteaga</option>
                    <option value="Quintana Roo">Quintana Roo</option>
                    <option value="San Luis Potosí">San Luis Potosí</option>
                    <option value="Sinaloa">Sinaloa</option>
                    <option value="Sonora">Sonora</option>
                    <option value="Tabasco">Tabasco</option>
                    <option value="Tamaulipas">Tamaulipas</option>
                    <option value="Tlaxcala">Tlaxcala</option>
                    <option value="Veracruz de Ignacio de la Llave">Veracruz de Ignacio de la Llave</option>
                    <option value="Yucatán">Yucatán</option>
                    <option value="Zacatecas">Zacatecas</option>                    
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Fecha Inicio</label>
            <div class="col-sm-9">
                <input type="text" name="fecha_inicio" class="form-control" onkeyup="Validar(this, '-', patron, true)" placeholder="AAAA-MM-DD">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Fecha Termino</label>
            <div class="col-sm-9">
                <input type="text" name="fecha_termino" class="form-control" onkeyup="Validar(this, '-', patron, true)" placeholder="AAAA-MM-DD">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Estatus</label>
            <div class="col-sm-9">
                <select name="estatus" class="form-control">
                    <option value="activo" selected>Activo</option>
                    <option value="terminado">Terminado</option>
                    <option value="cancelado">Cancelado</option>
                    <option value="otros">otros</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Gerencia</label>
            <div class="col-sm-9">
                <select name="gerencia" class="form-control" required>
                    <option value="Planeación y control" selected>Planeación y control</option>
                    <option value="Supervisión de carreteras">Supervisión de carreteras</option>
                    <option value="Supervisión de proyectos">Supervisión de proyectos</option>
                    <option value="Energía">Energía</option>
                    <option value="Otros">Otros</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-info">Agregar Obra</button>
    </form>
</div>

