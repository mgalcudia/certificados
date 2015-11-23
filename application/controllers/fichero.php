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

        $this->form_validation->set_rules('curso', 'curso', 'trim|required');
        $this->form_validation->set_rules('hora', 'hora', 'trim|is_natural');
        $this->form_validation->set_rules('corte', 'corte', 'trim|required|exact_length[4]|is_natural');
        $this->form_validation->set_rules('fecha', 'fecha', 'trim');
        $this->form_validation->set_rules('tipo', 'tipo', 'trim');
        $this->form_validation->set_rules('nombre', 'nombre', 'trim');
        
        
        if($this->form_validation->run()==FALSE){
            
            $mail_usuario['mail']= $this->session->userdata('usuario');
        $datos=$this->usuario_modelo->buscar_usuario($mail_usuario);
        //Si no existe la carpeta con el id del usuario se genera
        if (!file_exists(APPPATH . "../almacen/" .$datos['cod'])) {
            $carpeta=APPPATH . "../almacen/" .$datos['cod'];
            mkdir($carpeta,777); 
        }
        $data['cod']=$datos['cod'];
        $data['emisor'] = $this->emisor_certificado->listar_emisor();
        $data['tipocertificado']=$this->emisor_certificado->listar_tipo();
        $data['titulacion']= $this->creaSelect();
        $data['error']= $this->session->flashdata('error');
        $cuerpo= $this->load->view('agregar',$data,TRUE);
        $this->plantilla($cuerpo);   
             
            
        }else{
            
            $datos['cod_usuario']=$this->input->post('cod');
            $datos['nombre'] = $this->input->post('curso');
            $datos['horas'] = $this->input->post('hora');
            $datos['corte'] = $this->input->post('corte');
            $datos['fecha'] = $this->input->post('fecha');
            //$datos['fichero'] = $this->input->post('fichero');
            $datos['cod_tipo_cer'] = $this->input->post('tipo');
            $datos['emisor_cod'] = $this->input->post('entidad');
            $titulaciones['titulacion_cod'] = $this->input->post('titulacion');
            $datos['observaciones'] = $this->input->post('observaciones');            
            $datos['baremado'] = $this->input->post('baremado'); 
            $datos['ruta']=APPPATH . "../almacen/" . $datos['cod_usuario'];
            
          $cod_curso=  $this->fichero_modelo->insertar_certificado($datos);
          
          $this->titulacion->insertar_titulacion_a_titulo($cod_curso,$titulaciones);
          $hitorico= array(
              'corte' => $datos['corte'],
              'certificado_cod'=>$cod_curso     
          );
          $this->fichero_modelo->insertar_historico($hitorico);
           //sube el fichero
           $this->do_upload($datos['cod_usuario'], $cod_curso);
            
        }
        
    }
    
    
    /**
     * Funcion para subir certificados al servidor 
     * @param type $cod_usuario
     * @param type $cod_curso
     */
      function do_upload($cod_usuario, $cod_curso) {


        $config['file_name'] = $cod_curso . '.pdf';
        $config['upload_path'] =APPPATH . "../almacen/" . $cod_usuario . "/";
        $config['allowed_types'] = 'pdf';
        $config['remove_spaces'] = TRUE;
        $config['max_size'] = '2048';

        

        $this->load->library('upload', $config);
       // print_r($this->upload->data());
        if (!$this->upload->do_upload('fichero')) {
            $this->session->set_flashdata('error', 'Error al Subir el fichero');
           
           redirect('fichero/agregar_fichero');
        
        } else {
            $data['error'] = 'Fichero subido';
            print_r('entro');
            // TODO: ENVIAR A LA VISTA DONDE SE VE EL CERTIFICADO SUBIDO
        }
        
        
    }

}