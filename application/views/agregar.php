<br/>
<form role="form" action="<?= base_url('index.php/fichero/agregar_fichero') ?>" method="post">

    <input type="hidden" id="cod" class="form-control" name="cod" value="<?= $cod; ?>"/>

    <div class="form-group">
        <label class="form-group">Nombre</label>
        <input type="text" id="curso" class="form-control" name="curso" value="<?= set_value('curso'); ?>" placeholder="Nombre titulacion" />
        <span class="help-block"><?= form_error('curso') ?></span>        
    </div>
    <div class="row form-group">
        <div class=" col-xs-11 col-md-4 ">
            <label class="form-group">Horas</label>
            .<input type="text" id="hora" class="form-control" name="hora" value="<?= set_value('hora'); ?>" placeholder="horas" />
            <span class="help-block"><?= form_error('hora') ?></span>

        </div>
        <div class=" col-xs-11 col-md-3">
            <label class="form-group">Corte</label>
            <input type="text" id="corte" class="form-control" name="corte" value="<?= set_value('corte'); ?>" placeholder="Año del corte" />
            <span class="help-block"><?= form_error('corte') ?></span>
        </div>
        <div class=" col-xs-11 col-md-5">
            <label class="form-group">Fecha título</label>
            <p> <input type="date" id="fecha" class="form-control" name="fecha" value="<?= set_value('fecha'); ?>" placeholder="fecha de obtencion"/></p>
            <span class="help-block"><?= form_error('fecha') ?></span>
        </div>


    </div>
    <div class="row form-group">
        <div class="col-xs-11 col-md-5">
            <label class="control-label">Agrega el certificado</label>
            <input  type="file" id="subir_fichero" name="fichero">
        </div>
        <div class=" col-xs-11 col-md-3">
            <label class="form-group">Tipo</label>
            <p><?=form_dropdown('tipo', $tipocertificado, set_value('tipo'));?></p>
            <span class="help-block"><?= form_error('tipo') ?></span>
        </div>
        <div class=" col-xs-11 col-md-4 dropdown ">
            <label class="form-group ">Entidad</label>
            <p> <?= form_dropdown('entidad', $emisor, set_value('entidad')); ?></p>
            <span class="help-block"><?= form_error('entidad') ?></span>
        </div>        
    </div>

    <div class="row form-group">
        <div class="col-xs-11 col-md-8">
            <label class="form-group ">Titulación</label>
            <?= $titulacion ?>

            <p><label class="form-group ">Baremado</label></p>
            <div class="radio">
                <p> <input type="radio" name="baremado" id="opciones_1" value="0" checked>No</p>
                <p>  <input type="radio" name="baremado" id="opciones_1" value="1">Si</p>

            </div>
        </div>
        <div class=" col-xs-11 col-md-4">
            <form role = "form">

                <div class = "form-group">
                    <label for = "name">Obsevaciones</label>
                    <textarea class = "form-control" name="observaciones" rows = "4" placeholder="Escriba aqui......"></textarea>
                </div>


        </div>        
    </div>
    <br/>
    <div class="row form-group">
        <button type="submit" class="btn btn-primary btn-md login">Enviar</button>
        <a class="btn btn-danger btn-md login pull-right" href="<?= base_url("index.php/usuario/login") ?>">Cancelar </a>
    </div>
</form>

