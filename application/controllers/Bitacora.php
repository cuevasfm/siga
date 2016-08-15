<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bitacora extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database();
        $this->load->helper(array('download', 'file', 'url', 'html', 'form'));
    }

    public function index() {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('bitacora/catalogo_bitacora'); //catalogo de vehiculo de inca
                $this->load->view('html/footer');
                break;
            case 'coordinador administrativo':
                $this->load->view('html/header');
                $this->load->view('html/menucadmon');
                $this->load->view('bitacora/catalogo_bitacora_coordinador'); // Bitacora coordinador administrativo
                $this->load->view('html/footer');
                break;
            default :
                $this->load->view('html/header');
                $this->load->view('sesion/sign');
                $this->load->view('html/footer');
        }
    }

    public function vehiculo($idvehiculo) {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $datos = array(
                    'idvehiculo' => $idvehiculo
                );
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('bitacora/bitacoraporvehiculo', $datos); //bitacora de servicios por vehiculo
                $this->load->view('html/footer');
                break;
            case 'coordinador administrativo':
                $datos = array(
                    'idvehiculo' => $idvehiculo
                );
                $this->load->view('html/header');
                $this->load->view('html/menucadmon');
                $this->load->view('bitacora/bitacoraporvehiculo', $datos); //bitacora de servicios por vehiculo coordinadro administrativo
                $this->load->view('html/footer');
                break;
            default :
                $this->load->view('html/header');
                $this->load->view('sesion/sign');
                $this->load->view('html/footer');
        }
    }

    public function fecha() {
        $fechas = array(
            'fecha1' => $this->input->post('fecha1'),
            'fecha2' => $this->input->post('fecha2'),
            'idvehiculo' => $this->input->post('idvehiculo')
        );
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                switch ($fechas['idvehiculo']) {
                    case 0:
                        $this->load->view('html/header');
                        $this->load->view('html/menuadmin');
                        $this->load->view('bitacora/bitacorafechas', $fechas); //bitacora de servicios por vehiculo
                        $this->load->view('html/footer');
                        break;
                    default :
                        $this->load->view('html/header');
                        $this->load->view('html/menuadmin');
                        $this->load->view('bitacora/bitacorafechasvehiculo', $fechas); //bitacora de servicios por vehiculo
                        $this->load->view('html/footer');
                        break;
                }
                break;
            case 'coordinador administrativo':
                switch ($fechas['idvehiculo']) {
                    case 0:
                        $this->load->view('html/header');
                        $this->load->view('html/menucadmon');
                        $this->load->view('bitacora/bitacorafechas', $fechas); //bitacora de servicios por vehiculo
                        $this->load->view('html/footer');
                        break;
                    default :
                        $this->load->view('html/header');
                        $this->load->view('html/menucadmon');
                        $this->load->view('bitacora/bitacorafechasvehiculo', $fechas); //bitacora de servicios por vehiculo
                        $this->load->view('html/footer');
                        break;
                }
                break;
        }
    }

}
