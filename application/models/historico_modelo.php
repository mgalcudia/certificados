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

    /**
     * Funcion para obtener los años de corte de casa usuario
     * @brief 
     * @return  año de cada corte de los curso
     */
    function year_corte() {
        $cod_usuario = $this->session->userdata('cod_usuario');
        $this->db->select('h.corte');
        $this->db->from('certificado c,historico h');
        $this->db->where('c.cod_usuario', $cod_usuario);
        $this->db->where('c.cod = h.certificado_cod');
        $this->db->group_by('h.corte');
        $this->db->order_by('h.corte', 'desc');
        $consulta = $this->db->get();
        // $consulta->result_array();
        return($consulta->result_array());
    }

/**
 * certificado relacionado con los años de corte
 * @param  string   $year   año del corte
 * @return array array de datos de los certificados
 */
    function cursos_corte($year) {

        $cod_usuario = $this->session->userdata('cod_usuario');
        $this->db->select('h.certificado_cod');
        $this->db->from('certificado c,historico h');
        $this->db->where('c.cod_usuario', $cod_usuario);
        $this->db->where('c.cod = h.certificado_cod');
        $this->db->where('h.corte', $year);
        $this->db->order_by('c.cod_tipo_cer', 'desc');
        $consulta = $this->db->get();

        return($consulta->result_array());
    }

/**
 * borrar los datos de los certificado en el historico
 * @param  array    $datos  para borrar en el historico
 */
    function borrar_historico($datos) {

        $this->db->delete('historico', $datos);
    }

}
