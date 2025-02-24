<?php
	if(isset($_GET['rta'])){

		echo mostrarMensajes($_GET['rta']);
	}
?>

<div class="reservation_top">

	<div class="register-top-grid">

		<h3>NUEVO ADMINISTRADOR</h3>
		<form action="admin/usuario.php?action=adduser" method="post">
			<div class="mation">
				<span>Nombre: <label>*</label></span>
				<input type="text" name="nombre" style="width:30%;"> 
				<span>Apellido: <label>*</label></span>
				<input type="text" name="apellido" style="width:30%;"> 
				<span>E-Mail: <label>*</label></span>
				<input type="text" name="email" style="width:30%;">
				<span>Contraseña: <label>*</label></span>
				<input type="password" name="pass" style="width:30%;">
				<div class="register-but">
					<input type="submit" value="Registrarme">
				</div>
			</div>
		</form>

	</div>
	<div class="clearfix"></div>
	
</div>


	