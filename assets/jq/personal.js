console.log("lo lee");
function quitarReadOnly(id)
    {
    	
                        for (var i = 1; i <= id; i++)
                         {
                            if($("#id"+i).attr("readonly")){

                               //  $("#btnModificar").prop("value","Cancelar modificar");
                               $("#btnModificar").html('Cancelar modificar');
                                $("#id"+i).removeAttr("readonly");

                            }else{

                                $("#btnModificar").html('Modificar');
                                $("#id"+i).attr("readonly","readonly");

                            }                          

                          }

    }


    function quitarhidden(){


     

        if($('#pass').attr("type")=="hidden"){

            console.log('hidden');
            $('#pass').attr("type", "text");
            $("#btnpass").html('Ocultar contraseña');

        }else{

            console.log('text');
             $('#pass').attr("type", "hidden");
             $("#btnpass").html('Modificar contraseña');
        }

   // $('#pass').attr("type", "text");
/*
    if($('#pass').attr("type[]")){

        $('#pass').attr("type", "text");
        console.log("texto");
    }else{

        $('#pass').attr("type", "hidden");
        console.log("no texto");



    }

*/
  
           //$("#formulariomayores").css("display", "none");
    
/*

        if($('#pass').attr("text")){
            console.log("entro");
            $('#pass').attr("type", "hidden");

        }else{
            console.log("else");
            

        }
*/
    }



