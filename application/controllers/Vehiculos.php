<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vehiculos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database();
        $this->load->helper(array('download', 'file', 'url', 'html', 'form'));
        $this->folder = './subidas/';
    }

    public function index() {
        if (isset($_SESSION['usuario'])) {
            $this->load->view('html/header');
            $this->load->view('html/menuadmin');
            $this->load->view('vehiculos/catalogovehicular'); //catalogo de vehiculo de inca
            $this->load->view('html/footer');
        } else {
            $this->load->view('html/header');
            $this->load->view('sesion/sign');
            $this->load->view('html/footer');
        }
    }

    public function nuevo() { //agregar nuevo automovil
        if (isset($_SESSION['usuario'])) {
            if ($_SESSION['nivel'] == 'administrador') {
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('vehiculos/nuevoform'); //catalogo de vehiculo de inca
                $this->load->view('html/footer');
            }
        } else {
            $this->load->view('html/header');
            $this->load->view('sesion/sign');
            $this->load->view('html/footer');
        }
    }

    public function guardarvehiculo() {
        if (isset($_SESSION['usuario'])) {
            if ($_SESSION['nivel'] == 'administrador') {
                $data = array(
                    'placas' => strtoupper($this->input->post('placas')),
                    'marca' => ($this->input->post('marca')),
                    'modelo' => strtoupper($this->input->post('modelo')),
                    'serie' => strtoupper($this->input->post('serie')),
                    'anio' => ($this->input->post('anio')),
                    'agente_seguro' => strtoupper($this->input->post('agente_seguro')),
                    'emp_seguro' => strtoupper($this->input->post('emp_seguro')),
                    'vencimiento_seguro' => ($this->input->post('vencimiento_seguro')),
                    'tarjeta_circulacion' => ($this->input->post('tarjeta_circulacion')),
                    'usuario_actual' => ($this->input->post('usuario_actual')),
                    'proxima_verificacion' => ($this->input->post('proxima_verificacion'))
                );
                $this->db->insert('vehiculos', $data);
                echo 'Registro almacenado';
                header('Location: ' . base_url() . 'index.php/vehiculos/ ');
            }
        }
    }

    public function editar($id) {
        $datos = array(
            'id' => $id
        );

        if (isset($_SESSION['usuario'])) {
            if ($_SESSION['nivel'] == 'administrador') {
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('vehiculos/editar', $datos); //formulario de edicion de vehiculos y agregado de imagenes para el vehiculo
                $this->load->view('html/footer');
            }
        } else {
            $this->load->view('html/header');
            $this->load->view('sesion/sign');
            $this->load->view('html/footer');
        }
    }

    public function vehiculo($id) {
        $datos = array(
            'id' => $id
        );

        if (isset($_SESSION['usuario'])) {
            if ($_SESSION['nivel'] == 'administrador') {
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('vehiculos/vehiculo', $datos); //formulario de edicion de vehiculos y agregado de imagenes para el vehiculo
                $this->load->view('html/footer');
            }
        } else {
            $this->load->view('html/header');
            $this->load->view('sesion/sign');
            $this->load->view('html/footer');
        }
    }

    public function actualizarvehiculo($id) {
        if (isset($_SESSION['usuario'])) {
            if ($_SESSION['nivel'] == 'administrador') {

                $data = array(
                    'placas' => strtoupper($this->input->post('placas')),
                    'marca' => ($this->input->post('marca')),
                    'modelo' => strtoupper($this->input->post('modelo')),
                    'serie' => strtoupper($this->input->post('serie')),
                    'anio' => ($this->input->post('anio')),
                    'agente_seguro' => strtoupper($this->input->post('agente_seguro')),
                    'emp_seguro' => strtoupper($this->input->post('emp_seguro')),
                    'vencimiento_seguro' => ($this->input->post('vencimiento_seguro')),
                    'tarjeta_circulacion' => ($this->input->post('tarjeta_circulacion')),
                    'usuario_actual' => ($this->input->post('usuario_actual')),
                    'proxima_verificacion' => ($this->input->post('proxima_verificacion'))
                );
                $this->db->where('idvehiculo', $id);
                $this->db->update('vehiculos', $data);
                echo 'Registro almacenado';
                header('Location: ' . base_url() . 'index.php/vehiculos/editar/' . trim($id) . '/actualizado');
            }
        }
    }

    public function imgauto($idvehiculo) {
        $config['upload_path'] = './subidas/vehiculos';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '10485760'; //10mb
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $this->load->view('html/header');
            $this->load->view('html/menuadmin');
            $this->load->view('vehiculos/editar', $error = array('error' => $this->upload->display_errors()));
            $this->load->view('html/footer');
        } else {
            $id = $_SESSION['id'];
            $data = $this->upload->data();
            echo $data['file_name'];
            $data2 = array(
                'idvehiculo' => $idvehiculo,
                'nombre_url' => $data['file_name'],
                'fecha' => date('Y-m-d'),
                'idusuario' => $id
            );
            $this->db->insert('fotos_vehiculos', $data2);
            header('Location: ' . base_url() . 'index.php/vehiculos/editar/' . trim($idvehiculo));
// $this->load->view('upload_success', $data);
        }
    }

    public function eliminarfotovehiculo($archivo, $idfoto, $idvehiculo) {
        $do = unlink("subidas/vehiculos/" . $archivo);
        if ($do != true) {
            echo "hubo un error al intentar eliminar el archivo" . $archivo . "<br />";
        }
        $this->db->where('idfotos_vehiculos', $idfoto);
        $this->db->delete('fotos_vehiculos');
        echo $archivo;
        echo $idfoto;
        header('Location: ' . base_url() . 'index.php/vehiculos/editar/' . trim($idvehiculo));
    }

    public function solicitudservicio() {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('vehiculos/formsolicitudservicio');
                $this->load->view('html/footer');
                break;
            case 'coordinador administrativo':
                $this->load->view('html/header');
                $this->load->view('html/menucadmon');
                $this->load->view('vehiculos/formsolicitudservicio_admon');
                $this->load->view('html/footer');
                break;
            default :
                echo 'acceso restringido';
        }
    }

    public function programaciondemantenimiento() {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
// Servicios por autorizar
// Servicios reprogramados o atrasados
// Servicios por finalizar
                $this->load->view('vehiculos/programaciondemantenimiento');
                $this->load->view('html/footer');
                echo 'eres administrador';
                break;
            default :
                echo 'acceso restringido';
        }
    }

    public function polizas() {
        $this->load->view('html/header');
        $this->load->view('html/menuadmin');
        $this->load->view('vehiculos/formsolicitudservicio');
        $this->load->view('html/footer');
    }

    public function getuser($dato) {

        $query = $this->db->query('select * from vehiculos WHERE placas="' . $dato . '"');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                echo 'ID del vehiculo: ' . $row->idvehiculo . '<br>';
                echo 'Modelo: ' . $row->modelo . '<br>';
                echo 'Serie: ' . $row->serie . '<br>';
                echo 'ID de usuario del vehiculo: ' . $row->usuario_actual . '<br>';
            }
        }
    }

    public function alertas($tipo) {

        $this->load->view('html/header');
        $this->load->view('html/menuadmin');
        $this->load->view('vehiculos/alertas');
        echo 'Listar tipos de alertas a desplegar para el envio de notificaciones por correo electronico.';
        if ($tipo == 1) {
            echo $tipostr = 'Servicio Necesario';
        }if ($tipo == 2) {
            echo $tipostr = 'Actualizar datos';
        }if ($tipo == 3) {
            echo $tipostr = 'Poliza de seguro a menos de 30 días de vencer';
        }if ($tipo == 4) {
            echo $tipostr = 'Poliza de serguro vencida';
        }if ($tipo == 5) {
            echo $tipostr = 'Tarjeta de circulación a 30 días de vencer';
        }if ($tipo == 6) {
            echo $tipostr = 'Tarjeta de circulación vencida';
        }if ($tipo == 7) {
            echo $tipostr = 'pdf y xml faltantes en servicios';
        }
        $this->load->view('html/footer');
    }

    public function autorizarservicio() {
        setlocale(LC_ALL, "es_MX.UTF-8");
        date_default_timezone_set("America/Mexico_City");
        $hoy = date("Y-m-d H:i:s");
        foreach ($_POST['check'] as $item) {
            echo $item;

            $data = array(
                'estatus_autorizacion' => 1,
                'fecha_autorizado' => $hoy
            );
            $this->db->where('idservicio_vehicular', $item);
            $this->db->update('servicio_vehicular', $data);
            echo 'Registro almacenado';
        }
        header('Location: ' . base_url() . 'index.php/vehiculos/programaciondemantenimiento');
    }

    public function finalizarservicio() {
        setlocale(LC_ALL, "es_MX.UTF-8");
        date_default_timezone_set("America/Mexico_City");
        $hoy = date("Y-m-d H:i:s");
        foreach ($_POST['check'] as $item) {
            echo $item;

            $data = array(
                'check' => 1,
                'fecha_finalizado' => $hoy
            );
            $this->db->where('idservicio_vehicular', $item);
            $this->db->update('servicio_vehicular', $data);
            echo 'Registro almacenado';
        }
        header('Location: ' . base_url() . 'index.php/vehiculos/programaciondemantenimiento');
    }

    public function almacenarservicionuevo() {


        if (isset($_SESSION['usuario'])) {
            if ($_SESSION['nivel'] == 'administrador' || $_SESSION['nivel'] == 'coordinador administrativo') {
// -------------------inicio upload cotizacion----------------------------------
                $config['upload_path'] = './subidas/cotizaciones';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = 0;

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('cotizacion')) {
                    $error = array('error' => $this->upload->display_errors());

                    $this->load->view('upload_form', $error);
                } else {
                    $data = ($this->upload->data());
                    echo $data['file_name'];
                }
// ----------------------fin upload cotizacion----------------------------------
                setlocale(LC_ALL, "es_MX.UTF-8");
                date_default_timezone_set("America/Mexico_City");
                $hoy = date("Y-m-d H:i:s");
                $hora = date("H:i:s");
                if (date('l') == 'Friday' or date('l') == 'Saturday' or date('l') == 'Sunday' or date('l') == 'Monday') {
                    $fecha = date("Y-m-d", strtotime('next friday'));
                } elseif (date('l') == 'Tuesday') {
                    if ($hora < '17:00:00') {
                        $fecha = date("Y-m-d", strtotime('next friday'));
                    } else {
                        $fecha = date("Y-m-d", strtotime('next friday + 7days'));
                    }
                } else {
                    $fecha = date("Y-m-d", strtotime('next friday + 7days'));
                }
                $nuevoservicio = array(
                    'idsolicitante' => $_SESSION['id'],
                    'idvehiculo' => $this->input->post('idvehiculo'),
                    'kilometraje_actual' => $this->input->post('kilometraje_actual'),
                    'costo_neto' => $this->input->post('costo_neto'),
                    'observaciones' => $this->input->post('observaciones'),
                    'cotizacion' => $data['file_name'],
                    'fecha_solicitud' => $hoy,
                    'fecha_servicio' => $fecha,
                    'mediode_pago' => $this->input->post('mediode_pago'),
                    'rfc_proveedor' => $this->input->post('rfc_proveedor'),
                    'nombre_proveedor' => $this->input->post('nombre_proveedor'),
                    'banco_proveedor' => $this->input->post('banco_proveedor'),
                    'clabe_proveedor' => $this->input->post('clabe_proveedor')
                );
                $this->db->insert('servicio_vehicular', $nuevoservicio);

//$querysolicitud = $this->db->query('select * from servicio_vehicular WHERE idsolicitante = "' . $_SESSION['id'] . '" AND fecha_solicitud = "' . $hoy . '"');
                $querysolicitud = $this->db->query('select idservicio_vehicular, costo_neto, observaciones,mediode_pago, fecha_servicio, usuarios.nombre, ap_paterno, vehiculos.idvehiculo, modelo, placas,obras.nombre as obra, localizacion from servicio_vehicular join vehiculos on servicio_vehicular.idvehiculo = vehiculos.idvehiculo join usuarios on vehiculos.usuario_actual = usuarios.id join obras on usuarios.obra_actual = obras.idobras WHERE idsolicitante = "' . $_SESSION['id'] . '" AND fecha_solicitud = "' . $hoy . '"');
                if ($querysolicitud->num_rows() > 0) {
                    foreach ($querysolicitud->result() as $row) {
                        $idservicio_vehicular = $row->idservicio_vehicular;
                        $costo_neto = $row->costo_neto;
                        $observaciones = $row->observaciones;
                        $mediode_pago = $row->mediode_pago;
                        $fecha_servicio = $row->fecha_servicio;
                        $nombre = $row->nombre;
                        $ap_paterno = $row->ap_paterno;
                        $idvehiculo = $row->idvehiculo;
                        $modelo = $row->modelo;
                        $placas = $row->placas;
                        $obra = $row->obra;
                        $localizacion = $row->localizacion;
                    }
                }

// ----------------------enviar correo de notificacion--------------------------
                $datoscorreo = array(
                    'username' => $_SESSION['nombre'],
                    'id' => $idservicio_vehicular,
                    'costo_neto' => money_format('%= (#6.2n', $costo_neto),
                    'observaciones' => $observaciones,
                    'mediode_pago' => $mediode_pago,
                    'fecha_servicio' => $fecha_servicio,
                    'nombre' => $nombre,
                    'ap_paterno' => $ap_paterno,
                    'placas' => $placas,
                    'modelo' => $modelo,
                    'obra' => $obra,
                    'localizacion' => $localizacion
                );
                $config = array(
                    'mailtype' => 'html'
                );
                $this->load->library('email', $config);
                $this->email->from('yo@miguelcuevas.xyz', 'Sistema vehicular INCA');
                $this->email->to($_SESSION['email']);
                $this->email->cc('jorgemtz@incasupervision.com, cuevasfm@hotmail.com');
                $this->email->bcc('');

                $this->email->subject('Solicitud con #id ' . $idservicio_vehicular . ' fue registrada, por el usuario: ' . $_SESSION['usuario']);
                $body = $this->load->view('email/nuevasolicitudservicio', $datoscorreo, TRUE);
                $this->email->message($body);

                $this->email->send();
// ------------------fin de enviar correo de notificacion-----------------------

                if ($_SESSION['nivel'] == 'administrador') {
                    header('Location: ' . base_url() . 'index.php/vehiculos/programaciondemantenimiento/');
                } else {
                    header('Location: ' . base_url() . 'index.php/vehiculos/historialsolicitudservicio/');
                }
            }
        }
    }

