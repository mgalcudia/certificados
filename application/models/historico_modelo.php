<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class historico_modelo extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    
    function year_corte(){
        
        $this->db->select('corte, certificado_cod');
        $this->db->group_by('corte');
        $this->db->order_by('corte', 'desc'); 
      $consulta= $this->db->get('historico');
      
      print_r($consulta->result_array());
       return $consulta; 
       
       
       
        
    }
    
    
    
}

