<?php

if(isset($_GET['rta'])){

	echo mostrarMensajes($_GET['rta']);
}


?>



<div class="main"> 

	<div class="reservation_top">

		<div class=" contact_right">

			<h3>Contacto</h3>

			<div class="contact-form">

				<form action="enviar.php" method="post">

					<input type="text" class="textbox" placeholder="Nombre" name="nombre" style="width:30%;">
					<input type="text" class="textbox" placeholder="E-Mail" name="email" style="width:30%;">
					<textarea placeholder="Mensaje" name="mensaje" style="width:45%; height:15%"></textarea>
					<input type="submit" value="Enviar" name="enviar">
					<div class="clearfix"></div>

				</form>

			</div>

		</div>

	</div>
	
</div>

