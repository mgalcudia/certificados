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
 * Edita los certificado de cada usuario
 * @param  string $cod   codigo de certificado
 * @param  array $datos  array de datos
 * @return bool          
 */
    function editar_certificado($cod, $datos) {

        $cod_usuario = $this->session->userdata('cod_usuario');
        $this->db->where('cod_usuario', $cod_usuario);
        $this->db->where('cod', $cod);
        if ($this->db->update('certificado', $datos)) {
            return true;
        } else {
            return false;
        }
    }

/**
 * Inserta los codigo de los certificado
 * @param  [type] $hitorico [description]
 * @return [type]           [description]
 */
    function insertar_historico($hitorico) {

        if ($this->db->insert('historico', $hitorico)) {

            return true;
        } else {
            return false;
        }
    }

    /**
     * Busca certificado por diversos criterios
     * recogidos en $datos
     * @param array $datos
     * @return array de los datos de un certificado
     */
    function buscar_certificado($datos) {

        $cod_usuario = $this->session->userdata('cod_usuario');
        $this->db->where('cod_usuario', $cod_usuario);
        $this->db->where($datos);
        $query = $this->db->get('certificado');
        return $query->row_array();
    }

/**
 * Modifica los datos de un certificado
 * @param  string $cod  codigo de certificado
 * @param  array  $data  datos a modificados del certificado
 * @return bool      
 */
    function modificar_certificado($cod, $data) {

        $cod_usuario = $this->session->userdata('cod_usuario');
        $this->db->where('cod_usuario', $cod_usuario);
        $this->db->where('cod', $cod);
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
    function buscar_varios_certificados($datos) {
        
        $cod_usuario = $this->session->userdata('cod_usuario');
        $this->db->select('cod');
        $this->db->from('certificado');
        $this->db->where($datos);
        $this->db->where('cod_usuario', $cod_usuario);
        $query = $this->db->get();
        return $query->result_array();
    }

/**
 * Obtiene cursos filtrados por titulacion
 * 
 * @param  string $tipo       tipo de certificado
 * @param  string $titulacion [description]
 * @param  string $baremado   [description]
 * @return [type]             [description]
 */
    function certificado_tiulacion($tipo = "", $titulacion = "", $baremado = "") {

        $cod_usuario = $this->session->userdata('cod_usuario');
        $this->db->select('c.cod');
        $this->db->from('certificado c, certificado_has_titulacion t');
        $this->db->where('c.cod = t.certificado_cod');
        $this->db->where('c.cod_usuario', $cod_usuario);

        if ($tipo != "") {
            $this->db->where('c.cod_tipo_cer', $tipo);
        }

        $this->db->where('c.baremado', $baremado);
        if ($titulacion !== "") {
            $this->db->where('t.titulacion_cod', $titulacion);
        }
        $this->db->group_by('c.cod');
        $this->db->order_by('c.cod', 'desc');
        //$this->db->order_by($orde, 'desc'); 
        if ($consulta = $this->db->get()) {

            return($consulta->result_array());
        } else {

            return false;
        }
    }

/**
 *  Borrar certificado
 * @param  array  $datos datos del certificado a eliminar
 */
    function borrar_certificado($datos) {
        $cod_usuario = $this->session->userdata('cod_usuario');
        $this->db->where('cod_usuario', $cod_usuario);
        $this->db->delete('certificado', $datos);
    }

/**
 * funcion para buscar certificad filtrado por el nombre
 * @param  string $cadena parte del nombre del certificado
 * @return array         certificado que corresponden a esa parte del nombreS
 */
    public function search($cadena) {
        $cod_usuario = $this->session->userdata('cod_usuario');
       
        $this->db->where('cod_usuario', $cod_usuario);
        $this->db->like('nombre', $cadena, 'both');
        /*
        $this->db->or_like('nombre', $cadena, 'before');
                $this->db->where('cod_usuario', $cod_usuario);
        $this->db->or_like('nombre', $cadena, 'after');
                $this->db->where('cod_usuario', $cod_usuario);
                */
        $consulta = $this->db->get('certificado');

        if ($consulta->num_rows() > 0) {
            // return $consulta->result();

            return $consulta->result_array();
        } else {
            return FALSE;
        }
    }

}
