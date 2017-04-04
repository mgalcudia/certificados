<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require(__DIR__ . '/mi_controlador.php');

class fichero extends mi_controlador {

    function __construct() {
        parent::__construct();
    }

    /**
     * Comprueba para el form_validation que se ha seleccionado al menos una titulacion
     * @param  array $titulacion array de titulaciones
     * @return bool             true si selecciona alguna false si no seleccionado
     */
    function valida_titulacion($titulacion) {


        if (is_array($titulacion) && count($titulacion) > 0) {

            foreach ($titulacion as $key => $value) {

                if (isset($value)) {

                    return true;
                } else {

                    return FALSE;
                }
            }
        } else {

            return FALSE;
        }
    }

    /**
     * Comprueba la fecha pra el form_validation
     * @param  date $input   dd-mm-yyyy
     * @return bool          true si es ok y false si no
     */
    function fecha($input) {



        $input_array = explode("-", $input);

        if (count($input_array) == 3) {

            if (checkdate((int) $input_array[1], $input_array[0], $input_array[2])) {



                return true;
            } else {

                return false;
            }
        } else {

            return false;
        }
    }

    /**
     * Agrega los datos del certificado a subir y sube el fichero al servidor
     * @return [type] [description]
     */
    function agregar_fichero() {
        $cod_usuario = $this->session->userdata('cod_usuario');
        if (!$cod_usuario) {
            redirect(site_url());
        }
        $this->form_validation->set_rules('curso', 'curso', 'trim|required');
        $this->form_validation->set_rules('hora', 'hora', 'trim|is_natural');
        $this->form_validation->set_rules('corte', 'corte', 'trim|required|exact_length[4]|is_natural');
        $this->form_validation->set_rules('fecha', 'fecha', 'trim|required|callback_fecha');
        $this->form_validation->set_rules('tipo', 'tipo', 'trim|required');
        $this->form_validation->set_rules('entidad', 'entidad', 'trim|required');
        $this->form_validation->set_rules('titulacion', 'titulacion', 'required |callback_valida_titulacion');

        if (empty($_FILES['fichero']['name'])) {
            $this->form_validation->set_rules('fichero', 'fichero', 'required');
        }
        if ($this->form_validation->run() == FALSE) {

            $mail_usuario['mail'] = $this->session->userdata('usuario');
            $datos = $this->usuario_modelo->buscar_usuario($mail_usuario);
            //Si no existe la carpeta con el id del usuario se genera
            if (!file_exists(APPPATH . "../almacen/" . $datos['cod'])) {
                $carpeta = APPPATH . "../almacen/" . $datos['cod'];
                mkdir($carpeta, 0777);
            }
            $data['cod'] = $datos['cod'];
            $data['emisor'] = $this->emisor_certificado->listar_emisor();
            $data['tipocertificado'] = $this->emisor_certificado->listar_tipo();
            $data['titulacion'] = $this->crea_no_selected();
            $data['error'] = $this->session->flashdata('error');
            $cuerpo = $this->load->view('agregar', $data, TRUE);

            $mensaje['mensaje'] = "Agregar certificado";
            $aviso = $this->load->view('mensaje', $mensaje, TRUE);
            $this->plantilla($aviso . $cuerpo);
        } else {

            $datos['cod_usuario'] = $this->input->post('cod');
            $datos['nombre'] = $this->input->post('curso');
            $datos['horas'] = $this->input->post('hora');
            $datos['corte'] = $this->input->post('corte');
            $datos['fecha'] = $this->input->post('fecha');
            $datos['cod_tipo_cer'] = $this->input->post('tipo');
            $datos['emisor_cod'] = $this->input->post('entidad');
            $titulaciones['titulacion_cod'] = $this->input->post('titulacion');
            $datos['observaciones'] = $this->input->post('observaciones');
            $datos['baremado'] = $this->input->post('baremado');
            $datos['ruta'] = APPPATH . "../almacen/" . $datos['cod_usuario'];


            //conversion de fecha para subir al servidor
            $datos['fecha'] = $this->formato_fecha_subir($datos['fecha']);

            $cod_curso = $this->fichero_modelo->insertar_certificado($datos);

            $this->titulacion->insertar_titulacion_a_titulo($cod_curso, $titulaciones);
            $hitorico = array(
                'corte' => $datos['corte'],
                'certificado_cod' => $cod_curso
            );
            $this->fichero_modelo->insertar_historico($hitorico);

            $this->do_upload($datos['cod_usuario'], $cod_curso);
        }
    }

