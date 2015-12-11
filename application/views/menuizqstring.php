<h2> <p class="text-primary line-height lead">Historico cortes</p></h2>  
<h3>
    <ul class="nav nav-sidebar text-danger">

        <?php
        foreach ($historicos as $year => $valor) {

            echo"<li ><a class = 'text-success 'href='" . base_url('index.php/historico/mostrar_historico/' . $valor['corte']) . "'>" . $valor['corte'] . "</a></li>";
        }
        ?> 

    </ul>
</h3>