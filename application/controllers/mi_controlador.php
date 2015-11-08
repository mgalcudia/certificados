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
  
         if(!$this->session->userdata('usuario')){
             $encabezado= $this->load->view("cabecera",0 ,TRUE);
             $cuerpo= $this->load->view("login",0 ,TRUE);
             $menu_izq =$this->load->view("menu_izq",0,TRUE);
         }
         else{
             
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
    
    
    
    
    
}