<!-- ======================================== -->
<!-- ======================================== -->
<!-- ======================================== -->
<div class="container">

    <div class="buscador">
        <aside>
            <div class="noticias linea">
                <h3>Buscador</h3>
            </div>
            <div class="formulario col-xs-9 col-md-9 ">
                <input type="text" name="autocompletar" id="autocompletar" class="form-control" placeholder="Buscar...." />
            </div>


            <div class="formulario">
                <br/>
                <div class="contenedor" id="contenedor"></div>
            </div>
    </div>
    <div class="espacio"></div>
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