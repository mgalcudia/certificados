<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require(__DIR__ . '/mi_controlador.php');

class fichero extends mi_controlador {

    function __construct() {
        parent::__construct();
    }



function valida_titulacion($titulacion){
if( is_array($titulacion) && count($titulacion)>0){

      foreach ($titulacion as $key => $value) {
       
       if (isset($value)){

        return true;
       }else{

        return FALSE;
       }
    } 
}else{

      return FALSE;
    } 
}


    /**
     * Agrega los datos del certificado a subir y sube el fichero al servidor
     * 
     */
    function agregar_fichero() {

        $this->form_validation->set_rules('curso', 'curso', 'trim|required');
        $this->form_validation->set_rules('hora', 'hora', 'trim|is_natural');
        $this->form_validation->set_rules('corte', 'corte', 'trim|required|exact_length[4]|is_natural');
        $this->form_validation->set_rules('fecha', 'fecha', 'trim|required');
        $this->form_validation->set_rules('tipo', 'tipo', 'trim|required');
        $this->form_validation->set_rules('entidad', 'entidad', 'trim|required');
      //  $this->form_validation->set_rules('titulacion[]', 'titulacion', 'trim|required |callback_valida_titulacion');


        if ($this->form_validation->run() == FALSE) {

            $mail_usuario['mail'] = $this->session->userdata('usuario');
            $datos = $this->usuario_modelo->buscar_usuario($mail_usuario);
            //Si no existe la carpeta con el id del usuario se genera
            if (!file_exists(APPPATH . "../almacen/" . $datos['cod'])) {
                $carpeta = APPPATH . "../almacen/" . $datos['cod'];
                mkdir($carpeta, 777);
            }
            $data['cod'] = $datos['cod'];
            $data['emisor'] = $this->emisor_certificado->listar_emisor();
            $data['tipocertificado'] = $this->emisor_certificado->listar_tipo();
            $data['titulacion'] = $this->crea_no_selected();
            $data['error'] = $this->session->flashdata('error');
            $cuerpo = $this->load->view('agregar', $data, TRUE);
            $this->plantilla($cuerpo);
        } else {

            $datos['cod_usuario'] = $this->input->post('cod');
            $datos['nombre'] = $this->input->post('curso');
            $datos['horas'] = $this->input->post('hora');
            $datos['corte'] = $this->input->post('corte');
            $datos['fecha'] = $this->input->post('fecha');
            $datos['cod_tipo_cer'] = $this->input->post('tipo');
            $datos['emisor_cod'] = $this->input->post('entidad');
            $titulaciones['titulacion_cod'] = $this->input->post('titulacion');
            $datos['observaciones'] = $this->input->post('observaciones');
            $datos['baremado'] = $this->input->post('baremado');
            $datos['ruta'] = APPPATH . "../almacen/" . $datos['cod_usuario'];

            $cod_curso = $this->fichero_modelo->insertar_certificado($datos);

            $this->titulacion->insertar_titulacion_a_titulo($cod_curso, $titulaciones);
            $hitorico = array(
                'corte' => $datos['corte'],
                'certificado_cod' => $cod_curso
            );
            $this->fichero_modelo->insertar_historico($hitorico);

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
        $config['upload_path'] = APPPATH . "../almacen/" . $cod_usuario . "/";
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
            $cuerpo = $this->mostrar_titulo($cod_curso);
            $this->plantilla($cuerpo);
        }
    }

    /**
     * Funcion para modificar un titulo
     *
     * @param type $cod codigo del curso
     */
    function modificar_titulo($cod = '') {

        $datos['cod'] = $cod;
        $this->form_validation->set_rules('curso', 'curso', 'trim|required');
        $this->form_validation->set_rules('hora', 'hora', 'trim|is_natural');
        $this->form_validation->set_rules('corte', 'corte', 'trim|required|exact_length[4]|is_natural');
        $this->form_validation->set_rules('fecha', 'fecha', 'trim|required');
        $this->form_validation->set_rules('tipo', 'tipo', 'trim|required');
        $this->form_validation->set_rules('entidad', 'entidad', 'trim|required');
        $this->form_validation->set_rules('titulacion[]', 'titulacion', 'trim|required');

        $mail_usuario['mail'] = $this->session->userdata('usuario');
        $cod_usuario = $this->usuario_modelo->buscar_usuario($mail_usuario);
        $data = $this->fichero_modelo->buscar_certificado($datos);
        $val = $this->titulacion->buscar_titulacion($datos);
        $data['titulacion'] = $this->creaSelect($val);

        if ($this->form_validation->run() == FALSE) {

            if ($data['baremado']) {
                $data['si'] = 'checked';
                $data['no'] = '';
            } else {
                $data['si'] = '';
                $data['no'] = 'checked';
            }

            //  $data['cod'] = '67';
            $data['emisor'] = $this->emisor_certificado->listar_emisor();
            $data['tipocertificado'] = $this->emisor_certificado->listar_tipo();
            $data['error'] = $this->session->flashdata('error');
            //  print_r($data);
            $cuerpo = $this->load->view('modificar_fichero', $data, TRUE);
            $this->plantilla($cuerpo);
        } else {

            $cod = $this->input->post('cod');
            // print_r($cod);
            $datos['cod_usuario'] = $this->input->post('cod_user');
            $datos['nombre'] = $this->input->post('curso');
            $datos['horas'] = $this->input->post('hora');
            $datos['corte'] = $this->input->post('corte');
            $datos['fecha'] = $this->input->post('fecha');
            $datos['cod_tipo_cer'] = $this->input->post('tipo');
            $datos['emisor_cod'] = $this->input->post('entidad');
            $titulaciones['titulacion_cod'] = $this->input->post('titulacion');
            $datos['observaciones'] = $this->input->post('observaciones');
            $datos['baremado'] = $this->input->post('baremado');
            // print_r($datos['cod_usuario']);
            $datos['ruta'] = APPPATH . "../almacen/" . $datos['cod_usuario'];
            //  print_r($datos['ruta']);
            //si se modifica el certificado
            if ($this->fichero_modelo->modificar_certificado($cod, $datos)) {


                $this->titulacion->modificar_titulacion_a_titulo($cod, $titulaciones);
                if ($data['corte'] != $datos['corte']) {
                    //  print_r('entro'.$datos['corte']);
                    $hitorico = array(
                        'corte' => $datos['corte'],
                        'certificado_cod' => $cod
                    );
                    $this->fichero_modelo->insertar_historico($hitorico);
                }


                $cuerpo = $this->mostrar_titulo($cod);
                $this->plantilla($cuerpo);
            } else {
                $this->session->set_flashdata('error', 'Error al modificar el fichero');
                redirect(site_url('index.php/fichero/modificar_titulo'));
            }
        }
    }

