
<button class="btn btn-success btn-md " id="btnModificar" onclick="quitarReadOnly('6')">Modificar</button>
<button class="btn btn-success btn-md " id="btnpass" onclick=" quitarhidden()">Modificar contraseña</button>
<span class="text-danger"><?php if (isset($error)) echo $error; ?></span>
<form role="form" action="<?= base_url("index.php/usuario/editarusuario") ?>" method="post">
    <input type="hidden" name="cod" value="<?= $datos['cod'] ?>">
    <div class="form-group">
        <label class="control-label" for="nombre">Nombre</label>
        <input type="text" id="id1" readonly="readonly" class="form-control" name="nombre" value="<?= (set_value('nombre')) ? set_value('nombre') : $datos['nombre']; ?>" placeholder="Nombre"/>
        <span class="help-block"><?= form_error('nombre') ?></span>
    </div>

    <div class="form-group">
        <label class="control-label" for="apellidos">Apellidos</label>
        <input type="text" id="id2" readonly="readonly" class="form-control" name="apellidos" value="<?= (set_value('apellidos')) ? set_value('apellidos') : $datos['apellidos']; ?>" placeholder="Apellidos"/>
        <span class="help-block"><?= form_error('apellidos') ?></span>
    </div>

    <div class="form-group">
        <label class="control-label" for="dni">Dni</label>
        <input type="text" id="id3" readonly="readonly" class="form-control" name="dni" value="<?= (set_value('dni')) ? set_value('dni') : $datos['dni']; ?>" placeholder="Dni"/>
        <span class="help-block"><?= form_error('dni') ?></span>
    </div>

    <div class="form-group">
        <label class="control-label" for="direccion">Dirección</label>
        <input type="text" id="id4" readonly="readonly" class="form-control" name="direccion" value="<?= (set_value('direccion')) ? set_value('direccion') : $datos['apellidos']; ?>" placeholder="Dirección"/>
        <span class="help-block"><?= form_error('direccion') ?></span>
    </div>  

    <div class="form-group">
        <label class="control-label" for="pasword">Password</label>
        <input type="hidden" id="pass" class="form-control" name="pasword" placeholder="Password"/>
        <span class="help-block"><?= form_error('pasword') ?></span>
    </div>

    <div class="form-group">
        <label class="control-label" for="mail">Email</label>
        <input type="text" id="id6" readonly="readonly" class="form-control" name="mail" value="<?= (set_value('mail')) ? set_value('mail') : $datos['mail']; ?>" placeholder="Email"/>
        <span class="help-block"><?= form_error('mail') ?></span>

    </div>
    <div class="row form-group">
        <button type="submit" disabled="disabled" id="btnenviar" class="btn btn-primary btn-md login pull-left">Enviar</button> 
        <a class="btn btn-danger btn-md pull-right" href="<?= base_url("index.php/usuario/login") ?>">Cancelar </a>
    </div>
</form>





