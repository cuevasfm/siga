
<?php

$query = $this->db->query('select * from obras where estatus = "activo" ');
$query_inactivas = $this->db->query('select * from obras where estatus != "activo" ');

echo '<h1>Obras Activas: ' . $query->num_rows() . ' </h1>';
if ($query->num_rows() > 0) {
    echo '<table class="table" style="font-size: 12px;">
    <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Localización</th>
        <th>Fecha Inicio</th>
        <th>Fecha Termino</th>
        <th>Gerencia</th>
        <th>Editar</th>
    </tr>';

    foreach ($query->result() as $row) {
        echo '<tr>';
        echo '<td>' . $row->idobras . '</td>';
        echo '<td>' . $row->nombre . '</td>';
        echo '<td>' . $row->localizacion . '</td>';
        echo '<td>' . $row->fecha_inicio . '</td>';
        echo '<td>' . $row->fecha_termino . '</td>';
        echo '<td>' . $row->gerencia . '</td>';
        echo '</tr>';
    }
} else {
    echo 'No existen obras activas ';
}

echo '</table>';

echo '<h1>Obras Inactivas: ' . $query_inactivas->num_rows() . ' </h1>';
if ($query_inactivas->num_rows() > 0) {
    echo '<table class="table">
    <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Localización</th>
        <th>Fecha Inicio</th>
        <th>Fecha Termino</th>
        <th>Cliente</th>
        <th>Gerencia</th>
        <th>Editar</th>
    </tr>';

    foreach ($query_inactivas->result() as $row2) {
        echo '<tr>';
        echo '<td>' . $row2->idobras . '</td>';
        echo '<td>' . $row2->nombre . '</td>';
        echo '<td>' . $row2->localizacion . '</td>';
        echo '<td>' . $row2->fecha_inicio . '</td>';
        echo '<td>' . $row2->fecha_termino . '</td>';
        echo '<td>' . $row2->estatus . '</td>';
        echo '<td>' . $row2->gerencia . '</td>';
        echo '</tr>';
    }
} else {
    echo 'No existen obras inactivas ';
}

echo '</table>';

?>
