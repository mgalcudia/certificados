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
      //  print_r($this->session->userdata('cod_usuario'));
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

    /**
     * Busca certificado por diversos criterios
     * recogidos en $datos
     * @param type $datos
     * @return type
     */
    function buscar_varios_certificados($datos){
       // print_r($datos);
        $cod_usuario=$this->session->userdata('cod_usuario');
        $this->db->select('cod');
         $this->db->from('certificado');
        $this->db->where($datos);
        $this->db->where('cod_usuario',$cod_usuario);
        $query = $this->db->get();
        return $query->result_array();
    }


   function certificado_tiulacion($tipo="",$titulacion="",$baremado=""){
        
      //  print_r("titpo".$tipo."--titulacion".$titulacion."---baremado".$baremado);
        $cod_usuario=$this->session->userdata('cod_usuario'); 

        $this->db->select('c.cod,t.titulacion_cod');
        $this->db->from('certificado c, certificado_has_titulacion t');
        $this->db->where('c.cod = t.certificado_cod');
        $this->db->where('c.cod_usuario',$cod_usuario); 
        $this->db->where('c.cod_tipo_cer',$tipo);        
        $this->db->where('c.baremado',$baremado); 
        if ($titulacion!==""){
        $this->db->where('t.titulacion_cod',$titulacion);             
        }  
        $this->db->group_by('c.cod');     
        $this->db->order_by('c.cod', 'desc'); 

        if($consulta= $this->db->get() ){

             return($consulta->result_array()); 
        }   else{

            return false;
        } 
   
          
        
    }


}
