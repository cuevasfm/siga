<script type="text/javascript">
    function validarPasswd() {
        var usuario = document.getElementById("usuario").value;
        var espacios1 = false;
        var cont1 = 0;
        while (!espacios1 && (cont1 < usuario.length)) {
            if (usuario.charAt(cont1) == " ")
                espacios1 = true;
            cont1++;
        }
        if (espacios1) {
            alert("El nombre de usuario no debe contener espacios en blanco");
            return false;
        }

        var p1 = document.getElementById("password").value;
        var p2 = document.getElementById("password2").value;
        var espacios = false;
        var cont = 0;
        while (!espacios && (cont < p1.length)) {
            if (p1.charAt(cont) == " ")
                espacios = true;
            cont++;
        }
        if (espacios) {
            alert("La contraseña no puede contener espacios en blanco");
            return false;
        }

        if (p1.length == 0 || p2.length == 0) {
            alert("Los campos de la password no pueden quedar vacios");
            return false;
        }
        if (p1 != p2) {
            alert("Las passwords deben de coincidir");
            return false;
        } else {
            var x = confirm("Esta seguro de almacenar el usuario ");
            if (x) {
                return true;
            } else {
                return false;
            }
        }
    }
</script>

<div class="col-md-8">
    <h1>Agregar nuevo usuario al sistema</h1>
    <form class="form-horizontal" name="registrousuario" method="post" action="<?php echo base_url() ?>index.php/sesion/guardarusuario" onSubmit="return validarPasswd()">
        <div class="form-group">
            <label class="col-sm-3 control-label">Usuario</label>
            <div class="col-sm-9">
                <input type="text" id="usuario" name="usuario" class="form-control" maxlength="30" required autofocus="">
            </div>
            <div class="col-sm-2 control-label" id="username"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Contraseña</label>
            <div class="col-sm-9">
                <input type="password" id="password" name="password" class="form-control" maxlength="30" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Confir Contraseña</label>
            <div class="col-sm-9">
                <input type="password" id="password2" name="password2" class="form-control" maxlength="30" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Nombre(s)</label>
            <div class="col-sm-9">
                <input type="text" name="nombre" class="form-control" maxlength="80" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Apellido Paterno</label>
            <div class="col-sm-9">
                <input type="text" name="ap_paterno"class="form-control" maxlength="80" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Apellido Materno</label>
            <div class="col-sm-9">
                <input type="text" name="ap_materno" class="form-control" maxlength="80"form="s">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
                <input type="email" name="email" class="form-control" maxlength="100" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Nivel</label>
            <div class="col-sm-9">
                <select name="nivel" class="form-control">
                    <option value="administrador">Administrador</option>
                    <option value="coordinador administrativo" selected="">Coordinador Administrativo</option>
                    <option value="usuario" selected="">Usuario</option>
                    <option value="lector">lector</option>
                    <option value="colaborador">Colaborador</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Obra Actual</label>
            <div class="col-sm-9">
                <select name="obra_actual" class="form-control">
                    <?php
                    $query = $this->db->query('SELECT idobras, nombre, localizacion FROM obras');
                    if ($query->num_rows() > 0) {
                        foreach ($query->result() as $row) {
                            ?>
                            <option value="<?php echo $row->idobras; ?>"><?php echo $row->nombre . ' En: ' . $row->localizacion; ?> </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <button type="submit" value="Submit" class="btn btn-default"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Agregar Usuario</button>
    </form>
</div>