    /**
     * Funcion para subir certificados al servidor 
     * @param string $cod_usuario
     * @param string $cod_curso
     */
    function do_upload($cod_usuario, $cod_curso) {


        $config['file_name'] = $cod_curso . '.pdf';
        $config['upload_path'] = APPPATH . "../almacen/" . $cod_usuario . "/";
        $config['allowed_types'] = 'pdf';
        $config['remove_spaces'] = TRUE;
        $config['max_size'] = '2048';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('fichero')) {
            $this->session->set_flashdata('error', 'Error al Subir el fichero');
        } else {
            $data['error'] = 'Fichero subido';


            $cuerpo = $this->mostrar_titulo($cod_curso);
            $this->plantilla($cuerpo);
        }
    }

    /**
     * Elimina un certificado
     * @param  string $cod codigo del certificado
     * @return manda a la vista donde selecciona el filtro para ver los certificados
     */
    function eliminar_certificado($cod = "") {

        $datos['cod'] = $cod;

        $cod_usuario = $this->session->userdata('cod_usuario');
        if (!$cod_usuario) {
            redirect(site_url());
        }

        $dir = APPPATH . "../almacen/" . $cod_usuario . "/" . $cod . '.pdf';
        ;
        //puedes usar dobles comillas si quieres 

        if (file_exists($dir)) {
            if (unlink($dir)) {

                $this->titulacion->borrar_titulaciones_certificado(array('certificado_cod' => $datos['cod']));
                $this->historico_modelo->borrar_historico(array('certificado_cod' => $datos['cod']));
                $this->fichero_modelo->borrar_certificado(array('cod' => $datos['cod']));
                // $this->fichero_modelo->borrar_certificado($cod);

                $this->session->set_flashdata('error', 'El certificado fue borrado');
            } else {

                $this->session->set_flashdata('error', 'El certificado no fue borrado');
            }
        } else {

            $this->session->set_flashdata('error', 'El certificado no existe');
        }

        $data['error'] = $this->session->flashdata('error');
        redirect(site_url('/fichero/mostrar_enlaces_editar'));
    }

    /**
     * Funcion para modificar un titulo
     *
     * @param type $cod codigo del curso
     */
    function modificar_titulo($cod = '') {

        $cod_usuario = $this->session->userdata('cod_usuario');

        if (!$cod_usuario) {
            redirect(site_url());
        }
        $datos['cod'] = $cod;
        $this->form_validation->set_rules('curso', 'curso', 'trim|required');
        $this->form_validation->set_rules('hora', 'hora', 'trim|is_natural');
        $this->form_validation->set_rules('corte', 'corte', 'trim|required|exact_length[4]|is_natural');
        $this->form_validation->set_rules('fecha', 'fecha', 'trim|required|callback_fecha');
        $this->form_validation->set_rules('tipo', 'tipo', 'trim|required');
        $this->form_validation->set_rules('entidad', 'entidad', 'trim|required');
        $this->form_validation->set_rules('titulacion', 'titulacion', 'required |callback_valida_titulacion');

        $mail_usuario['mail'] = $this->session->userdata('usuario');

        $cod_usuario = $this->usuario_modelo->buscar_usuario($mail_usuario);
        $data = $this->fichero_modelo->buscar_certificado($datos);

        $val = $this->titulacion->buscar_titulacion($datos);
        $data['titulacion'] = $this->creaSelect($val);

        $data['fecha'] = $this->formato_fecha_bajar($data['fecha']);

        if ($this->form_validation->run() == FALSE) {

            if ($data['baremado']) {
                $data['si'] = 'checked';
                $data['no'] = '';
            } else {
                $data['si'] = '';
                $data['no'] = 'checked';
            }


            $data['emisor'] = $this->emisor_certificado->listar_emisor();
            $data['tipocertificado'] = $this->emisor_certificado->listar_tipo();
            $data['error'] = $this->session->flashdata('error');

            $cuerpo = $this->load->view('modificar_fichero', $data, TRUE);
            $mensaje['mensaje'] = "Modificar certificado";
            $aviso = $this->load->view('mensaje', $mensaje, TRUE);
            $this->plantilla($aviso . $cuerpo);
        } else {

            $cod = $this->input->post('cod');

            $datos['cod_usuario'] = $this->input->post('cod_user');
            $datos['nombre'] = $this->input->post('curso');
            $datos['horas'] = $this->input->post('hora');
            $datos['corte'] = $this->input->post('corte');
            $datos['fecha'] = $this->input->post('fecha');
            $datos['cod_tipo_cer'] = $this->input->post('tipo');
            $datos['emisor_cod'] = $this->input->post('entidad');
            $titulaciones['titulacion_cod'] = $this->input->post('titulacion');
            $datos['observaciones'] = $this->input->post('observaciones');
            $datos['baremado'] = $this->input->post('baremado');

            $datos['ruta'] = APPPATH . "../almacen/" . $datos['cod_usuario'];

            //si se modifica el certificado
            //conversion de fecha para subir al servidor
            $datos['fecha'] = $this->formato_fecha_subir($datos['fecha']);


            if ($this->fichero_modelo->modificar_certificado($cod, $datos)) {


                $this->titulacion->modificar_titulacion_a_titulo($cod, $titulaciones);
                if ($data['corte'] != $datos['corte']) {
                    //  print_r('entro'.$datos['corte']);
                    $hitorico = array(
                        'corte' => $datos['corte'],
                        'certificado_cod' => $cod
                    );
                    $this->fichero_modelo->insertar_historico($hitorico);
                }

                if ($_FILES['fichero']['size'] > 0) {

                    $dir = $datos['ruta'] . "/" . $cod . '.pdf';


                    if (file_exists($dir)) {
                        chmod($dir, 0777);
                        if (unlink($dir)) {

                            $this->do_upload($datos['cod_usuario'], $cod);
                        }
                    } else {

                        $this->do_upload($datos['cod_usuario'], $cod);
                    }
                } else {

                    $cuerpo = $this->mostrar_titulo($cod);
                    $this->plantilla($cuerpo);
                }
            } else {
                $this->session->set_flashdata('error', 'Error al modificar el fichero');
                redirect(site_url('index.php/fichero/modificar_titulo' . $cod));
            }
        }
    }

    /**
     * Funcion para mostrar los enlaces de las opciones para buscar los certificados y editarlos
     * @param string $value parametro para filtrar la opcion seleccionada por el usuario
     * @return plantilla para mostrar cursos o pantalla de seleccion de filtro
     */
    function mostrar_enlaces_editar($value = '') {

        $data['error'] = $this->session->flashdata('error');

        if (!$this->session->userdata('cod_usuario')) {
            redirect(site_url());
        }
        $aviso = "";
        switch ($value) {

            case "nobaremado":

                $consulta = array(
                    'cod_usuario' => $this->session->userdata('cod_usuario'),
                    'baremado' => 0
                );
                $mensaje['mensaje'] = "Cursos no baremados";
                $aviso = $this->load->view('mensaje', $mensaje, TRUE);
                $cuerpo = $this->mostrar_estado_baremado($consulta);

                break;
            case "baremado":
                $consulta = array(
                    'cod_usuario' => $this->session->userdata('cod_usuario'),
                    'baremado' => 1
                );
                $mensaje['mensaje'] = "Cursos baremados";
                $aviso = $this->load->view('mensaje', $mensaje, TRUE);
                $cuerpo = $this->mostrar_estado_baremado($consulta);
                break;
            case "tipo":
                $mensaje['mensaje'] = "Cursos por tipo de certificado";
                $aviso = $this->load->view('mensaje', $mensaje, TRUE);
                $cuerpo = $this->mostrar_tipo_certificado();

                break;
            case "titulacion":
                $mensaje['mensaje'] = "Cursos por tipo de titulación";
                $aviso = $this->load->view('mensaje', $mensaje, TRUE);
                $cuerpo = $this->mostrar_tipo_titulacion();

                break;
            case "nombre":
                $mensaje['mensaje'] = "Cursos por nombre del certificado";
                $aviso = $this->load->view('mensaje', $mensaje, TRUE);
                $cuerpo = $this->view_autocompletar();

                break;
            default:
                $mensaje['mensaje'] = "Seleccione la opcion para buscar los certificados";
                $aviso = $this->load->view('mensaje', $mensaje, TRUE);
                $cuerpo = $this->load->view('mostrar_enlaces_editar', $data, TRUE);
                break;
        }

        $this->plantilla($aviso . $cuerpo);
    }

    /**
     * Muestra los certificados baremados o no baremados
     * @param  string $consulta recibe "baremado =>1" o "nobaremado=>0"
     * @return string            cuerpo para mostrar
     */
    function mostrar_estado_baremado($consulta) {
        $cod_usuario = $this->session->userdata('cod_usuario');
        if (!$cod_usuario) {
            redirect(site_url());
        }
        $cuerpo = "";
        $datos = $this->fichero_modelo->buscar_varios_certificados($consulta);
        foreach ($datos as $key => $value) {

            foreach ($value as $valor) {

                $cuerpo.= $this->mostrar_titulo($valor);
            }
        }

        return $cuerpo;
    }

    /**
     * Muestra los certificados depentiendo del tipo que sean , el tipo titulacion es un parametro opcional
     * @return certificados a mostrar o redirige si la consulta no tiene resultados
     */
    function mostrar_tipo_certificado() {

        $cod_usuario = $this->session->userdata('cod_usuario');
        if (!$cod_usuario) {
            redirect(site_url());
        }
        $this->form_validation->set_rules('tipo', 'tipo', 'trim|required');
        // $this->form_validation->set_rules('titulacion', 'titulacion', 'required |callback_valida_titulacion');

        if ($this->form_validation->run() == FALSE) {

            $data['error'] = $this->session->flashdata('error');
            $data['titulacion'] = $this->crea_no_selected();
            $data['tipocertificado'] = $this->emisor_certificado->listar_tipo();
            return $this->load->view('formulario_mostrar_portitulo', $data, TRUE);
            // $this->plantilla($cuerpo);
        } else {

            //$cuerpo="";
            $consulta = array();
            $cod_tipo_cer = $this->input->post('tipo');
            $titulacion_cod = $this->input->post('titulacion');
            $baremado = $this->input->post('baremado');
            //  print_r($cod_tipo_cer);
            //$titulacion="1";

            if (isset($titulacion)) {
                foreach ($titulacion_cod as $key => $titulacion) {
                    $consulta[] = $this->fichero_modelo->certificado_tiulacion($cod_tipo_cer, $titulacion, $baremado);
                }
            } else {
                $consulta[] = $this->fichero_modelo->certificado_tiulacion($cod_tipo_cer, $titulacion = "", $baremado);
            }


            foreach ($consulta as $key => $value) {

                if (count($value) > 0) {


                    $this->recorre_array_consulta($consulta, "tipo");
                } else {


                    $this->session->set_flashdata('error', 'No existen datos para esa consulta, realice otra');
                    redirect(site_url() . '/fichero/mostrar_enlaces_editar/tipo');
                }
            }
        }
    }

    /**
     * funcion que recibiendo un array con codigos de certificados los gestiona para mostrarlos evitando que se repitan
     * @param  array $consulta  array de certificados
     * @param  string $lugar    parametro que indica el filtro de donde se solicitaba la acción
     * @return string           cuerpo de certificados a mostrar
     */
    function recorre_array_consulta($consulta, $lugar) {

        $cuerpo = "";
        $procesado = array();

        foreach ($consulta as $key => $value) {



            if (count($value) > 0) {

                foreach ($value as $clave => $valor) {

                    //comprobamos que no repetimos el curso a mostrar
                    if (in_array($valor['cod'], $procesado)) {

                        $repetido[] = $valor['cod'];
                    } else {

                        $procesado[] = $valor['cod'];
                        $cuerpo.= $this->mostrar_titulo($valor['cod']);
                    }
                }
            } else {


                $this->session->set_flashdata('error', 'No existen datos para esa consulta, realice otra');
                redirect(site_url() . '/fichero/mostrar_enlaces_editar/' . $lugar);
            }
        }


        $this->plantilla($cuerpo);
    }

    /**
     * Funcion para mostrar los certificados asignados por titulacion
     * @return array codigos de cursos
     */
    function mostrar_tipo_titulacion() {
        $cod_usuario = $this->session->userdata('cod_usuario');
        if (!$cod_usuario) {
            redirect(site_url());
        }


        if ($this->input->post()) {

            if ($this->input->post('titulacion')) {

                $titulacion_cod = $this->input->post('titulacion');
                $baremado = $this->input->post('baremado');


                foreach ($titulacion_cod as $key => $titulacion) {

                    $consulta[] = $this->fichero_modelo->certificado_tiulacion($cod_tipo_cer = "", $titulacion, $baremado);
                }

                $this->recorre_array_consulta($consulta, "titulacion");
            } else {

                $this->session->set_flashdata('error', 'El campo titulacion es obligatorio, seleccione uno');
                redirect(site_url() . '/fichero/mostrar_enlaces_editar/titulacion');
            }
        } else {
            $data['error'] = $this->session->flashdata('error');
            $data['titulacion'] = $this->crea_no_selected();
            return $this->load->view('formulario_mostrar_portitulacion', $data, TRUE);
        }
    }

    /**
     * vista autocompletar usando ajax
     * @return string vista de la funcion pedida
     */
    public function view_autocompletar() {

        $datos['title'] = 'Buscador';
        $datos['contenido'] = 'autocompletado';
        return $this->load->view('planilla', $datos, TRUE);
    }

    /**
     * Recibe la peticion ajax y le devuelve el resultado
     * @return string enlace a mostrar el curso
     */
    public function autocompletar() {

        $cuerpo = "";
        if ($this->input->is_ajax_request() && $this->input->post('info')) {

            $abuscar = $this->security->xss_clean($this->input->post('info'));
            $search = $this->fichero_modelo->search($abuscar);

            if ($search !== FALSE) {

                echo '<div class="list-group">';
                foreach ($search as $fila) {
                    echo '<a href="' . site_url() . '/fichero/mostrar_un_curso/' . $fila['cod'] . ' " class="list-group-item" >';

                    echo '<h4 class="list-group-item-heading">' . $fila['nombre'] . '</h4> </a>';
                }

                echo '</div>';
            } else {
                echo '<br/><p>No hay resultados</p>';
            }
        }
    }

    /**
     * muestra un curso
     * @param  string $cod codigo del cursos
     * @return string muestra el curso en el cuerpo
     */
    function mostrar_un_curso($cod = "") {

        $cuerpo = $this->mostrar_titulo($cod);

        $this->plantilla($cuerpo);
    }

    /**
     * busca los curso coincidentes con lo escrito en el campo del navbar
     * @return string muestra los cursos coindicentes enviados a la plantilla
     */
    function buscar_curso() {

        $cuerpo = "";


        $nombre = $this->input->post('busqueda');
        if($nombre ==""){
            $mensaje['mensaje'] = 'Todos los certificados'; 

        }else{
            $mensaje['mensaje'] = 'Certificados que contiene "' . $nombre . '"';

        }
        $cod_curso = $this->fichero_modelo->search($nombre);
        
        $aviso = $this->load->view('mensaje', $mensaje, TRUE);
        if ($cod_curso !== FALSE) {
            foreach ($cod_curso as $key => $value) {
                $cuerpo .= $this->mostrar_titulo($value['cod']);
            }
        } else {
            $mensaje['mensaje'] = '<br/><span class="text-danger">No hay resultados que contengan: "' . $nombre . '"</span>';
            $aviso = $this->load->view('mensaje', $mensaje, TRUE);
        }
        $this->plantilla($aviso . $cuerpo);
    }

////////////////////////////FIN//////////////////////////////
}
