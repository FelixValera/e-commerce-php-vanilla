<div class="container-lg">
	<?php
	    require('admin/funciones.php');
		require_once('ini.php');
		include('header.php');
	?>

	<section id="page">
		<?php
			
			if(isset($_GET['page'])){

				$page=$_GET['page'];
			}
			else{

				$page='inicio';
			}
			
			cargarPagina($page);

			
		?>
	</section>

	<?php
		include('footer.php');
	?>
	
</div>

	
		