<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class emisor_certificado extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function listar_emisor() {

        $resultado = "select * from emisor";
        $resultado = $this->db->query($resultado);

        if ($resultado->num_rows() > 0) {
            foreach ($resultado->result() as $fila) {

                $emisor[$fila->cod] = $fila->nombre;
                $resultado->free_result();
            }
            $seleccionar[0] = 'Seleccionar';
            array_push($seleccionar, $emisor);
            return $emisor;
        }
    }

    function listar_tipo() {

        $resultado = "select * from tipo_certificado";
        $resultado = $this->db->query($resultado);

        if ($resultado->num_rows() > 0) {
            foreach ($resultado->result() as $fila) {

                $emisor[$fila->cod] = $fila->tipo;
                $resultado->free_result();
            }

            return $emisor;
        }
    }

    function listar_tipo_emisor() {

        $resultado = "select * from tipo_emisor";
        $resultado = $this->db->query($resultado);

        if ($resultado->num_rows() > 0) {
            foreach ($resultado->result() as $fila) {

                $emisor[$fila->cod] = $fila->tipo;
                $resultado->free_result();
            }

            return $emisor;
        }
    }

}
