<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class usuario_modelo extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     *  Función para insertar usuarios
     * @param type $data array de datos
     */
    function insertar_usuario($data) {
        //var_dump($data);
        $this->db->insert('usuario', $data);
    }

/**
 * Comprobar si el usuario existe por correo
 * @param  string   $data   correo electronico
 * @return array si es ok devuelve un array de dato
 */
    function existe_usuario($data) {
        var_dump($data);
        $this->db->where('mail', $data);
        $consulta = $this->db->get('usuario');

        if ($consulta->result()) {
            
            return true;
        } else {
         
            return false;
        }
    }


/**
 * Comprueba que el pass y el usuario es correcto para loguearse
 * @param  string   $mail   correo electronico
 * @param  string   $pasword    contraseña
 * @return bool true si es ok
 */
    function loginok($mail, $pasword) {

        $sql = "select * from usuario where mail = '" . $mail . "' AND pasword = '" . $pasword . "' AND activo = '1'";

        $query = $this->db->query($sql);

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return true;
        }
    }



/**
 * Comprobar si el usuario existe por correo
 * @param  string   $data   correo electronico
 * @return array si es ok devuelve un array de dato
 */
    function existe_mail($data) {
        //var_dump($data);
        $this->db->where('mail', $data);
        $consulta = $this->db->get('usuario');

        if ($consulta->result()) {

            return $consulta->row_array();
        } else {
            return false;
        }
    }


/**
 * Comprueba si el usuario esta activo
 * @param  string   $data   correo electronico
 * @return bool true si es ok
 */
    function usuario_activo($data){

        $this->db->where('mail', $data);
        $this->db->where('activo', '1');
        $consulta=$this->db->get('usuario');
        
        if($consulta->result()){
            return true;

        }else{
            return false;

        }



    }

    /**
     * Busca clientes por diversos criterios
     * recogidos en $datos
     * @param type $datos
     * @return type
     */
    function buscar_usuario($datos) {
        $this->db->where($datos);
        $query = $this->db->get('usuario');
        return $query->row_array();
    }

    /**
     * Edita los datos del cliente con id=$id
     * actualizando sus datos con $datos
     * @param type $id
     * @param type $datos
     */
    function editar_usuario($id, $datos) {

        $this->db->where('cod', $id);

        if ($this->db->update('usuario', $datos)) {
            return true;
            var_dump("dentro");
        } else {

            return false;
        }
    }

    /**
     * Da de baja el cliente 
     * pero no lo elimina
     * 
     */
    function baja_usuario($cod) {
        $datos = array(
            'activo' => 0
        );
        $this->db->where('cod', $cod);
        $this->db->update('usuario', $datos);
    }

}
