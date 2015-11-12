<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

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
    function insertar_usuario ($data){
        //var_dump($data);
       $this->db->insert('usuario',$data);

    }
    
    
        /**
     * Comprobar si el usuario existe
     */

    function existe_usuario($data){
        var_dump($data);
       $this->db->where('mail',$data);
       $consulta= $this->db->get('usuario');

       if($consulta->result()){
           var_dump('tiene');
           return true;

       }else{
           var_dump(' NO tiene');
           return false;
       }

    }
    
    
        function loginok($mail, $pasword){
            
		$sql = "select * from usuario where mail = '".$mail."' AND pasword = '".$pasword."' AND activo = '1'";
                
		$query = $this->db->query($sql);

		if($query->num_rows() == 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
    
    
    /**
     * Comprobar si el usuario existe por correo
     */

    function existe_mail($data){
        //var_dump($data);
       $this->db->where('mail',$data);
       $consulta= $this->db->get('usuario');

       if($consulta->result()){

           return $consulta->row_array();

       }else{
           return false;
       }

    }
    
         /**
     * Edita los datos del usuario con id=$id
     * actualizando sus datos con $datos
     * @param type $id
     * @param type $datos
     */
    function editar_cliente($id, $datos){
        $this->db->where('cod', $id);
        
        if($this->db->update('usuario', $datos)){
            return true;
            
        }  else {
        
            return false;
        }
    }

    
    
    
}
