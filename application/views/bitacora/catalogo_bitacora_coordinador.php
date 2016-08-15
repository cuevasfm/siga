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
<div class="page-header">
    <h2>Busqueda por fecha <small></small></h2>
</div>

<form class="form-inline" method="post" action="<?php echo base_url() ?>index.php/bitacora/fecha">
    <div class="form-group">
        <label>Fecha</label>
<!--        <input type="date" class="form-control" name="fecha1" required>-->
        <input type="text" class="form-control" onkeyup="Validar(this, '-', patron, true)"  maxlength="10" name="fecha1" value="" required placeholder="AAAA/MM/DD">
    </div>
    <div class="form-group">
        <label>Entre</label>
<!--        <input type="date" class="form-control" name="fecha2" required>-->
        <input type="text" class="form-control" onkeyup="Validar(this, '-', patron, true)"  maxlength="10" name="fecha2" value="" required placeholder="AAAA/MM/DD">
    </div>
    <div class="form-group">
        <label>Vehículo</label>
        <select name="idvehiculo" class="form-control">

            <?php
            $query_lista_vehicular = $this->db->query('select idvehiculo, placas, modelo from vehiculos where coordinador_administrativo = ' . $_SESSION['id']);
            if ($query_lista_vehicular->num_rows() > 0) {
                foreach ($query_lista_vehicular->result() as $xrow) {
                    echo '<option value = "' . $xrow->idvehiculo . '"> ' . $xrow->placas . ' ' . $xrow->modelo . '</option>';
                }
            }
            ?>

        </select>
    </div>
    <button type="submit" class="btn btn-default">Buscar</button>
</form>

<div class="page-header">
    <h2>Bitácora de servicios / reparaciones <small>Coodinador Administrativo</small></h2>
</div>

<?php
$query = $this->db->query('select * from vehiculos join marcasvehiculos on vehiculos.marca = marcasvehiculos.id JOIN usuarios ON vehiculos.usuario_actual = usuarios.id where coordinador_administrativo = ' . $_SESSION['id']);

if ($query->num_rows() > 0) {
    echo '<table class="table table-hover" style="font-size: 12px">
    <tr>
        <th>Id</th>
        <th>Placas</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Serie</th>
        <th>Año</th>
        <th>Usuario Actual</th>
        <th></th>
    </tr>';

    foreach ($query->result() as $row) {
        echo '<tr>';
        echo '<td>' . $row->idvehiculo . '</td>';
        echo '<td>' . $row->placas . '</td>';
        echo '<td>' . $row->marca . '</td>';
        echo '<td>' . $row->modelo . '</td>';
        echo '<td>' . $row->serie . '</td>';
        echo '<td>' . $row->anio . '</td>';
        echo '<td><a href="' . base_url() . 'index.php/sesion/usuario/' . $row->id . '">' . $row->nombre . ' ' . $row->ap_paterno . '</a></td>';
        echo '<td><a href="' . base_url() . 'index.php/bitacora/vehiculo/' . $row->idvehiculo . '"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></td>';
        echo '</tr>';
    }
} else {
    echo 'no existen resultados para esta solicitud ';
}
echo '</table>';
?>

<a href=""></a>
