console.log("lo lee");
function quitarReadOnly(id)
    {
    	
                        for (var i = 1; i <= id; i++)
                         {
                            if($("#id"+i).attr("readonly")){

                               $("#btnModificar").html('Cancelar modificar');
                                $("#id"+i).removeAttr("readonly");
                                $("#btnenviar").removeAttr('disabled');
                            }else{                                
                                $("#btnModificar").html('Modificar');
                                $("#id"+i).attr("readonly","readonly");
                                
                                if($('#pass').attr("type")=="hidden"){
                                    $("#btnenviar").attr('disabled','disabled');
                                }
                            }                          

                          }

    }


    function quitarhidden(){

        if($('#pass').attr("type")=="hidden"){

            $('#pass').attr("type", "text");
            $("#btnpass").html('Ocultar contraseña');
             $("#btnenviar").removeAttr('disabled');
                $("#btnenviar").removeAttr('disabled'); 
             

        }else{
            
           
             $('#pass').attr("type", "hidden");
             $("#btnpass").html('Modificar contraseña');
             if($("#id"+1).attr("readonly")=="readonly"){               
             $("#btnenviar").attr('disabled','disabled');
                         }
        }
    }



