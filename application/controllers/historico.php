<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require(__DIR__ . '/mi_controlador.php');

class historico extends mi_controlador {

    function __construct() {
        parent::__construct();
    }

    /**
     * Muestra los cursos asignados a cada año de corte
     * @param  string   $year   año del corte
     * @return string los cursos pasados por parametos a la plantilla
     */
    function mostrar_historico($year = "") {
        $cod_usuario = $this->session->userdata('cod_usuario');
        if (!$cod_usuario) {
            redirect(site_url());
        }
        $cuerpo = "";
        //$year= $this->historico_modelo->year_corte();
        $mensaje['mensaje'] = "Certificados presentados corte " . $year;
        $aviso = $this->load->view('mensaje', $mensaje, TRUE);
        $cod_curso = $this->historico_modelo->cursos_corte($year);

        // print_r($cod_curso);

        foreach ($cod_curso as $key => $value) {

            foreach ($value as $valor) {

                //  print_r($valor."<br/>");
                $cuerpo.= $this->mostrar_titulo($valor);
            }
        }

        $this->plantilla($aviso . $cuerpo);
    }

}
