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
        
        $this->form_validation->set_rules('mail','mail','trim|required|valid_email');
        $this->form_validation->set_rules('pasword','pasword','trim|required|md5');
        
        if($this->form_validation->run()== FALSE){           
            
            if(!$this->session->userdata('usuario')){
                $cuerpo= $this->load->view('login',0,TRUE);
                $this->plantilla($cuerpo);
                
            }else{
                
                $cuerpo= $this->load->view('principal',0,TRUE);
                $this->plantilla($cuerpo);
            }
            
        }else{
            
            $mail= $this->input->post('mail');
            $pasword=$this->input->post('pasword');
       
            if($this->usuario_modelo->loginok($mail, $pasword)==TRUE){
    
                $this->session->set_userdata('usuario',$mail);
                //usuario correcto a ver donde lo mandamos
                
                $cuerpo= $this->load->view('principal',0,TRUE);
                $this->plantilla($cuerpo);
                
            }else{
                
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
            $this->session->unset_userdata('usuario');
            redirect(site_url());
        } else {
            $this->session->set_flashdata('informe', 'No había sesión iniciada');
            redirect(site_url());
        }
    }

    
    function recuperar_pass(){
        
                $this->form_validation->set_rules('mail', 'mail', 'trim|required|valid_email');
                     

        if ($this->form_validation->run() == FALSE) {

            $cuerpo = $this->load->view('restaurar_pass', '', TRUE);
            $this->plantilla($cuerpo);
        } else {
            $correo = $this->input->post('email');
            $consulta = $this->clientes_modelo->existe_mail($correo);
            if ($consulta) {

                $usuario = $consulta['usuario'];
                $mail['email'] = $consulta['email'];
                $pass['password'] = md5('123456');
                $id = $consulta['id'];

                if ($this->clientes_modelo->editar_cliente($id, $pass)) {

                    //mandamos el correo
                    $this->password_mail($usuario, $mail);
                    print_r($pass['password']);
                    //Iniciamos la sesion del usuario y lo enviamos al panel de control
                    if ($this->clientes_modelo->loginok($usuario, $pass['password']) == true) {
                        $this->session->set_userdata('usuario', $usuario);
                        redirect(site_url('usuario_controlador/panel_control'));
                    }
                } else {
                    //se produce un error
                    $this->session->set_flashdata('informe', 'Se ha producido un error al restaurar el password');
                    redirect(site_url('usuario_controlador/restablece_pass'));
                }
            } else {
                $this->session->set_flashdata('informe', 'El correo electronico no está registrado');
                redirect(site_url('usuario_controlador/restablece_pass'));
            }
        }
        
        
        
        
        
    }
    
    
    
    
}
