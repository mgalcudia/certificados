<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//require(__DIR__.'/mi_controlador.php'),
class mi_controlador extends CI_Controller{
    
    
    /**
     * Carga la plantilla html (encabezado, menu, cuerpo y pie).
     * @param unknown $cuerpo
     */
  function plantilla($cuerpo){ 
      
   //$cuerpo= $this->load->view("login",0 ,TRUE);
      
         if(!$this->session->userdata('usuario')){
             $encabezado= $this->load->view("cabecera",0 ,TRUE);
             //$cuerpo= $this->load->view("formulario_registro",0 ,TRUE);
             $menu_izq =$this->load->view("menu_izq",0,TRUE);
         }
         else{
             $datos_cabecera['datos']= $this->load->view('cabecerastring',0,TRUE);
             $datos_menuizq['datos_menu']= $this->load->view('menuizqstring',0,TRUE);
             $encabezado= $this->load->view("cabecera", $datos_cabecera ,TRUE);
             //$cuerpo= $this->load->view("formulario_registro",0 ,TRUE);
             $menu_izq =$this->load->view("menu_izq",$datos_menuizq,TRUE);
         }
        
         $pie= $this->load->view("pie",0,TRUE);  
        
        //Creo una plantilla con los apartados a mostrar
        $this->load->view('plantilla', array(
            'encabezado' => $encabezado,
            'menu_izq'=> $menu_izq,
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
    function paginador($url,$total_pagina,$total_filas,$segm=4){
        
        $config['uri_segment'] = $segm;
         $config['base_url']= $url;
         $config['total_rows']= $total_filas;
         $config['per_page'] = $total_pagina;
         $config['num_links'] = 2;
         $config['first_link'] = 'Primero';
         $config['last_link'] = 'Último';
         $config['full_tag_open'] = '<div id="paginacion">';//el div que debemos maquetar
         $config['full_tag_close'] = '</div>';//el cierre del div de la paginación
        
         $this->pagination->initialize($config);
         
         
         return $this->pagination->create_links();         
        
        
    }
    
    
        /**
     * envia al usuario un correo informandole del la modificacion de su contraseña.
     * @param type $usuario
     * @param type $mail
     * @return type
     */
    function password_mail($usuario, $mail,$contra) {

        // Utilizando smtp
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.iessansebastian.com';
        $config['smtp_user'] = 'aula4@iessansebastian.com';
        $config['smtp_pass'] = 'daw2alumno';
        $config['mailtype'] = 'html';

 
        $this->email->initialize($config);

        $this->email->from('aula4@iessansebastian.com', 'Tienda Virtual');
        $this->email->to($mail['mail']);
        $this->email->subject('Nuevo password');
        $this->email->message("<html><body><h2>Modifique la contraseña a una de su gusto</h2><p>Usuario:<font color='red'>" . $usuario .
                "</font></p><p>Nuevo password--> <font color='red'>.$contra.</font></p></body></html>");
        return $this->email->send();
    }
    
    
    
    
    
}