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

        if ($this->form_validation->run() == FALSE) {

            $cuerpo = $this->load->view('formulario_registro', 0, true);
            $this->plantilla($cuerpo);
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
                var_dump($datos);
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
        $this->form_validation->set_rules('password', 'password', 'trim|required|md5');
    }

}