    /**
     * Funcion para mostrar los enlaces de las opciones para buscar los certificados y editarlos
     * @param type $cod_usuario
     * @param type $cod_curso
     */
    function mostrar_enlaces_editar($value = '') {

       
        $codusuario = $this->session->userdata('cod_usuario');

        switch ($value) {
            
            case "nobaremado":
              
                $consulta = array(
                    'cod_usuario' => $codusuario,
                    'baremado' => 0
                );
               $cuerpo= $this->mostrar_estado_baremado($consulta);
                  
                break;
            case "baremado":
                $consulta = array(
                    'cod_usuario' => $codusuario,
                    'baremado' => 1
                );
            $cuerpo=  $this->mostrar_estado_baremado($consulta);
                break;
            case "tipo":   

              $cuerpo= $this->mostrar_tipo_certificado();
               
                break;
            case "titulacion":   

              $cuerpo= $this->mostrar_tipo_titulacion();
               
                break;
            default:
                $cuerpo = $this->load->view('mostrar_enlaces_editar', 0, TRUE);
                break;
        }
       
        $this->plantilla($cuerpo);
    }


    function mostrar_estado_baremado($consulta) {
        $cuerpo = "";
        $datos = $this->fichero_modelo->buscar_varios_certificados($consulta);
        foreach ($datos as $key => $value) {

            foreach ($value as $valor) {

                $cuerpo.= $this->mostrar_titulo($valor);
            }
        }
        
        return $cuerpo;
    }

    
    function mostrar_tipo_certificado(){

        $this->form_validation->set_rules('tipo', 'tipo', 'trim|required');        
       // $this->form_validation->set_rules('titulacion', 'titulacion', 'required |callback_valida_titulacion');
       
        if ($this->form_validation->run() == FALSE) {

            $data['error'] = $this->session->flashdata('error');
            $data['titulacion'] = $this->crea_no_selected();  
            $data['tipocertificado'] = $this->emisor_certificado->listar_tipo();       
            return $this->load->view('formulario_mostrar_portitulo',$data,TRUE);
           // $this->plantilla($cuerpo);

        }else{
            
            $cuerpo="";
            $consulta=array();
            $cod_tipo_cer= $this->input->post('tipo');
            $titulacion_cod = $this->input->post('titulacion');
            $baremado = $this->input->post('baremado');
          //  print_r($cod_tipo_cer);
             
    //$titulacion="1";

            if (isset($titulacion)){
             foreach ($titulacion_cod as $key => $titulacion) {
                 
             $consulta[]= $this->fichero_modelo->certificado_tiulacion($cod_tipo_cer,$titulacion,$baremado);           
             
             }
            }else{

                $consulta[]= $this->fichero_modelo->certificado_tiulacion($cod_tipo_cer,$titulacion="",$baremado);

            }
               
               foreach ($consulta as $key => $value) {
                    
                

                                    if(count($value)>0){

                                    print_r("entro");
                                 foreach ($value as $clave => $valor) {

                                 

                                     print_r($valor['cod']);
                                $cuerpo.= $this->mostrar_titulo($valor['cod']);

                                }                                   


                                 }else{

                                    print_r("no entro");
                                 $this->session->set_flashdata('error', 'No existen datos para esa consulta, realice otra');
                                redirect(site_url().'/fichero/mostrar_enlaces_editar/tipo');                                   

                                 }                                  
                             }
                             $this->plantilla($cuerpo);
        } 
   }



        function mostrar_tipo_titulacion(){


             if ($this->form_validation->run() == FALSE) {

            $data['error'] = $this->session->flashdata('error');
            $data['titulacion'] = $this->crea_no_selected();
            return $this->load->view('formulario_mostrar_portitulacion',$data,TRUE);


             }else{



             }



        }

////////////////////////////FIN//////////////////////////////
}

        
      

   