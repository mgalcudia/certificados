<!DOCTYPE html>
<html>
<head>

        <meta charset="utf-8">
	<link href="<?=base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
        <link href="<?=base_url('assets/css/mio.css')?>" rel="stylesheet">
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
</body>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url('/assets/jq/jquery-1.11.3.js') ?>"></script>
    <script src="<?= base_url('/assets/jq/jquery-migrate-1.2.1.min.js') ?>"></script>
    <script src="<?= base_url('/assets/jq/personal.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
    
</html>
