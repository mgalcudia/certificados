<!-- ======================================== -->
<!-- ======================================== -->
<!-- ======================================== -->
<br/>
<br/>
<div class="container">


        


        <div class="row-fluid">
            <div class="col-xs-11 col-md-6" id="buscador">            
           <h3> <p class="text-primary text-center line-height">Escriba el título del certificado</p></h3>  

                <input type="search" name="autocompletar" id="autocompletar" class="form-control" placeholder="Buscar...." />
               <div class=" contenedor" id="contenedor"> </div>                 
            </div>
                          
            

        </div>
    </div>
<script type="text/javascript">

    $("#autocompletar").on('keyup', function () {
        var info = $(this).val();
        $.ajax({
            type: 'POST',
            url: "<?= site_url('fichero/autocompletar'); ?>",
            data: {info: info},
            success: function (data) {
                event.preventDefault();
                $('#contenedor').html(data)
            }

        });
    });
</script>
<!-- ======================================== -->
<!-- ======================================== -->
<!-- ======================================== -->
