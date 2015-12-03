<br/>
<div class='menu'>
	<span class="text-danger"><?php if (isset($error)) echo $error; ?></span>
	<h3>
	    <ul>
	        <li><a href=<?=site_url('fichero/mostrar_enlaces_editar/nobaremado');?>>Cursos no baremados</a></li>
	        <li><a href=<?=site_url('fichero/mostrar_enlaces_editar/baremado');?>>Cursos baremados</a></li>        
	        <li><a href=<?=site_url('fichero/mostrar_enlaces_editar/tipo');?>>Tipo certificado</a></li>
	        <li><a href=<?=site_url('fichero/mostrar_enlaces_editar/titulacion');?>>Titulación</a></li>
	        <li><a href=<?=site_url('fichero/mostrar_enlaces_editar/nombre');?>>Nombre</a></li>
	    </ul>
	</h3>
</div>