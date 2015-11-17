<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require(__DIR__ . '/mi_controlador.php');

class fichero extends mi_controlador {

    function __construct() {
        parent::__construct();
    }
    
    
    function agregar_fichero(){
        
        $mail_usuario['mail']= $this->session->userdata('usuario');
        $datos=$this->usuario_modelo->buscar_usuario($mail_usuario);
        if (!file_exists(APPPATH . "../almacen/" .$datos['cod'])) {
            $carpeta=APPPATH . "../almacen/" .$datos['cod'];
            mkdir($carpeta,777); 
        }
        
        $data['emisor'] = $this->emisor_certificado->listar_emisor();
        $data['tipo']=$this->emisor_certificado->listar_tipo();
        $data['titulacion']=  $this->titulacion->listar_titulacion();
                        
       
        $cuerpo= $this->load->view('agregar',$data,TRUE);
        $this->plantilla($cuerpo);
       
       
    }
}