<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require(__DIR__.'/mi_controlador.php');

class inicio extends mi_controlador{
    
    function __construct() {
        parent::__construct();      
    }
    
       function index(){
   
       
        
        $cuerpo = $this->load->view('login', 0, TRUE);    
        
        $this->plantilla($cuerpo);
        
    }
    
}
