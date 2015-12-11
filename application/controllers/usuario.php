<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require(__DIR__ . '/mi_controlador.php');

class usuario extends mi_controlador {

    function __construct() {
        parent::__construct();
    }

    /**
     * Valida el campo DNI
     * @param unknown $str
     * @return boolean
     */
    function validarDNI($str) {
        $str = trim($str);
        $str = str_replace("-", "", $str);
        $str = str_ireplace(" ", "", $str);

        if (!preg_match("/^[0-9]{7,8}[a-zA-Z]{1}$/", $str)) {

            return FALSE;
        } else {
            $n = substr($str, 0, -1);
            $letter = substr($str, -1);
            $letter2 = substr("TRWAGMYFPDXBNJZSQVHLCKE", $n % 23, 1);
            if (strtolower($letter) != strtolower($letter2))
                return FALSE;
        }
        return TRUE;
    }

    /**
     * Funcion que registra los usuarios en la base de datos
     * 
     */
    function registro() {

        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
        $this->form_validation->set_rules('apellidos', 'apellidos', 'trim|required');
        $this->form_validation->set_rules('dni', 'dni', 'trim|required|exact_length[9]|callback_validarDNI');
        $this->form_validation->set_rules('direccion', 'direccion', 'trim|required');
        $this->form_validation->set_rules('pasword', 'pasword', 'trim|required|md5');
        $this->form_validation->set_rules('mail', 'mail', 'trim|required|valid_email');

        $mensaje['mensaje'] = "Registro de nuevo usuario";
        $aviso = $this->load->view('mensaje', $mensaje, TRUE);

        if ($this->form_validation->run() == FALSE) {

            $cuerpo = $this->load->view('formulario_registro', 0, true);
            $this->plantilla($aviso . $cuerpo);
        } else {

            $datos['nombre'] = $this->input->post('nombre');
            $datos['apellidos'] = $this->input->post('apellidos');
            $datos['dni'] = $this->input->post('dni');
            $datos['direccion'] = $this->input->post('direccion');
            $datos['pasword'] = $this->input->post('pasword');
            $datos['mail'] = $this->input->post('mail');


            if ($this->usuario_modelo->existe_usuario($datos['email'])) {

                $mensaje['error'] = 'El correo electronico ya esta en uso';
                $cuerpo = $this->load->view('formulario_registro', $mensaje, true);
                $this->plantilla($cuerpo);
            } else {
                // var_dump($datos);
                $this->usuario_modelo->insertar_usuario($datos);
                redirect(site_url());
            }
        }
    }

    /*
     * funcion utizada en el login
     */

    function login() {

        $this->form_validation->set_rules('mail', 'mail', 'trim|required|valid_email');
        $this->form_validation->set_rules('pasword', 'pasword', 'trim|required|md5');

        if ($this->form_validation->run() == FALSE) {

            if (!$this->session->userdata('usuario')) {
                $cuerpo = $this->load->view('login', 0, TRUE);
                $this->plantilla($cuerpo);
            } else {

                $cuerpo = $this->load->view('principal', 0, TRUE);
                $this->plantilla($cuerpo);
            }
        } else {

            $mail = $this->input->post('mail');
            $pasword = $this->input->post('pasword');

            if ($this->usuario_modelo->loginok($mail, $pasword) == TRUE) {
                $consulta = $this->usuario_modelo->existe_mail($mail);
                $this->session->set_userdata('usuario', $mail);
                $this->session->set_userdata('nombre', $consulta['nombre']);
                $this->session->set_userdata('cod_usuario', $consulta['cod']);

                //print_r($this->session->userdata('cod_usuario'));
                //usuario correcto a ver donde lo mandamos

                $cuerpo = $this->load->view('principal', 0, TRUE);
                $this->plantilla($cuerpo);
            } else {

                //usuario incorrecto
                $data['error'] = "<h1>Usuario incorrecto</h1>";
                $cuerpo = $this->load->view('login', $data, TRUE);
                $this->plantilla($cuerpo);
            }
        }
    }

    /**
     * Cerrar sesión usuario
     */
    function salir() {

        if ($this->session->userdata('usuario')) {


            if ($this->input->post('si')) {
                $this->session->unset_userdata('usuario');
                $this->session->unset_userdata('nombre');
                $this->session->unset_userdata('cod_usuario');


                redirect(site_url());
            } else if ($this->input->post('no')) {

                redirect(site_url());
            } else {
                $cuerpo = $this->load->view('salir', 0, TRUE);
                $this->plantilla($cuerpo);
            }
        } else {

            redirect(site_url());
        }
    }

