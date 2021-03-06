<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class titulacion extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

/**
 * Listar titulaciones
 * @return array titulaciones
 */
    function listar_titulacion() {

        $resultado = "select * from titulacion";
        $resultado = $this->db->query($resultado);

        if ($resultado->num_rows() > 0) {
            foreach ($resultado->result() as $fila) {

                $emisor[$fila->cod] = $fila->titulacion;
                // $resultado->free_result();
            }

            return $emisor;
        }
    }


/**
 * Inserta en la tabla certificado_has_titulacion el curso relacionado con sus titulaciones
 * @param  string    $cod_curso  codigo de certificado
 * @param  array    $titulaciones   codigo de titulaciones 
 * @return [type]               [description]
 */
    function insertar_titulacion_a_titulo($cod_curso, $titulaciones) {
        $datos['certificado_cod'] = $cod_curso;

        foreach ($titulaciones['titulacion_cod'] as $clave) {

            $datos['titulacion_cod'] = $clave;
            $this->db->insert('certificado_has_titulacion', $datos);
        }
    }

/**
 * modifica la titulacion relacionado con el certificado
 * @param  [type] $cod_curso    [description]
 * @param  [type] $titulaciones [description]
 * @return [type]               [description]
 */
    function modificar_titulacion_a_titulo($cod_curso, $titulaciones) {

        $datos['certificado_cod'] = $cod_curso;

        $this->db->delete('certificado_has_titulacion', $datos);
        $this->insertar_titulacion_a_titulo($cod_curso, $titulaciones);
    }

    /**
     * Busca titulaciones en "certificado_has_titulacion" asociadas a certificados
     * recogidos en $datos 
     * @param type $datos codigo del certificado
     * @return type
     */
    function buscar_titulacion($datos) {
        $codigo['certificado_cod'] = $datos['cod'];
        $this->db->select('titulacion_cod');
        $this->db->where($codigo);
        $query = $this->db->get('certificado_has_titulacion');
        $resultado = $query->result_array();

        foreach ($resultado as $key => $value) {
            $result[] = $value['titulacion_cod'];
        }

        return $result;
    }

    /**
     * Busca titulaciones en "certificado_has_titulacion" asociadas a certificados
     * recogidos en $datos 
     * @param type $datos codigo del certificado
     * @return type
     */
    function buscar_nombre_titulacion($datos) {

        $nombre = "";
        $codigo['certificado_cod'] = $datos['cod'];
        $this->db->select('titulacion_cod');
        $this->db->where($codigo);
        $query = $this->db->get('certificado_has_titulacion');
        $resultado = $query->result_array();
        //   print_r($datos['cod']);
        foreach ($resultado as $key => $value) {
            //$result['cod']+=$value['titulacion_cod'];
            $result['cod'] = $value['titulacion_cod'];

            $nombre[] = $this->nombre_titulacion($result);
        }

        return $nombre;
    }

/**
 * obtiene el nombre de la titulacion
 * @param  array    $datos  codigo de las titulaciones
 * @return nombre nobre de la titulacion
 */
    function nombre_titulacion($datos) {

        $this->db->select('titulacion');
        $this->db->where($datos);
        $query = $this->db->get('titulacion');
        $resultado = $query->row_array('titulacion');
        return $resultado['titulacion'];
    }

/**
 * borra los datos de las titulaciones en la tabla que relaciona las titulaciones a los certificados
 * @param  array    $datos  [description]
 * @return [type]        [description]
 */
    function borrar_titulaciones_certificado($datos) {

        $this->db->delete('certificado_has_titulacion', $datos);
    }

}
