<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require(__DIR__ . '/mi_controlador.php');

class historico extends mi_controlador {

    function __construct() {
        parent::__construct();
    }

    
    
    
    function mostrar_historico($year=""){
        $cuerpo="";
      //$year= $this->historico_modelo->year_corte();
        
      $cod_curso= $this->historico_modelo->cursos_corte($year);
        
        print_r($cod_curso);
       foreach ($cod_curso as $key => $value) {
         
         foreach ($value as $valor) {

     //  print_r($valor."<br/>");
         $cuerpo.=  $this->mostrar_titulo($valor);
            }
        }
		
        $this->plantilla($cuerpo);
    }
	
	 
	
	
	
}