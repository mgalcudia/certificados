<!DOCTYPE html>
<html>
<head>

        <meta charset="utf-8">
    <link href="<?=base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
   <link href="<?=base_url('assets/css/mio.css')?>" rel="stylesheet">     
    

     <script type="text/javascript" src="<?=base_url('assets/jq/fijo/1.8.3/jquery.min.js')?> "></script>
    <link href="<?=base_url('assets/css/fijo/bootstrap-multiselect.css')?>"
        rel="stylesheet" type="text/css" />
    
<script src="<?=base_url('assets/jq/fijo/2.1.1/jquery.min.js')?> " type="text/javascript"></script>

	<title>Certificado</title>
 
</head>
<body>
<div class="container">
   
        <header>
                <?= $encabezado?>
	</header>
   
    
	<div class="col-sm-4 col-md-2">
		<aside><?=$menu_izq?></aside>
	</div>
	
	<div class="col-sm-8 col-md-10 margin-sup">
		<?= $cuerpo?>
	</div>
    
    
	<div class="col-sm-12" style="background-color: red;">
		<footer><?= $pie?></footer>
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
</body>

<script src="<?=base_url('assets/js/fijo/bootstrap-multiselect.js')?>" type="text/javascript"></script>
<script type="text/javascript" src="<?=base_url('assets/js/fijo/bootstrap.min.js')?>"></script>


 <script src="<?= base_url('/assets/jq/personal.js') ?>"></script>
   
    
</html>
