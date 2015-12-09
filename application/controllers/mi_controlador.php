<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//require(__DIR__.'/mi_controlador.php'),
class mi_controlador extends CI_Controller {

    /**
     * Carga la plantilla html (encabezado, menu, cuerpo y pie).
     * @param unknown $cuerpo
     */
    function plantilla($cuerpo) {

        

        if (!$this->session->userdata('usuario')) {
            $encabezado = $this->load->view("cabecera", 0, TRUE);
            
            $menu_izq = $this->load->view("menu_izq", 0, TRUE);
        } else {
			$datos_menuizq['historicos']=$this->historico_modelo->year_corte();
			
            $datos_cabecera['datos'] = $this->load->view('cabecerastring', 0, TRUE);
            $datos_menuizq['datos_menu'] = $this->load->view('menuizqstring', $datos_menuizq, TRUE);
            $encabezado = $this->load->view("cabecera", $datos_cabecera, TRUE);
            
            $menu_izq = $this->load->view("menu_izq", $datos_menuizq, TRUE);
        }
      $pie = $this->load->view("pie", 0, TRUE);
            
        //Creo una plantilla con los apartados a mostrar
            
        $this->load->view('plantilla', array(
            'encabezado' => $encabezado,
            'menu_izq' => $menu_izq,
            'cuerpo' => $cuerpo,
            'pie' => $pie
        ));
        
    }

    /**
     * Funcion para paginar los productos
     * @param type $url localizador del controlador donde nos encontramos 
     * @param type $total_pagina
     * @param type $total_filas
     * @return type devuelve el paginador
     */
    function paginador($url, $total_pagina, $total_filas, $segm = 4) {

        $config['uri_segment'] = $segm;
        $config['base_url'] = $url;
        $config['total_rows'] = $total_filas;
        $config['per_page'] = $total_pagina;
        $config['num_links'] = 2;
        $config['first_link'] = 'Primero';
        $config['last_link'] = 'Último';
        $config['full_tag_open'] = '<div id="paginacion">'; //el div que debemos maquetar
        $config['full_tag_close'] = '</div>'; //el cierre del div de la paginación

        $this->pagination->initialize($config);


        return $this->pagination->create_links();
    }

    /**
     * envia al usuario un correo informandole del la modificacion de su contraseña.
     * @param type $usuario
     * @param type $mail
     * @return type
     */
    function password_mail($usuario, $mail, $contra) {

        // Utilizando smtp
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.iessansebastian.com';
        $config['smtp_user'] = 'aula4@iessansebastian.com';
        $config['smtp_pass'] = 'daw2alumno';
        $config['mailtype'] = 'html';


        $this->email->initialize($config);

        $this->email->from('aula4@iessansebastian.com', 'Certificados 1.0');
        $this->email->to($mail['mail']);
        $this->email->subject('Nuevo password');
        $this->email->message("<html><body><h2>Modifique la contraseña a una de su gusto</h2><p>Usuario:<font color='red'>" . $usuario .
                "</font></p><p>Nuevo password--> <font color='red'>$contra</font></p></body></html>");
        return $this->email->send();
    }

    function creaSelect($sel = '') {

        
        $opciones = $this->titulacion->listar_titulacion();        
        $html = "
    <script type='text/javascript'>
        $(function () {
            $('#titulacion').multiselect({
                includeSelectAllOption: true
            });
           
        });
    </script>
   <select id='titulacion' multiple='multiple' name='titulacion[]'>";
        foreach ($opciones as $val => $texto) {          
                foreach ($sel as $valor) {

                    if ($valor == $val) {                        
                        break;
                    }
                }
                $selected = ($val ==$valor ) ? " selected " : "";
            
            $html.="\n<option value=\"$val\" $selected>$texto</option>";
        }
        $html.="</select>";

        $html.= "<span class='help-block'><?= form_error('titulacion')?></span>";
        return $html;
    }


function crea_no_selected($sel = '') {

        
        $opciones = $this->titulacion->listar_titulacion();        
        $html = "
    <script type='text/javascript'>
        $(function () {
            $('#titulacion').multiselect({
                includeSelectAllOption: true
            });
           
        });
    </script>
   <select id='titulacion' multiple='multiple' name='titulacion[]'>";
        foreach ($opciones as $val => $texto) {

           
                $selected = ($val ==$sel ) ? " selected " : "";
            

            
            $html.="\n<option value=\"$val\" $selected>$texto</option>";
        }
        $html.="</select>";
        return $html;
    }
        
   /**
     * Funcion para mostrar titulos 
     * Recibe por parametro el cod del curso 
     * @param type $cod
     */    
    function mostrar_titulo($cod = ''){
     
       
       $cuerpo="";
        //print_r($cod);
        

        $datos['cod'] =$cod;
        $data = $this->fichero_modelo->buscar_certificado($datos);


        $data['titulacion'] = $this->titulacion->buscar_nombre_titulacion($datos);
        
         // convertirmos la fecha del servidor en una meda (d-m-y)
        $data['fecha']= $this->formato_fecha_bajar($data['fecha']);

     
                    
        
             if ($data['baremado']) {
                $data['baremo'] = 'si';
                
            } else {
                $data['baremo'] = 'no';
            }
            
            //$data['cod'] = '67';// codigo puesto para testeo

            $emisor = $this->emisor_certificado->listar_emisor();
            $tipo = $this->emisor_certificado->listar_tipo();
            $data['emisor']=$emisor[$data['emisor_cod']];
            $data['tipo_certificado']= $tipo[$data['cod_tipo_cer']];
         
         
              
         return $cuerpo= $this->load->view('mostrar_curso', $data, TRUE);     
        
    }     



    function formato_fecha_subir($fecha){


            $fecha_nueva =  new DateTime($fecha);
           $resultado=$fecha_nueva->format("Y-m-d");
           return $resultado;

    }

    function formato_fecha_bajar($fecha){

           $fecha_nueva =  new DateTime($fecha);
           $resultado=$fecha_nueva->format("d-m-Y");
           
           return $resultado;


    }
        




}
