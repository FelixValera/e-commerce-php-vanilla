<?php 
    require_once('funciones.php');
    require_once('../ini.php');
    include('header.php');
?>	
<div class="container-lg">
    
    <section id="page">
		<?php
			
			if(isset($_GET['page'])){

				$page=$_GET['page'];
			}
			else{

				$page='panel';
			}
			
			cargarPagina($page);
        ?>
	</section>
	
</div>

	
		