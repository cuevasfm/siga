
<?php
$query = $this->db->query('SELECT id, usuario, usuarios.nombre, ap_paterno, ap_materno, email, nivel, obra_actual, obras.nombre as nombre_obra, localizacion, gerencia FROM usuarios join obras on usuarios.obra_actual = obras.idobras where usuarios.estatus = 1');
$queryinactivos = $this->db->query('SELECT id, usuario, usuarios.nombre, ap_paterno, ap_materno, email, nivel, obra_actual, obras.nombre as nombre_obra, localizacion, gerencia FROM usuarios join obras on usuarios.obra_actual = obras.idobras where usuarios.estatus != 1');
?>
<h3>Usuarios del sistema activos: <?php echo $query->num_rows(); ?></h3>
<?php if ($query->num_rows() > 0) {
    ?>
    <table class="table" style="font-size: 12px">
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Nombre completo</th>
            <th>Email</th>
            <th>Nivel</th>
            <th>Obra</th>
            <th>Localización</th>
            <th>Gerencia</th>
            <th></th>

        </tr>

        <?php
        foreach ($query->result() as $row) {
            echo '<tr>';
            echo '<td>' . $row->id . '</td>';
            echo '<td>' . $row->usuario . '</td>';
            echo '<td>' . $row->nombre . ' ' . $row->ap_paterno . ' ' . $row->ap_materno . '</td>';
            echo '<td>' . $row->email . '</td>';
            echo '<td>' . $row->nivel . '</td>';
            echo '<td>' . $row->nombre_obra . '</td>';
            echo '<td>' . $row->localizacion . '</td>';
            echo '<td>' . $row->gerencia . '</td>';
            echo '<td><a href="' . base_url() . 'index.php/sesion/editar/' . $row->id . '"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>';
            echo '</tr>';
        }
        ?>
    </table>
    <?php
}
if ($queryinactivos->num_rows() > 0) {
    ?>

    <h3>Usuarios del sistema inactivos: <?php echo $queryinactivos->num_rows(); ?></h3>
    <table class="table" style="font-size: 12px">
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Nombre completo</th>
            <th>Email</th>
            <th>Nivel</th>
            <th>Obra</th>
            <th>Localización</th>
            <th>Gerencia</th>
            <th></th>
        </tr>

        <?php
        foreach ($queryinactivos->result() as $row2) {
            echo '<tr>';
            echo '<td>' . $row2->id . '</td>';
            echo '<td>' . $row2->usuario . '</td>';
            echo '<td>' . $row2->nombre . ' ' . $row->ap_paterno . ' ' . $row->ap_materno . '</td>';
            echo '<td>' . $row2->email . '</td>';
            echo '<td>' . $row2->nivel . '</td>';
            echo '<td>' . $row2->nombre_obra . '</td>';
            echo '<td>' . $row2->localizacion . '</td>';
            echo '<td>' . $row2->gerencia . '</td>';
            echo '<td><a href="' . base_url() . 'editar/' . $row2->id . '"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>';
            echo '</tr>';
        }
        ?>
    </table>
    <?php
}  
?>