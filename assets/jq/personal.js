console.log("lo lee");
/**
 * fucion  para poder editar los input type
 * @param  int id     el numero de campos recogido en su id
 * @return {[type]}    [description]
 */
function quitarReadOnly(id) {

    for (var i = 1; i <= id; i++)
    {
        if ($("#id" + i).attr("readonly")) {

            $("#btnModificar").html('Cancelar modificar');
            $("#id" + i).removeAttr("readonly");
            $("#btnenviar").removeAttr('disabled');
        } else {
            $("#btnModificar").html('Modificar');
            $("#id" + i).attr("readonly", "readonly");

            if ($('#pass').attr("type") == "hidden") {
                $("#btnenviar").attr('disabled', 'disabled');
            }
        }

    }

}

/**
 * Quita el hidden del boton de enviar
 * @return {[type]} [description]
 */
function quitarhidden() {

    if ($('#pass').attr("type") == "hidden") {

        $('#pass').attr("type", "password");
        $("#btnpass").html('Ocultar contraseña');
        $("#btnenviar").removeAttr('disabled');
        $("#btnenviar").removeAttr('disabled');


    } else {


        $('#pass').attr("type", "hidden");
        $("#btnpass").html('Modificar contraseña');
        if ($("#id" + 1).attr("readonly") == "readonly") {
            $("#btnenviar").attr('disabled', 'disabled');
        }
    }
}

/**
 * identifica si el buscador que utiliza el usuario es google chrome
 * @return {[type]} [description]
 */
function buscador(){
    
    if (navigator.userAgent.toLowerCase().indexOf('chrome') >-1)
  {

    if(navigator.appName.toLowerCase().indexOf('netscape') >-1){

    }else{

      $('#insertame-texto').html(        
       '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Atencion!</strong>\n\
         La aplicacion ha sido desarrollada para su uso con chrome.');

    }    

  }
 else{

     $('#insertame-texto').html(        
       '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Atencion!</strong>\n\
         La aplicacion ha sido desarrollada para su uso con chrome\n\
        algunas funcionalidades no funcionarán correctamente.</div>');
  }
    
}



