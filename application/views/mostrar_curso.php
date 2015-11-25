<br/>
<form role="form" action="<?= base_url('index.php/fichero/modificar_curso') ?>" enctype="multipart/form-data" method="post">

    <div class="row form-group">
        <div class=" col-xs-11 col-md-4 ">
           
            <embed src="<?= base_url() . $ruta . $cod . '.pdf' ?>" width="400" height="275">
            
            <a class="btn btn-danger btn-md pull-right" href="<?= base_url() . $ruta . $cod . '.pdf' ?>"
               download="<?=$cod . '.pdf' ?>">Descargar</a>
             
        </div>     
    </div>

</form>


