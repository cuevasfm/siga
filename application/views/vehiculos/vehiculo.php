<br>
<br>
<div class="col-lg-4">
    <?php
    $query = $this->db->query('select * from vehiculos join marcasvehiculos on vehiculos.marca = marcasvehiculos.id JOIN usuarios ON vehiculos.usuario_actual = usuarios.id where idvehiculo =' . $id);

    if ($query->num_rows() > 0) {
        echo '<dl>';
        foreach ($query->result() as $row) {
            echo '<dt>ID vehicular</dt>';
            echo '<dd>' . $row->idvehiculo . '</dd>';
            echo '<dt>Placas</dt>';
            echo '<dd>' . $row->placas . '</dd>';
            echo '<dt>Marca</dt>';
            echo '<dd>' . $row->marca . '</dd>';
            echo '<dt>Modelo o submarca</dt>';
            echo '<dd>' . $row->modelo . '</dd>';
            echo '<dt>No. de serie</dt>';
            echo '<dd>' . $row->serie . '</dd>';
            echo '<dt>Año</dt>';
            echo '<dd>' . $row->anio . '</dd>';
            echo '<dt>Agente de seguro</dt>';
            echo '<dd>' . $row->agente_seguro . '</dd>';
            echo '<dt>Empresa aseguradora</dt>';
            echo '<dd>' . $row->emp_seguro . '</dd>';
            echo '<dt>ID Usuario actual</dt>';
            echo '<dd>' . $row->id . '</dd>';
            echo '<dt>Usuario</dt>';
            echo '<dd>' . $row->nombre . ' ' . $row->ap_paterno . '</dd>';
            echo '<dt>Vencimiento del seguro</dt>';
            echo '<dd>' . $row->vencimiento_seguro . '</dd>';
            echo '<dt>Vencimiento de tarjeta de circulación</dt>';
            echo '<dd>' . $row->tarjeta_circulacion . '</dd>';
        }
        echo '</dl>';
    }
    ?>
</div>
<div class="col-lg-8">
    <?php
    $queryfotos_vehiculos = $this->db->query('select * from fotos_vehiculos where idvehiculo = ' . $id);
    if ($queryfotos_vehiculos->num_rows() > 0) {


        echo '<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">';
        $x = 0;
        foreach ($queryfotos_vehiculos->result() as $value) {
            if ($x == 0) {
                echo '<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>';
                $x++;
            } else {
                echo '<li data-target="#carousel-example-generic" data-slide-to="' . $x . '"></li>';
                $x++;
            }
        }
        echo '</ol>';
        //wraps for carousel
        $active = ' active';

        echo '<div class="carousel-inner" role="listbox">';
        foreach ($queryfotos_vehiculos->result() as $row7) {


            echo '<div class="item' . $active . '">';
            echo '<img src="' . base_url() . 'subidas/vehiculos/' . $row7->nombre_url . '" alt="...">';
            echo '<div class="carousel-caption">' . $row7->nombre_url . '</div> </div>';
            $active = '';
        }
        echo '<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>';
        echo '</div>';
    } else {
        echo '<h4> No existen registros de fotografias para este vehiculo</h4>';
    }
    ?>




    <!-- Controls -->

</div>



