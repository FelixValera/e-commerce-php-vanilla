<div class="single_top">

	<?php
		
		if(isset($_GET['id'])){

			mostrarProducto($_GET['id']);	
		}
		else{
			header('location:./?page=inicio');
		}
		

	?>

</div>