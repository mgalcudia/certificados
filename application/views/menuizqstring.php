<br/>
<br/> 
<br/>
<ul class="nav nav-sidebar">

    <?php
    foreach ($historicos as $year => $valor) {

        echo"<li><a href='" . base_url('index.php/historico/mostrar_historico/' . $valor['corte']) . "'>" . $valor['corte'] . "</a></li>";
    }
    ?> 
</ul>
