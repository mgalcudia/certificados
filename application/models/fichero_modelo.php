<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class fichero_modelo extends CI_Model {

    function __construct() {
        parent::__construct();        
    }
    
    
    
    
    
    
    /**
     *  Función para insertar certificado
     * @param type $data array de datos
     */
    function insertar_certificado ($data){
        var_dump($data);
        if ($this->db->insert('certificado',$data)){
            
            return $this->db->insert_id();
        }else{
            return false;
        }
           
       
       
    }
    
}