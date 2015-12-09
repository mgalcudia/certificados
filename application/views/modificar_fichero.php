
<form role="form" action="<?= base_url().'index.php/fichero/modificar_titulo/'.$cod?>" enctype="multipart/form-data" method="post">

    <input type="hidden" id="cod" class="form-control" name="cod" value="<?= $cod; ?>"/>
     <input type="hidden" id="cod" class="form-control" name="cod_user" value="<?= $cod_usuario;?>"/>

    <div class="form-group">
        <label class="form-group">Nombre</label>
        <input type="text" id="curso" class="form-control" name="curso" value="<?=(set_value('curso'))?set_value('curso'):$nombre;?>" placeholder="Nombre titulacion" />
        <span class="help-block"><?= form_error('curso') ?></span>        
    </div>
    <div class="row form-group">
        <div class=" col-xs-11 col-md-4 ">
            <label class="form-group">Horas</label>
            .<input type="text" id="hora" class="form-control" name="hora" value="<?=(set_value('hora'))?set_value('hora'):$horas;?>" placeholder="horas" />
            <span class="help-block"><?= form_error('hora') ?></span>

        </div>
        <div class=" col-xs-11 col-md-3">
            <label class="form-group">Corte</label>
            <input type="text" id="corte" class="form-control" name="corte" value="<?=(set_value('corte'))?set_value('corte'):$corte;?>" placeholder="Año del corte" />
            <span class="help-block"><?= form_error('corte') ?></span>
        </div>
        <div class=" col-xs-11 col-md-5">
            <label class="form-group">Fecha título</label>
            <p> <input type="text" id="fecha" class="form-control" name="fecha" value="<?=(set_value('fecha'))?set_value('fecha'):$fecha;?>" placeholder="fecha de obtencion"/></p>
            <span class="help-block"><?= form_error('fecha') ?></span>
        </div>

    </div>
    <div class="row form-group">
        <div class="col-xs-11 col-md-5">
            <label class="control-label">Agrega el certificado</label>
            falta poner un boton para agregar el fichero
        </div>
        <div class=" col-xs-11 col-md-3">
            <label class="form-group">Tipo</label>
            <p><?=form_dropdown('tipo', $tipocertificado, (set_value('tipo'))?set_value('tipo'):$cod_tipo_cer);?></p>
            <span class="help-block"><?= form_error('tipo') ?></span>
        </div>
        <div class=" col-xs-11 col-md-4 dropdown ">
            <label class="form-group ">Entidad</label>
            <p> <?= form_dropdown('entidad', $emisor, (set_value('entidad'))?set_value('entidad'):$emisor_cod); ?></p>
            <span class="help-block"><?= form_error('entidad')?></span>
        </div>        
    </div>

    <div class="row form-group">
        <div class="col-xs-11 col-md-8">
            <label class="form-group ">Titulación</label>
            <?=$titulacion?>
            <span class="help-block"><?= form_error('titulacion[]')?></span>

            <p><label class="form-group ">Baremado</label></p>
            <div class="radio">
                <p> <input type="radio" name="baremado" id="opciones_1" value="0" checked="<?=$no;?>">No</p>
                <p>  <input type="radio" name="baremado" id="opciones_1" value="1"checked="<?=$si;?>" >Si</p>

            </div>
        </div>
        <div class=" col-xs-11 col-md-4">
            <form role = "form">

                <div class = "form-group">
                    <label for = "name">Obsevaciones</label>
                    <textarea class = "form-control" name="observaciones" value="asavebw" rows = "4" placeholder="Escriba aqui......"><?=(set_value('observaciones'))?set_value('observaciones'):$observaciones;?></textarea>
                </div>
        </div>        
    </div>
    <span class="text-danger"><?php if (isset($error)) echo $error; ?></span>
    <br/>
    <div class="row form-group">
        <button type="submit" class="btn btn-primary btn-md login">Enviar</button>
        <a class="btn btn-danger btn-md login pull-right" href="<?= base_url("index.php/usuario/login") ?>">Cancelar </a>
    </div>
</form>

