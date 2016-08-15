<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
            if ($_SESSION['nivel'] == 'administrador') {
                echo 'mostrar panel de administrador';
            } elseif ($_SESSION['nivel'] == 'usuario') {
                echo 'mostrar panel de usuario';
            } else {
                echo 'mostrar panel de lector';
            }
        } else {
            $this->load->view('sesion/sign');
        }
    }

    public function perfil() {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('dashboard/perfil/perfil');
                $this->load->view('html/footer');
                break;
            case 'coordinador administrativo':
                $this->load->view('html/header');
                $this->load->view('html/menucadmon');
                $this->load->view('dashboard/perfil/perfil');
                $this->load->view('html/footer');
                break;
            default :
                header('Location: ' . base_url());
                break;
        }
    }

    public function editarperfil() {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $this->load->view('html/header');
                $this->load->view('html/menuadmin');
                $this->load->view('dashboard/perfil/editarperfil');
                $this->load->view('html/footer');
                break;
            case 'coordinador administrativo':
                $this->load->view('html/header');
                $this->load->view('html/menucadmon');
                $this->load->view('dashboard/perfil/editarperfil');
                $this->load->view('html/footer');
                break;
        }
    }

    public function actualizarperfil() {
        $tipodeusuario = $_SESSION['nivel'];
        switch ($tipodeusuario) {
            case 'administrador':
                $id = $_SESSION['id'];
                $data = array(
                    'nombre' => ucwords(strtolower($this->input->post('nombre'))),
                    'ap_paterno' => ucwords(strtolower($this->input->post('ap_paterno'))),
                    'ap_materno' => ucwords(strtolower($this->input->post('ap_materno'))),
                    'email' => $this->input->post('email')
                );

                $this->db->where('id', $id);
                $this->db->update('usuarios', $data);

                header('Location: ' . base_url() . 'index.php/dashboard/perfil');
                break;
        }
    }

    public function editarimgperfil() {

        if (isset($_SESSION['usuario'])) {
            $tipodeusuario = $_SESSION['nivel'];
            switch ($tipodeusuario) {
                case 'administrador':
                    $this->load->view('html/header');
                    $this->load->view('html/menuadmin');
                    $this->load->view('dashboard/perfil/editarimgperfil', array('error' => ' '));
                    $this->load->view('html/footer');
                    break;
                case 'coordinador administrativo':
                    $this->load->view('html/header');
                    $this->load->view('html/menucadmon');
                    $this->load->view('dashboard/perfil/editarimgperfil', array('error' => ' '));
                    $this->load->view('html/footer');
                    break;
            }
        }
    }

    public function do_upload() {
        $config['upload_path'] = './subidas/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '10485760';
        $this->load->library('upload', $config);



        $queryimg = $this->db->query('SELECT img_perfil from usuarios WHERE id="' . $_SESSION['id'] . '"');
        if ($queryimg->num_rows() > 0) {
            foreach ($queryimg->result() as $row_u) {
                $do = unlink("subidas/" . $row_u->img_perfil);
                if ($do != true) {
                    echo "hubo un error al intentar eliminar el archivo" . $row_u->img_perfil . "<br />";
                }
            }
        }
        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('html/header');
            $this->load->view('html/menuadmin');
            $this->load->view('dashboard/perfil/editarimgperfil', $error);
            $this->load->view('html/footer');
        } else {
            $id = $_SESSION['id'];
            $data = $this->upload->data();
            $foto = $data['file_name'];
            $data2 = array(
                'img_perfil' => $data['file_name']
            );
            $this->db->where('id', $id);
            $this->db->update('usuarios', $data2);

            header('Location: imgresize/' . $foto . '/');
            // $this->load->view('upload_success', $data);
        }
    }

    public function imgresize($foto) {
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = './subidas/' . $foto;
        //$config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 500;
        $config['height'] = 500;
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        echo $config['source_image'];


        $image_config['image_library'] = 'gd2';
        $image_config['source_image'] = './subidas/' . $foto;
        $image_config['quality'] = "100%";
        $image_config['maintain_ratio'] = FALSE;
        $image_config['width'] = 300;
        $image_config['height'] = 300;
        $image_config['x_axis'] = '0';
        $image_config['y_axis'] = '0';

        $this->image_lib->clear();
        $this->image_lib->initialize($image_config);

        if (!$this->image_lib->crop()) {
            redirect("errorhandler"); //If error, redirect to an error page
        } else {
            header('Location:' . base_url() . 'index.php/dashboard/perfil');
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
                header('Location: ' . base_url() . 'index.php/sesion/cerrar/');
                break;
            case'coordinador administrativo':
                $password = sha1(sha1($this->input->post('password')));
                $usuariopassnuevo = array(
                    'password' => $password,
                );
                $this->db->where('id', $id);
                $this->db->update('usuarios', $usuariopassnuevo);
                header('Location: ' . base_url() . 'index.php/sesion/cerrar/');
                break;
            default :
                echo 'Acceso Restringido';
                header('Location: ' . base_url() . '');
        }
    }

}