/////// ASIGNACION VEHICULAR ////////
    public function asignacion() {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('vehiculos/asignacion/asignacion');
                $this->load->view('html/footer');
                break;
            default :
                echo 'acceso restringido';
                header('Location: ' . base_url() . '');
        }
    }

    public function getvehiculo($dato) {

//        $query = $this->db->query('select * from vehiculos WHERE idvehiculo="' . $dato . '"');
        $query = $this->db->query('SELECT idvehiculo, placas, modelo, serie, usuario_actual, nombre, ap_paterno FROM vehiculos join usuarios on vehiculos.usuario_actual = usuarios.id where idvehiculo ="' . $dato . '" ');
//        $query = $this->db->query('SELECT vehiculos.idvehiculo, placas, modelo, serie, usuario_actual, usuarios.nombre, ap_paterno, obra, obras.nombre as nombreobra FROM vehiculos join usuarios on vehiculos.usuario_actual = usuarios.id join historial_asignacion_vehiculos on vehiculos.idvehiculo = historial_asignacion_vehiculos.idvehiculo join obras on historial_asignacion_vehiculos.obra = obras.idobras where vehiculos.idvehiculo = "' . $dato . '"  order by idvehiculo desc limit 0,1');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                echo '<h3>Vehículo</h3>';
                echo '<dl class="dl-horizontal">';
                echo '<dt>ID del vehiculo:</dt><dd>  ' . $row->idvehiculo . '</dd>';
                echo '<dt>Placa:</dt><dd>  ' . $row->placas . '</dd>';
                echo '<dt>Modelo:</dt><dd>  ' . $row->modelo . '</dd>';
                echo '<dt>Serie:</dt><dd>  ' . $row->serie . '</dd>';
                echo '<dt>ID de usuario actual:</dt><dd> ' . $row->usuario_actual . ' ' . $row->nombre . ' ' . $row->ap_paterno . ' </dd>';
//              echo '<dt>Obra asignada:</dt><dd> ' . $row->nombreobra . ' </dd>';
                echo '</dl>';
            }
        }
    }

    public function getusuario($dato) {

        $query = $this->db->query('select * from usuarios WHERE id="' . $dato . '"');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                echo '<h3>Tripulante</h3>';
                echo '<dl class="dl-horizontal">';
                echo '<dt>ID:</dt><dd> ' . $row->id . '</dd>';
                echo '<dt>Usuario:</dt><dd> ' . $row->usuario . '</dd>';
                echo '<dt>Nombre:</dt><dd> ' . $row->nombre . ' ' . $row->ap_paterno . '</dd>';
                echo '<dt>E-mail:</dt><dd> ' . $row->email . '</dd>';
                echo '</dl>';
            }
        }
    }

    public function getobra($dato) {

        $query = $this->db->query('select * from obras WHERE idobras="' . $dato . '"');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                echo '<h3>Obra</h3>';
                echo '<dl class="dl-horizontal">';
                echo '<dt>ID Obra:</dt><dd> ' . $row->idobras . '</dd>';
                echo '<dt>Nombre:</dt><dd> ' . $row->nombre . '</dd>';
                echo '<dt>Localización:</dt><dd> ' . $row->localizacion . '</dd>';
                echo '<dt>Estatus:</dt><dd> ' . $row->estatus . '</dd>';
                echo '</dl>';
            }
        }
    }

    public function asignarvehiculo() {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                setlocale(LC_ALL, "es_MX.UTF-8");
                date_default_timezone_set("America/Mexico_City");
                $hoy = date("Y-m-d");
                $datosdeasignacion = array(
                    'idvehiculo' => $this->input->post('idvehiculo'),
                    'idusuario' => $this->input->post('idusuario'),
                    'fecha' => $hoy,
                    'obra' => $this->input->post('idobra'),
                    'kilometraje' => $this->input->post('kilometraje'),
                    'observaciones' => $this->input->post('observaciones')
                );
                $this->db->insert('historial_asignacion_vehiculos', $datosdeasignacion);

                $datosvehiculo = array(
                    'usuario_actual' => $this->input->post('idusuario'),
                    'proyecto_obra' => $this->input->post('idobra')
                );

                $this->db->where('idvehiculo', $this->input->post('idvehiculo'));
                $this->db->update('vehiculos', $datosvehiculo);

                $historial_data = array(
                    'idvehiculo' => $this->input->post('idvehiculo'),
                    'idusuario' => $this->input->post('idusuario'),
                    'idobra' => $this->input->post('idobra')
                );

                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('vehiculos/asignacion/consulta_guardado', $historial_data);
                $this->load->view('html/footer');

                header('Location: ' . base_url() . 'index.php/vehiculos/asignacion/');
                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

    public function editarservicio($idservicio) {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $query = $this->db->query('select * from servicio_vehicular join vehiculos on servicio_vehicular.idvehiculo = vehiculos.idvehiculo  WHERE idservicio_vehicular="' . $idservicio . '"');
                if ($query->num_rows() > 0) {
                    foreach ($query->result() as $row) {
                        $servicio_vehicular_datos = array(
                            'idservicio_vehicular' => $row->idservicio_vehicular,
                            'idvehiculo' => $row->idvehiculo,
                            'idsolicitante' => $row->idsolicitante,
                            'costo_neto' => $row->costo_neto,
                            'estatus_autorizacion' => $row->estatus_autorizacion,
                            'idquien_autorizo' => $row->idquien_autorizo,
                            'mediode_pago' => $row->mediode_pago,
                            'fecha_servicio' => $row->fecha_servicio,
                            'observaciones' => $row->observaciones,
                            'kilometraje_actual' => $row->kilometraje_actual,
                            'modelo' => $row->modelo,
                            'check' => $row->check,
                            'rfc_proveedor' => $row->rfc_proveedor,
                            'nombre_proveedor' => $row->nombre_proveedor,
                            'banco_proveedor' => $row->banco_proveedor,
                            'clabe_proveedor' => $row->clabe_proveedor,
                        );

                        $this->load->view('html/header');
                        $this->load->view('html/menuadmin');
                        $this->load->view('vehiculos/editarservicio', $servicio_vehicular_datos);
                        $this->load->view('html/footer');
                    }
                }
                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

    public function actualizarservicio($idservicio) {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $datosactualizarservicio = array(
                    'costo_neto' => $this->input->post('costo_neto'),
                    'estatus_autorizacion' => $this->input->post('estatus_autorizacion'),
                    'check' => $this->input->post('check'),
                    'fecha_servicio' => $this->input->post('fecha_servicio'),
                    'kilometraje_actual' => $this->input->post('kilometraje_actual'),
                    'mediode_pago' => $this->input->post('mediode_pago'),
                    'rfc_proveedor' => $this->input->post('rfc_proveedor'),
                    'nombre_proveedor' => $this->input->post('nombre_proveedor'),
                    'banco_proveedor' => $this->input->post('banco_proveedor'),
                    'clabe_proveedor' => $this->input->post('clabe_proveedor'),
                    'observaciones' => $this->input->post('observaciones')
                );
                $this->db->where('idservicio_vehicular', $idservicio);
                $this->db->update('servicio_vehicular', $datosactualizarservicio);

                header('Location: ' . base_url() . 'index.php/vehiculos/programaciondemantenimiento');
                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

    public function imp_autorizados() {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $this->load->view('impresion/header');
                $this->load->view('vehiculos/imp_vehiculosfinalizados');
                $this->load->view('impresion/footer');
                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

    public function asigcoordinador() {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('vehiculos/asignacion/asigcoordinador');
                $this->load->view('html/footer');
                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

    public function guardar_asignarcoordinador() {

        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $datosactualizarservicio = array(
                    'coordinador_administrativo' => $this->input->post('coordinador')
                );
                $this->db->where('idvehiculo', $this->input->post('vehiculo'));
                $this->db->update('vehiculos', $datosactualizarservicio);
                $datos_historial = array(
                    'coordinador' => $this->input->post('coordinador'),
                    'vehiculo' => $this->input->post('vehiculo')
                );
                $this->db->insert('historial_coordinador_admon', $datos_historial);

                echo '<br><br>hecho';
                header('Location: ' . base_url() . 'index.php/vehiculos/asigcoordinador/');
                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

    public function historialsolicitudservicio() {

        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('vehiculos/historial_solicitudes');
                $this->load->view('html/footer');
                break;
            case 'coordinador administrativo':
                $this->load->view('html/header');
                $this->load->view('html/menucadmon');
                $this->load->view('vehiculos/historial_solicitudes_coordinador');
                $this->load->view('html/footer');
                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

    public function solicituddepagos($id, $mediodepago) {

        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                if ($mediodepago == 2) {
                    $querysolicituddepagos = $this->db->query('SELECT obras.nombre as nombreobra, nombre_proveedor, rfc_proveedor, clabe_proveedor, fecha_solicitud, costo_neto, banco_proveedor, observaciones, usuarios.nombre, usuarios.ap_paterno, usuarios.ap_materno, vehiculos.usuario_actual, vehiculos.placas, vehiculos.modelo  FROM servicio_vehicular join usuarios on servicio_vehicular.idsolicitante = usuarios.id join vehiculos on servicio_vehicular.idvehiculo = vehiculos.idvehiculo join obras on obra_actual = obras.idobras where idservicio_vehicular = ' . $id);
                    if ($querysolicituddepagos->num_rows() > 0) {
                        foreach ($querysolicituddepagos->result() as $row) {
                            $datos = array(
                                'proyecto' => strtoupper($row->nombreobra),
                                'solicitudde' => 'TRANSFERENCIA',
                                'beneficiario' => strtoupper($row->nombre_proveedor),
                                'cantidad_letra' => $row->observaciones,
                                'rfc' => strtoupper($row->rfc_proveedor),
                                'clabe' => $row->clabe_proveedor,
                                'fecha' => $row->fecha_solicitud,
                                'costo' => $row->costo_neto,
                                'banco' => strtoupper($row->banco_proveedor),
                                'concepto' => strtoupper($row->observaciones . ', DEL VEHÍCULO: ' . $row->modelo . ', PLACAS: ' . $row->placas . '.'),
                                'nombre' => strtoupper($row->nombre . ' ' . $row->ap_paterno . ' ' . $row->ap_materno),
                            );
                            $this->load->view('html/header');
                            $this->load->view('html/menuadmin');
                            $this->load->view('vehiculos/solicituddepagos', $datos);
                            $this->load->view('html/footer');
                        }
                    }
                }
                break;
            case 'coordinador administrativo':
                $this->load->view('html/header');
                $this->load->view('html/menucadmon');
                $this->load->view('vehiculos/historial_solicitudes_coordinador');
                $this->load->view('html/footer');
                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

}
