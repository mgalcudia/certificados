<br/>
<form role="form" action="<?= base_url('index.php/fichero/agregar_fichero') ?>" method="post">
    
    <div class="form-group">
        <label class="form-group">Nombre</label>
        <input type="text" id="nombre" class="form-control" name="nombre" value="<?= set_value('nombre'); ?>" placeholder="Nombre titulacion" />
        <span class="help-block"><?= form_error() ?></span>        
    </div>
    <div class="row form-group">
        <div class=" col-xs-11 col-md-4 ">
            <label class="form-group">Horas</label>
            .<input type="text" id="nombre" class="form-control" name="nombre" value="<?= set_value('nombre'); ?>" placeholder="horas" />
            <span class="help-block"><?= form_error() ?></span>

        </div>
        <div class=" col-xs-11 col-md-3">
            <label class="form-group">Corte</label>
            <input type="text" id="nombre" class="form-control" name="nombre" value="<?= set_value('nombre'); ?>" placeholder="Año del corte" />
            <span class="help-block"><?= form_error() ?></span>
        </div>
        <div class=" col-xs-11 col-md-5">
            <label class="form-group">Nombre</label>
            <p> <input type="date" id="nombre" class="form-control" name="nombre" value="" placeholder="" /></p>
            <span class="help-block"><?= form_error() ?></span>
        </div>


    </div>
    <div class="row form-group">
        <div class="col-xs-11 col-md-5">
            <label class="control-label">Agrega el certificado</label>
            <input  type="file" id="subir_fichero" name="fichero">
        </div>
        <div class=" col-xs-11 col-md-3">
            <label class="form-group">Tipo</label>
            <p><?= form_dropdown('tipo',$tipo,set_value('tipo'));?></p>
            <span class="help-block"><?= form_error() ?></span>
        </div>
        <div class=" col-xs-11 col-md-4 dropdown ">
            <label class="form-group ">Entidad</label>
            <p> <?= form_dropdown('nombre',$emisor,set_value('nombre'));?></p>
            <span class="help-block"><?= form_error()?></span>
        </div>        
    </div>
    
    <div class="row form-group">
        <div class="col-xs-11 col-md-5">
            <label class="form-group ">Titulación</label>
            <select type="text" class="form-control multiselect multiselect-icon" multiple="multiple" role="multiselect">          
              <option value="0">Photos</option>          
              <option value="1">Link</option>
              <option value="2">Edit</option>
              <option value="3">Cart</option>
            </select>
            
        </div>
        <div class=" col-xs-11 col-md-7">
            <form role = "form">
   
   <div class = "form-group">
      <label for = "name">Text Area</label>
      <textarea class = "form-control" rows = "4">valor del text area</textarea>
   </div>
   

        </div>        
    </div>

</form>

