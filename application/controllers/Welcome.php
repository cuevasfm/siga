<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
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
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('welcome_message');
                $this->load->view('html/footer');
                break;
            case 'coordinador administrativo':
                $this->load->view('html/header');
                $this->load->view('html/menucadmon');
                $this->load->view('welcome_message');
                $this->load->view('html/footer');
                break;
            default :
                header('Location: ' . base_url() . 'index.php/sesion/sign');
        }
    }

}
