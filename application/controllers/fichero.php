<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require(__DIR__ . '/mi_controlador.php');

class fichero extends mi_controlador {

    function __construct() {
        parent::__construct();
    }
    
    /**
     * Agrega los datos del certificado a subir y sube el fichero al servidor
     * 
     */
    function agregar_fichero(){
       /* 
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
        $this->form_validation->set_rules('apellidos', 'apellidos', 'trim|required');
        $this->form_validation->set_rules('dni', 'dni', 'trim|required|exact_length[9]|callback_validarDNI');
        $this->form_validation->set_rules('direccion', 'direccion', 'trim|required');
        $this->form_validation->set_rules('pasword', 'pasword', 'trim|required|md5');
        $this->form_validation->set_rules('mail', 'mail', 'trim|required|valid_email');
        */
        $this->form_validation->set_rules('curso', 'curso', 'trim|required');
        $this->form_validation->set_rules('hora', 'hora', 'trim|is_natural');
        $this->form_validation->set_rules('corte', 'corte', 'trim|required|exact_length[4]|is_natural');
        $this->form_validation->set_rules('fecha', 'fecha', 'trim');
        $this->form_validation->set_rules('tipo', 'tipo', 'trim');
        $this->form_validation->set_rules('nombre', 'nombre', 'trim');
        
        
        if($this->form_validation->run()==FALSE){
            
            $mail_usuario['mail']= $this->session->userdata('usuario');
        $datos=$this->usuario_modelo->buscar_usuario($mail_usuario);
        if (!file_exists(APPPATH . "../almacen/" .$datos['cod'])) {
            $carpeta=APPPATH . "../almacen/" .$datos['cod'];
            mkdir($carpeta,777); 
        }
        $data['cod']=$datos['cod'];
        $data['emisor'] = $this->emisor_certificado->listar_emisor();
        $data['tipo']=$this->emisor_certificado->listar_tipo();
        $data['titulacion']= $this->creaSelect();
        
        $cuerpo= $this->load->view('agregar',$data,TRUE);
        $this->plantilla($cuerpo);   
             print_r($this->input->post());
            
        }else{
            
            $datos['cod_usuario']=$this->input->post('cod');
            $datos['nombre'] = $this->input->post('curso');
            $datos['horas'] = $this->input->post('hora');
            $datos['corte'] = $this->input->post('corte');
            $datos['fecha'] = $this->input->post('fecha');
            $datos['fichero'] = $this->input->post('fichero');
            $datos['cod_tipo_cer'] = $this->input->post('tipo');
            $datos['emisor_cod'] = $this->input->post('entidad');
            $datos['titulacion_cod'] = $this->input->post('titulacion');
            $datos['mail'] = $this->input->post('observaciones');            
            $datos['baremado'] = $this->input->post('baremado'); 
            
            redirect(site_url());
            
            
        }
        
    }
    
    
      function do_upload($cod_usuario, $cod_curso) {


        $config['file_name'] = $cod_curso . '.pdf';
        $config['upload_path'] = APPPATH . "../almacen/" . $cod_usuario . "/";
        $config['allowed_types'] = 'pdf';
        $config['remove_spaces'] = TRUE;
        $config['max_size'] = '2048';

        //print_r($config);

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('upload_form', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $this->load->view('upload_success', $data);
        }
    }

}