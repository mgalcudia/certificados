<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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
    function insertar_certificado($data) {
        
         if ($this->db->insert('certificado', $data)) {

             return $this->db->insert_id();
          
         } else {
                return false;
            }      
      
    }

    /**
     * 
     * Funcion para editar en certificados
     */
    function editar_certificado($cod, $datos) {

        $this->db->where('cod', $cod);
        if ($this->db->update('certificado', $datos)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * funcion para crear el corte
     */
    function insertar_historico($hitorico){
        
        if ($this->db->insert('historico', $hitorico)) {

             return true;
          
         } else {
                return false;
            }
        
        
    }

    /**
     * Busca certificado por diversos criterios
     * recogidos en $datos
     * @param type $datos
     * @return type
     */
    function buscar_certificado($datos){
        $this->db->where($datos);
        $query = $this->db->get('certificado');
        return $query->row_array();
    }

    
    
    
    
        function modificar_certificado($cod,$data) {
           
            $this->db->where('cod',$cod);
         if ($this->db->update('certificado', $data)) {

             return true;
          
         } else {
                return false;
            }      
      
    }
}
