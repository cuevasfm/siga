<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database();
    }

    public function index($key) {
        if ($key == 'Dq2pRZiIpX0BCJlLLrXd') {
            echo '$key';
        }
        
//
//        $tipodeusuario = $_SESSION['nivel'];
//        switch ($tipodeusuario) {
//            case 'administrador':
//                $this->load->view('html/header');
//                $this->load->view('html/menuadmin');
//                $this->load->view('welcome_message');
//                $this->load->view('html/footer');
//                break;
//            case 'coordinador administrativo':
//                $this->load->view('html/header');
//                $this->load->view('html/menucadmon');
//                $this->load->view('welcome_message');
//                $this->load->view('html/footer');
//                break;
//            default :
//                header('Location: ' . base_url() . 'index.php/sesion/sign');
//        }
    }
    public function demon1($key) {
        if ($key == 'Dq2pRZiIpX0BCJlLLrXd') {
            echo $key;
            $datoscorreo = array(
                    'username' => 'miguel',
                    'datos' => 'Datos del correo que se envia automaticamente Dq2pRZiIpX0BCJlLLrXd'
                );
                $config = array(
                    'mailtype' => 'html'
                );
                $this->load->library('email', $config);
                $this->email->from('yo@miguelcuevas.xyz', 'Sistema vehicular INCA');
                $this->email->to('yo@miguelcuevas.xyz');
                $this->email->cc('');
                $this->email->bcc('');

                $this->email->subject('correo de prueba');
                $body = $this->load->view('email/test', $datoscorreo, TRUE);
                $this->email->message($body);

                $this->email->send();
        }
        if ($key == 'Dq2pRZiIpX0BCJlLLrXd2') {
            echo $key;
            $datoscorreo = array(
                    'username' => 'miguel',
                    'datos' => 'Datos del correo que se envia automaticamente Dq2pRZiIpX0BCJlLLrXd2'
                );
                $config = array(
                    'mailtype' => 'html'
                );
                $this->load->library('email', $config);
                $this->email->from('yo@miguelcuevas.xyz', 'Sistema vehicular INCA');
                $this->email->to('yo@miguelcuevas.xyz');
                $this->email->cc('');
                $this->email->bcc('');

                $this->email->subject('correo de prueba dos');
                $body = $this->load->view('email/test', $datoscorreo, TRUE);
                $this->email->message($body);

                $this->email->send();
        }
        
//
//        $tipodeusuario = $_SESSION['nivel'];
//        switch ($tipodeusuario) {
//            case 'administrador':
//                $this->load->view('html/header');
//                $this->load->view('html/menuadmin');
//                $this->load->view('welcome_message');
//                $this->load->view('html/footer');
//                break;
//            case 'coordinador administrativo':
//                $this->load->view('html/header');
//                $this->load->view('html/menucadmon');
//                $this->load->view('welcome_message');
//                $this->load->view('html/footer');
//                break;
//            default :
//                header('Location: ' . base_url() . 'index.php/sesion/sign');
//        }
    }

}
