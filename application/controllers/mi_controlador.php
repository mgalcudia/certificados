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

            if (count($sel) > 1) {
                foreach ($sel as $valor) {

                    if ($valor == $val) {                        
                        break;
                    }
                }
                $selected = ($val ==$valor ) ? " selected " : "";
            }else{
                $selected = ($val ==$sel ) ? " selected " : "";
            }

            
            $html.="\n<option value=\"$val\" $selected>$texto</option>";
        }
        $html.="</select>";
        return $html;
    }

    /*
    function crearadiobutton($valordefecto){
        
        print_r($valordefecto);
        $opciones= array('si','no');
        $name= 'baremado';
        foreach($opciones as $valor=>$clave){
           
            $html='<input type="radio" name="'.$name.'"value"'.$clave.'"';
            
            if($clave==$valordefecto){
                
              $html.='checked="checked"';              
            }
            $html.='>'.$clave.'<br/>';
             print_r($html);
            return $html;
            
        }
           
            
    
    }*/ 
        
        
        
        

}
