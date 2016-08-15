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

<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$e0 = '';
$e1 = '';
$e2 = '';
$e3 = '';
$e4 = '';

if ($nivel == 'administrador') {
    $e0 = 'selected';
} elseif ($nivel == 'usuario') {
    $e1 = 'selected';
} elseif ($nivel == 'lector') {
    $e2 = 'selected';
} elseif ($nivel == 'colaborador') {
    $e3 = 'selected';
} elseif ($nivel == 'coordinador administrativo') {
    $e4 = 'selected';
}
?>


<br>
<h3>Editar Usuario <small>ID:<?php echo $id; ?> </small></h3>
<div class="col-md-6">
    <form class="form-horizontal" method="post" action="<?php echo base_url() ?>index.php/sesion/actualizarusuario/<?php echo $id ?>/<?php echo $usuario ?>">
        <div class="form-group">
            <label  class="col-sm-5 control-label">Nombre</label>
            <div class="col-sm-7">
                <input type="text" name="nombre"  class="form-control" value="<?php echo $nombre; ?>" required="">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-5 control-label">Apellido Paterno</label>
            <div class="col-sm-7">
                <input type="text" name="ap_paterno"  class="form-control" value="<?php echo $ap_paterno; ?>" required="">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-5 control-label">Apellido Materno</label>
            <div class="col-sm-7">
                <input type="text" name="ap_materno"  class="form-control" value="<?php echo $ap_materno; ?>" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-5 control-label">E-Mail</label>
            <div class="col-sm-7">
                <input type="email" name="email"  class="form-control" value="<?php echo $email; ?>" required="">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-5 control-label">Nivil de usuario</label>
            <div class="col-sm-7">
                <select class="form-control" name="nivel">
                    <option value="administrador" <?php echo $e0; ?>>Administrador</option>
                    <option value="usuario" <?php echo $e1; ?>>Usuario</option>
                    <option value="lector" <?php echo $e2; ?>>Lector</option>
                    <option value="colaborador" <?php echo $e3; ?>>Colaborador</option>
                    <option value="coordinador administrativo" <?php echo $e4; ?>>Coordinador Administrativo</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label"><abbr title="Dato de control">Obra actual</abbr></label>
            <div class="col-sm-7">
                <select class="form-control" name="obra_actual">
                    <?php
                    $queryobra = $this->db->query('select idobras, nombre, localizacion FROM obras WHERE estatus = "activo" ');
                    foreach ($queryobra->result() as $row) {
                        $ob_selected = '';
                        if ($row->idobras == $obra_actual) {
                            $ob_selected = 'selected';
                        }
                        echo '<option value="' . $row->idobras . '" ' . $ob_selected . ' >"' . $row->nombre . '"';
                    }
                    ?>
                </select>
            </div>
        </div>


        <div class="form-group">
            <label  class="col-sm-5 control-label">Estatus de usuario:</label>
            <div class="col-sm-7">
                <select class="form-control" name="estatus" >
                    <?php
                    $s0 = '';
                    $s1 = '';
                    $s2 = '';
                    $s3 = '';
                    if ($estatus == '0') {
                        $s0 = 'selected';
                    } else {
                        $s1 = 'selected';
                    }
                    ?>
                    <option value="0" <?php echo $s0; ?>>Inactivo</option>
                    <option value="1" <?php echo $s1; ?>>Activo</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-danger">Guardar Cambios</button>
            </div>
        </div>
    </form>

    <br>
    <h3>Cambiar contraseña <small></small></h3>
    <form class="form-horizontal" name="registrousuario" method="post" action="<?php echo base_url() ?>index.php/sesion/actpswd/<?php echo $id ?>" onSubmit="return validarPasswd()">

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
<br><br>
</div>