<?php
	validarSesion(true);

	if(isset($_GET['rta'])){

		echo mostrarMensajes($_GET['rta']);
	}
?>

<div class="account_grid">

	<div class="login-right">
		<h3>INGRESO DE ADMINISTRADOR</h3>
		<form action="admin/usuario.php?action=loginUser" method="post">
			<div>
				<span>E-Mail:</span>
				<input type="text" name="email" style="width:30%;"> 
			</div>
			<div>
				<span>Contraseña:</span>
				<input type="password" name="pass" style="width:30%;"> 
			</div>
			<input type="submit" value="Ingresar">
			<br>
			<a class="forgot" href="./?page=reseteo">¿Olvidaste tu contraseña?</a>
		</form>
	</div>	

	<div class=" login-left">
		<h3>¿NUEVO ADMINISTRADOR?</h3>
		<a class="acount-btn" href="./?page=registro">Crear una cuenta</a>
	</div>

	<div class="clearfix"></div>

</div>

