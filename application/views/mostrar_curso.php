<br/>
<form role="form" action="<?= base_url().'index.php/fichero/modificar_titulo/'.$cod ?>" enctype="multipart/form-data" method="post">

<div class="row form-group">
            <div class="col-xs-11 col-md-11">
            	<p class="lead">
            	<label class="text-left">Nombre: </label>
            		<label class="text-center"><?=$nombre?></label>
           		 </p>
            </div>
        </div>
    <div class="row form-group">
        <div class='col-xs-11 col-md-4 '>
           
            <embed src="<?= base_url() . $ruta.'/' . $cod . '.pdf' ?>" height="28%" width="100%" class="table table-bordered">
       
        </div>   
        <div class=" col-xs-11 col-md-8 ">
           
        <div class="row form-group">
            <div class="col-xs-11 col-md-7">
            	<p class="text-left">
            	<label class="form-group">T. Certificado:</label>
            		<?= $tipo_certificado?>
           		 </p>
            </div>
            <div class="col-xs-11 col-md-5">
            	<p class="text-left">
            	<label class="form-group">Emisor</label>
            		<?=$emisor?>
           		 </p>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-xs-11 col-md-2">
            	<p class="text-left">
            	<label class="form-group">Horas:</label>
            		<?=$horas?>
           		 </p>
            </div>
            <div class="col-xs-11 col-md-3">
            	<p class="text-left">
            	<label class="form-group">Corte</label>
            		<?=$corte?>
           		 </p>
            </div>
            <div class="col-xs-11 col-md-4">
            	<p class="text-left">
            	<label class="form-group">Fecha</label>
            		<?=$fecha?>
           		 </p>
            </div>
            <div class="col-xs-11 col-md-3">
            	<p class="text-left">
            	<label class="form-group">Baremado</label>
            		<?=$baremo?>
           		 </p>
            </div>

        </div>
            <div class="row form-group">
            <div class="col-xs-11 col-md-6">
			<label for = "name">Titulaciones</label>
            <textarea class = "form-control text-left" readonly name="observaciones" rows = "4" placeholder="Escriba aqui......"><?php foreach($titulacion as $item) :?><?= $item."\r"?><?php endforeach;?></textarea>
            </div>
            <div class="col-xs-11 col-md-5">
			<label for = "name">Observaciones</label>
            <textarea class = "form-control text-left"readonly name="observaciones" rows = "4" placeholder="Escriba aqui......"><?=$observaciones."\r"?></textarea>
            </div>
        </div>
        </div>       
    </div>
    <br/>
    <div class="row form-group">
      <div class="col-xs-11 col-md-3">
        
        <a class="btn btn-primary btn-md login" href="<?= base_url("index.php/fichero/modificar_titulo/".$cod) ?>">Modificar datos</a>
      </div>
    <div class="col-xs-11 col-md-3">
        
        <a class="btn btn-danger btn-md pull-left" href="<?= base_url("index.php/fichero/eliminar_certificado/".$cod) ?>">Eliminar</a>
    </div>
 <div class="col-xs-11 col-md-3">         
 <input type="button" class="btn btn-danger btn-md" value="Imprimir" onclick="document.getElementById('<?=$cod?>').focus(); document.getElementById('<?=$cod?>').contentWindow.print();">
        <iframe src="<?= base_url() . $ruta.'/' . $cod . '.pdf' ?>" id="<?=$cod?>" style='display:none'> </iframe>
    </div>
    <div class="col-xs-11 col-md-3">
         <a class="btn btn-danger btn-md" href="<?= base_url() . $ruta . $cod . '.pdf' ?>"
               download="<?=$cod . '.pdf' ?>">Descargar</a>
    </div>
    </div>
</form>
<hr>

