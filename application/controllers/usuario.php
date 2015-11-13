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
                $consulta = $this->usuario_modelo->existe_mail($mail);
                $this->session->set_userdata('usuario',$mail);
                $this->session->set_userdata('nombre', $consulta['nombre']);
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

    
    /*
     * Restaura la contraseña del usuario recibiendo como dato el correo electronico
     */
    function recuperar_pass(){
        
        $this->form_validation->set_rules('mail', 'mail', 'trim|required|valid_email');
                     

        if ($this->form_validation->run() == FALSE) {

            $cuerpo = $this->load->view('recuperar_pass', 0, TRUE);
            $this->plantilla($cuerpo);
        } else {
            $correo = $this->input->post('mail');            
            $consulta = $this->usuario_modelo->existe_mail($correo);
            
            if ($consulta) {
              $aleatorio=$this->getrandomcode();
                $usuario = $consulta['nombre'];
                $mail['mail'] = $consulta['mail'];
                $pass['pasword'] = md5($aleatorio);
                $id = $consulta['cod'];
                
                if ($this->usuario_modelo->editar_cliente($id, $pass)) {

                    //mandamos el correo
                    $this->password_mail($usuario, $mail,$aleatorio);
                   
                    
                    //Iniciamos la sesion del usuario y lo enviamos al panel de control
                    if ($this->usuario_modelo->loginok($mail['mail'], $pass['pasword']) == true) {
                        $this->session->set_userdata('usuario', $mail['mail']); 
                      $this->session->set_userdata('nombre', $usuario);                    
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
            
        }
        
    }
    
    /*
     * funcion que genera una clave aleatoria para la restauracion de contraseña
     */
    function getrandomcode(){
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
    function editarusuario(){
        
        
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
        $this->form_validation->set_rules('apellidos', 'apellidos', 'trim|required');
        $this->form_validation->set_rules('dni', 'dni', 'trim|required|exact_length[9]|callback_validarDNI');
        $this->form_validation->set_rules('direccion', 'direccion', 'trim|required');
        $this->form_validation->set_rules('pasword', 'pasword', 'trim|required|md5');
        $this->form_validation->set_rules('mail', 'mail', 'trim|required|valid_email');
       
        $datos['mail']=$this->session->userdata('usuario');
        
        
               //da formato a los errores
        
        
        $data['usuario']=$usuario;
         $data['datos']=  $this->usuario_modelo-> buscar_usuario($datos);
                 

            if ($this->form_validation->run() == FALSE) {

            $cuerpo = $this->load->view('formulario_modificar', $data, TRUE);
            $this->plantilla($cuerpo);
        }else{
            
            $id=$this->input->post('id');
            $datos['nombre'] = $this->input->post('nombre');
            $datos['apellidos'] = $this->input->post('apellidos');
            $datos['dni'] = $this->input->post('dni');
            $datos['direccion'] = $this->input->post('direccion');
            $datos['codpostal'] = $this->input->post('codpostal');
            $datos['provincia_id'] = $this->input->post('selprovincias');
            $datos['usuario'] = $this->input->post('usuario');
            $datos['email'] = $this->input->post('email');
            $datos['password'] = $this->input->post('password');
            
            
           
            if($this->clientes_modelo->editar_cliente($id, $datos)){
               redirect(site_url('usuario_controlador/panel_control')); 
               
            }else{
                $this->session->set_flashdata('informe', 'Error al editar');
                redirect(site_url('usuario_controlador/editar'));
                
            }
           
            
        }
    }
       
        
        
    
    
    
}
