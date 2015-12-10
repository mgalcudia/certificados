<div class= "container-fluid">
    <form role="form" action="<?= base_url("index.php/fichero/mostrar_tipo_certificado") ?>" method="post">
        <span class="text-danger"><?php if (isset($error)) echo $error; ?></span>
        <br/>
        <div class="row form-group">
            <div class=" col-xs-11 col-md-11">
                <label class="form-group">Tipo</label>
                <p><?= form_dropdown('tipo', $tipocertificado, set_value('tipo')); ?></p>
                <span class="help-block"><?= form_error('tipo') ?></span>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-xs-11 col-md-8">
                <label class="form-group ">Titulación</label>
                <?= $titulacion ?>
                <span class="help-block"><?= form_error('titulacion') ?></span>

                <p><label class="form-group ">Baremado</label></p>
                <div class="radio">
                    <p> <input type="radio" name="baremado" id="opciones_1" value="0" checked>No</p>
                    <p>  <input type="radio" name="baremado" id="opciones_1" value="1">Si</p>

                </div>
            </div>


            <br/>
        </div>
        <div class="row form-group">
            <button type="submit" class="btn btn-primary btn-md login">Enviar</button>
            <a class="btn btn-danger btn-md login pull-right" href="<?= base_url("index.php/fichero/mostrar_tipo_certificado") ?>">Cancelar </a>
        </div>

    </form>
</div>