    /**
     * Da de baja a un usuario
     */
    function baja() {

        if ($this->session->userdata('usuario')) {

            $cod = $this->session->userdata('cod_usuario');

            if ($this->input->post('si')) {
                $this->session->unset_userdata('usuario');
                $this->session->unset_userdata('nombre');
                $this->session->unset_userdata('cod_usuario');

                $this->usuario_modelo->baja_usuario($cod);
                redirect(site_url());
            } else if ($this->input->post('no')) {

                redirect(site_url());
            } else {
                $cuerpo = $this->load->view('dar_baja', 0, TRUE);
                $this->plantilla($cuerpo);
            }
        } else {

            redirect(site_url());
        }
    }

    /*
     * Restaura la contraseña del usuario recibiendo como dato el correo electronico
     */

    function recuperar_pass() {

        $this->form_validation->set_rules('mail', 'mail', 'trim|required|valid_email');


        if ($this->form_validation->run() == FALSE) {

            $cuerpo = $this->load->view('recuperar_pass', 0, TRUE);
            $this->plantilla($cuerpo);
        } else {
            $correo = $this->input->post('mail');
            
            $activo= $this->usuario_modelo->usuario_activo($correo);

            if($activo){
               $consulta = $this->usuario_modelo->existe_mail($correo); 
            if ($consulta) {
                $aleatorio = $this->getrandomcode();
                $usuario = $consulta['nombre'];
                $mail['mail'] = $consulta['mail'];
                $pass['pasword'] = md5($aleatorio);
                $id = $consulta['cod'];
                if ($this->usuario_modelo->editar_usuario($id, $pass)) {

                    //mandamos el correo
                    $this->password_mail($usuario, $mail, $aleatorio);

                   
                    //var_dump($pass);
                    //Iniciamos la sesion del usuario y lo enviamos al panel de control
                    if ($this->usuario_modelo->loginok($mail['mail'], $pass['pasword']) == true) {
                $this->session->set_userdata('usuario', $mail['mail']);
                $this->session->set_userdata('nombre', $consulta['nombre']);
                $this->session->set_userdata('cod_usuario', $consulta['cod']);
                        redirect(site_url(''));
                    }
                } else {

                    $data['error'] = "<h1>Se ha producido un error al restaurar el password</h1>";
                    $cuerpo = $this->load->view('recuperar_pass', $data, TRUE);
                    $this->plantilla($cuerpo);
                }
            } else {

                $data['error'] = '<h3>El correo electronico no está registrado</h3>';
                $cuerpo = $this->load->view('recuperar_pass', $data, TRUE);
                $this->plantilla($cuerpo);
            }

            }else{

                $data['error'] = '<h3>El usuario no está activo por favor contacte con el administrador</h3>';
                $cuerpo = $this->load->view('recuperar_pass', $data, TRUE);
                $this->plantilla($cuerpo);

            }


        }
    }

    /*
     * funcion que genera una clave aleatoria para la restauracion de contraseña
     */

    function getrandomcode() {
        $an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-)(.:,;";
        $su = strlen($an) - 1;
        return substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1);
    }

    /*
     * Edita usuario
     */

    function editarusuario() {

        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
        $this->form_validation->set_rules('apellidos', 'apellidos', 'trim|required');
        $this->form_validation->set_rules('dni', 'dni', 'trim|required|exact_length[9]|callback_validarDNI');
        $this->form_validation->set_rules('direccion', 'direccion', 'trim|required');
        //$this->form_validation->set_rules('pasword', 'pasword', 'trim|required|md5');
        $this->form_validation->set_rules('mail', 'mail', 'trim|required|valid_email');

        $datos['mail'] = $this->session->userdata('usuario');

          //  print_r($this->session->userdata('usuario'));

        $data['datos'] = $this->usuario_modelo->buscar_usuario($datos);

        if ($this->form_validation->run() == FALSE) {

            $mensaje['mensaje'] = 'Modificar datos de usuario';
            $aviso = $this->load->view('mensaje', $mensaje, TRUE);
            $cuerpo = $this->load->view('formulario_modificar', $data, TRUE);
            $this->plantilla($aviso . $cuerpo);
        } else {


            $id = $this->input->post('cod');
            $datos['nombre'] = $this->input->post('nombre');
            $datos['apellidos'] = $this->input->post('apellidos');
            $datos['dni'] = $this->input->post('dni');
            $datos['direccion'] = $this->input->post('direccion');
            $datos['mail'] = $this->input->post('mail');
            $datos['pasword'] = md5($this->input->post('pasword'));

            if ($this->usuario_modelo->editar_usuario($id, $datos)) {
                redirect(site_url('usuario/editarusuario'));
            } else {

                $data['error'] = '<h3>Error al modificar</h3>';
                $cuerpo = $this->load->view('formulario_modificar', $data, TRUE);
                $this->plantilla($cuerpo);
            }
        }
    }

}
