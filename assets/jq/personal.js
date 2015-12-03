console.log("lo lee");
function quitarReadOnly(id)
    {
    	
        // Eliminamos el atributo de solo lectura
       
        for (var i = 1; i <= id; i++) {
        	$("#id"+i).removeAttr("readonly");
        	console.log(i);
        }
        // Eliminamos la clase que hace que cambie el color
       // $("#"+id).removeClass("readOnly");
    }

    function quitarhidden(id){

    	$('#pass').attr("type", "text");

    }



    $("#autocompletar").on('keyup',function(){
    var info = $(this).val();
    $.ajax({
        type: 'POST',
        url: "<?php echo site_url('fichero/autocompletar'); ?>",
        data: {info: info},
        success: function (data) {
            event.preventDefault();
            $('#contenedor').html(data)
                }

    });
});