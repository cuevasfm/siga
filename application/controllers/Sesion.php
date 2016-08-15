<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sesion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database();
    }

    public function index() {
        if (isset($_SESSION['usuario'])) {
            if ($_SESSION['nivel'] == 'administrador') {
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('sesion/listausuarios');
                $this->load->view('html/footer');
            } elseif ($_SESSION['nivel'] == 'usuario') {
                echo 'mostrar panel de usuario';
            } else {
                echo 'mostrar panel de lector';
            }
        } else {
            header('Location: ' . base_url());
        }
        //verificar si existe session abierta
    }

    public function sign() {

        if (isset($_SESSION['usuario'])) {
            echo 'Hola bienvenido ya estas ingresado en el sistema: ' . $_SESSION['usuario'] . ' y eres: ' . $_SESSION['nivel'];
            header('Location:' . base_url() . 'index.php');
        } else {
            $this->load->view('html/headerinicio');
            $this->load->view('sesion/sign');
            $this->load->view('html/footer');
        }
    }

    public function cerrar() {

        $this->session->sess_destroy();
        echo base_url();
        header('Location:' . base_url() . 'index.php');
    }

    public function signin() {
//        if ($this->dbutil->database_exists('u407392648_siga')) {
//            echo 'si existe';
//        }

        $usuario = $this->input->post('usuario');
        $password = sha1(sha1($this->input->post('password')));
        $query = $this->db->query('SELECT * FROM usuarios WHERE usuario = "' . $usuario . '" AND password = "' . $password . '"');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $_SESSION['id'] = $row->id;
                $_SESSION['usuario'] = $row->usuario;
                $_SESSION['nombre'] = $row->nombre;
                $_SESSION['ap_paterno'] = $row->ap_paterno;
                $_SESSION['ap_materno'] = $row->ap_materno;
                $_SESSION['email'] = $row->email;
                $_SESSION['nivel'] = $row->nivel;
                $_SESSION['img_perfil'] = $row->img_perfil;
            }
            echo $_SESSION['id'];
            header('Location: ' . base_url() . 'index.php');
        } else {
            $this->load->view('html/headerinicio');
            $this->load->view('sesion/sign_error');
            $this->load->view('html/footer');
        }
    }

    public function nuevo() {
        if (isset($_SESSION['usuario'])) {
            if ($_SESSION['nivel'] == 'administrador') {
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('sesion/formlogin');
                $this->load->view('html/footer');
            } elseif ($_SESSION['nivel'] == 'usuario') {
                echo 'mostrar panel de usuario';
            } else {
                echo 'mostrar panel de lector';
            }
        } else {
            header('Location: ' . base_url());
        }
    }

    public function guardarusuario() {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $this->load->database();
                $usuario = strtolower($this->input->post('usuario'));
                $password = sha1(sha1($this->input->post('password')));
                $nombre = ($this->input->post('nombre'));
                $ap_paterno = ($this->input->post('ap_paterno'));
                $ap_materno = ($this->input->post('ap_materno'));
                $email = strtolower($this->input->post('email'));
                $nivel = $this->input->post('nivel');
                $obra_actual = $this->input->post('obra_actual');

                $dusuario = array(
                    'usuario' => $usuario,
                    'password' => $password,
                    'nombre' => $nombre,
                    'ap_paterno' => $ap_paterno,
                    'ap_materno' => $ap_materno,
                    'email' => $email,
                    'nivel' => $nivel,
                    'obra_actual' => $obra_actual
                );
                $this->db->insert('usuarios', $dusuario);
                header('Location: ' . base_url() . 'sesion');

                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

    public function editar($valor) {
        echo 'se editara el usuario con el id: ' . $valor;
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $this->load->database();
                $queryusuario = $this->db->query('SELECT * FROM usuarios WHERE id = "' . $valor . '" ');
                foreach ($queryusuario->result() as $row) {
                    $datosusuario = array(
                        'id' => $row->id,
                        'usuario' => $row->usuario,
                        'nombre' => $row->nombre,
                        'ap_paterno' => $row->ap_paterno,
                        'ap_materno' => $row->ap_materno,
                        'email' => $row->email,
                        'nivel' => $row->nivel,
                        'obra_actual' => $row->obra_actual,
                        'estatus' => $row->estatus,
                    );
                }

                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('sesion/editarusuario', $datosusuario);
                $this->load->view('html/footer');


                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

    public function actualizarusuario($id, $usuario) {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $nombre = $this->input->post('nombre');
                $ap_paterno = $this->input->post('ap_paterno');
                $ap_materno = $this->input->post('ap_materno');
                $email = $this->input->post('email');
                $nivel = $this->input->post('nivel');
                $obra_actual = $this->input->post('obra_actual');
                $estatus = $this->input->post('estatus');
                $usuarioactualizar = array(
                    'nombre' => $nombre,
                    'ap_paterno' => $ap_paterno,
                    'ap_materno' => $ap_materno,
                    'email' => $email,
                    'nivel' => $nivel,
                    'obra_actual' => $obra_actual,
                    'estatus' => $estatus
                );
                $this->db->where('id', $id);
                $this->db->update('usuarios', $usuarioactualizar);
                header('Location: ' . base_url() . 'index.php/sesion/');
                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

    public function actpswd($id) {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $password = sha1(sha1($this->input->post('password')));
                $usuariopassnuevo = array(
                    'password' => $password,
                );
                $this->db->where('id', $id);
                $this->db->update('usuarios', $usuariopassnuevo);
                header('Location: ' . base_url() . 'index.php/sesion/');
                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

}
