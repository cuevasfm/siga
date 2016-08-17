<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Imprimir extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database();
    }

    public function index() {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                header('Location: ' . base_url() . '');
                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

    public function progdemtto() {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('impresion/progdemtto');
                $this->load->view('impresion/footer');
                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

    public function mttoxautorizar() {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('impresion/progdemtto_sin_autorizar');
                $this->load->view('html/footer');
                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

    public function bitacorafechas($fecha1, $fecha2) {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $fechas = array(
                    'fecha1' => $fecha1,
                    'fecha2' => $fecha2
                );
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('impresion/impbitacorafechas',$fechas);
                $this->load->view('html/footer');
                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

}
