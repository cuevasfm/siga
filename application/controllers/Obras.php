<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Obras extends CI_Controller {

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
                $this->load->view('obras/catalogo');
                $this->load->view('html/footer');
            } elseif ($_SESSION['nivel'] == 'usuario') {

                $this->load->view('html/header');
                $this->load->view('html/menu');
                $this->load->view('welcome_message');
                $this->load->view('html/footer');
            } else {

                $this->load->view('html/header');
                $this->load->view('welcome_message');
                $this->load->view('html/footer');
            }
        } else {
            $this->load->view('html/header');
            $this->load->view('sesion/sign');
            $this->load->view('html/footer');
        }
    }

    public function nueva() {
        if (isset($_SESSION['usuario'])) {
            if ($_SESSION['nivel'] == 'administrador') {

                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('obras/formnuevaobra');
                $this->load->view('html/footer');
            } elseif ($_SESSION['nivel'] == 'usuario') {

                $this->load->view('html/header');
                $this->load->view('html/menu');
                $this->load->view('welcome_message');
                $this->load->view('html/footer');
            } else {

                $this->load->view('html/header');
                $this->load->view('welcome_message');
                $this->load->view('html/footer');
            }
        } else {
            $this->load->view('html/header');
            $this->load->view('sesion/sign');
            $this->load->view('html/footer');
        }
    }

    public function guardarobra() {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $data = array(
                    'nombre' => $this->input->post('nombre'),
                    'localizacion' => $this->input->post('localizacion'),
                    'fecha_inicio' => $this->input->post('fecha_inicio'),
                    'fecha_termino' => $this->input->post('fecha_termino'),
                    'estatus' => $this->input->post('estatus'),
                    'gerencia' => $this->input->post('gerencia')
                );
                $this->db->insert('obras', $data);
                echo 'Registro almacenado';
                sleep(5);
                header('Location: ' . base_url() . 'index.php/obras');
                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

}
