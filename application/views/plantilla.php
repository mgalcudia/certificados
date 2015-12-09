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
  
  <div class="col-sm-8 col-md-10">
            <?=$cuerpo?>
    
  </div>
    

 </div>   
    <nav class="navbar navbar-default navbar-fixed-bottom navbar-inner" role="navigation">
  <footer><?php if (isset($pie)) echo $pie; ?></footer>
</nav>
    

</body>

<script src="<?=base_url('assets/js/fijo/bootstrap-multiselect.js')?>" type="text/javascript"></script>
<script type="text/javascript" src="<?=base_url('assets/js/fijo/bootstrap.min.js')?>"></script>


 <script src="<?= base_url('/assets/jq/personal.js') ?>"></script>
   
    
</html>
