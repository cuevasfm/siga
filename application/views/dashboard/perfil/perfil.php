<?php
$id = $_SESSION['id'];
$query = $this->db->query('SELECT img_perfil FROM usuarios WHERE id = "' . $id . '"');

if ($query->num_rows() > 0) {
    foreach ($query->result() as $row) {
        $img_perfil = $row->img_perfil;
        if ($row->img_perfil == null) {
            $img_perfil = "ninguna.jpg";
        }
    }
}
$queryusuario = $this->db->query('SELECT usuario, nombre, ap_paterno, ap_materno, email, nivel FROM usuarios WHERE id = "' . $id . '"');
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
<div class="col-lg-12 col-md12"><h1>Perfil de usuario</h1></div>
<div class="col-lg-3 col-md-6">
    <img src="<?php echo base_url() ?>subidas/<?php echo $img_perfil; ?>" class="img-responsive img-rounded"> <br>
    <a class="btn btn-danger" href="<?php echo base_url() ?>index.php/dashboard/editarimgperfil">Cambiar imagen</a>
</div>
<div class="col-lg-4">
    <dl>
        <dt>ID</dt>
        <dd><?php echo $_SESSION['id']; ?></dd>
        <dt>Usuario</dt>
        <dd><?php echo $usuario; ?></dd>
        <dt>Nombre</dt>
        <dd><?php echo $nombre; ?></dd>
        <dt>Apellido Paterno</dt>
        <dd><?php echo $ap_paterno; ?></dd>
        <dt>Apellido Materno</dt>
        <dd><?php echo $ap_materno; ?></dd>
        <dt>E-Mail</dt>
        <dd><?php echo $email; ?></dd>
        <dt>Tipo de usuario (nivel)</dt>
        <dd><?php echo $nivel; ?></dd>
    </dl>
    <a class="btn btn-default" href="<?php echo base_url() ?>index.php/dashboard/editarperfil">Editar información</a>
</div>