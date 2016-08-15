<script type="text/javascript">
    function validarPasswd() {
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
        if (p1.length <= 5 || p2.length <= 5) {
            alert("La contraseña debe contener al menos 6 caracteres");
            return false;
        }
        if (p1 != p2) {
            alert("Las passwords deben de coincidir");
            return false;
        } else {
            var x = confirm("¿Esta seguro de actualizar la contraseña? ");
            if (x) {
                return true;
            } else {
                return false;
            }
        }
    }
</script>
<div class="col-lg-6">
    <h2>Editar datos de usuario: <?php echo $_SESSION['id']; ?></h2>
    <?php
    $queryusuario = $this->db->query('SELECT usuario, nombre, ap_paterno, ap_materno, email, nivel FROM usuarios WHERE id = "' . $_SESSION['id'] . '"');
    if ($queryusuario->num_rows() > 0) {
        foreach ($queryusuario->result() as $row_u) {
            $nombre = $row_u->nombre;
            $usuario = $row_u->usuario;
            $ap_paterno = $row_u->ap_paterno;
            $ap_materno = $row_u->ap_materno;
            $email = $row_u->email;
            $nivel = $row_u->nivel;
        }
    }
    ?>
    <form class="form-horizontal" method="post" action="<?php echo base_url() ?>index.php/dashboard/actualizarperfil">
        <div class="form-group">
            <label class="col-sm-5 control-label">ID</label>
            <div class="col-sm-7">
                <input type="text" name="id" class="form-control"  value="<?php echo $_SESSION['id']; ?>" disabled>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">Usuario</label>
            <div class="col-sm-7">
                <input type="text" name="usuario" class="form-control"  value="<?php echo $usuario; ?>" disabled>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">Nombre</label>
            <div class="col-sm-7">
                <input type="text" name="nombre"  value="<?php echo $nombre; ?>" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">Apellido Paterno</label>
            <div class="col-sm-7">
                <input type="text" name="ap_paterno"  value="<?php echo $ap_paterno; ?>" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">Apellido Materno</label>
            <div class="col-sm-7">
                <input type="text" name="ap_materno"  value="<?php echo $ap_materno; ?>" class="form-control" placeholder="Este dato podrá estar en blanco">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">E-Mail</label> 
            <div class="col-sm-7">
                <input type="email" name="email" value="<?php echo $email; ?>" class="form-control">
            </div>
        </div>
        <!--        <button type="submit" class="btn btn-default">Actualizar</button>-->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" value="Submit" class="btn btn-danger"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Actualizar datos</button>
            </div>
        </div>
    </form>

    <h3>Cambiar contraseña <small></small></h3>
    <form class="form-horizontal" name="registrousuario" method="post" action="<?php echo base_url() ?>index.php/dashboard/actpswd/<?php echo $_SESSION['id']; ?>" onSubmit="return validarPasswd()">

        <div class="form-group">
            <label class="col-sm-5 control-label">Contraseña</label>
            <div class="col-sm-7">
                <input type="password" id="password" name="password" class="form-control" maxlength="30" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">Confir Contraseña</label>
            <div class="col-sm-7">
                <input type="password" id="password2" name="password2" class="form-control" maxlength="30" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" value="Submit" class="btn btn-danger"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Cambiar Contraseña</button>
            </div>
        </div>
    </form>



</div>