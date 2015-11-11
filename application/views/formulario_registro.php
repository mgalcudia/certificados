<br/>
<form role="form" action="<?=base_url("index.php/usuario/registro")?>" method="post">

    <div class="form-group <?= (isset($clase_campo_form['nombre'])) ? $clase_campo_form['nombre'] : '' ?>">
        <label class="control-label" for="nombre">Nombre</label>
        <input type="text" class="form-control" name="nombre" value="<?= set_value('nombre'); ?>" placeholder="Nombre"/>
        <span class="help-block"><?= form_error('nombre') ?></span>
    </div>
    
    <div class="form-group <?= (isset($clase_campo_form['apellidos'])) ? $clase_campo_form['apellidos'] : '' ?>">
        <label class="control-label" for="apellidos">Apellidos</label>
        <input type="text" class="form-control" name="apellidos" value="<?= set_value('apellidos'); ?>" placeholder="Apellidos"/>
        <span class="help-block"><?= form_error('apellidos') ?></span>
    </div>
    
    <div class="form-group <?= (isset($clase_campo_form['dni'])) ? $clase_campo_form['dni'] : '' ?>">
        <label class="control-label" for="dni">Dni</label>
        <input type="text" class="form-control" name="dni" value="<?= set_value('dni'); ?>" placeholder="Dni"/>
        <span class="help-block"><?= form_error('dni') ?></span>
    </div>
    
    <div class="form-group <?= (isset($clase_campo_form['direccion'])) ? $clase_campo_form['direccion'] : '' ?>">
        <label class="control-label" for="direccion">Dirección</label>
        <input type="text" class="form-control" name="direccion" value="<?= set_value('direccion'); ?>" placeholder="Dirección"/>
        <span class="help-block"><?= form_error('direccion') ?></span>
    </div>  
    
    <div class="form-group <?= (isset($clase_campo_form['pasword'])) ? $clase_campo_form['pasword'] : '' ?>">
        <label class="control-label" for="pasword">Password</label>
        <input type="text" class="form-control" name="pasword" placeholder="Password"/>
        <span class="help-block"><?= form_error('pasword') ?></span>
    </div>
    
    <div class="form-group <?= (isset($clase_campo_form['mail'])) ? $clase_campo_form['mail'] : '' ?>">
        <label class="control-label" for="mail">Email</label>
        <input type="text" class="form-control" name="mail" value="<?= set_value('mail'); ?>" placeholder="Email"/>
        <span class="help-block"><?= form_error('mail') ?></span>
        <span class="help-block"><?php if (isset($error)) echo $error; ?></span>
    </div>
    
    <button type="submit" class="btn btn-primary btn-md login">Enviar</button>
</form>