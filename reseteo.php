<?php
    
    validarSesion(true);
    if(isset($_GET['u']) && isset($_GET['k'])){
        
        $action='savePass';
        $mail=$_GET['u'];
        $clave=$_GET['k'];
    }
    else{

        $action='recoveryUser';
    }
	
?>

<div class="account_grid">

	<div class="login-right">
        <h3>Recuperar Cuenta</h3>
        <?php
        if($action=='recoveryUser'){
        ?>
            <form action="admin/usuario.php?action=recoveryUser" method="post">
                <div>
                    <span>E-Mail:</span>
                    <input type="text" name="email" style="width:30%"> 
                </div>
                <input type="submit" value="Enviar">
            </form>
        <?php
        }
        
        if($action=='savePass'){
        ?>
            <form action="admin/usuario.php?action=savePass" method="post">
                <div>
                    <span>Nueva Contraseña:</span>
                    <input type="password" name="pass" style="width:30%"> 
                    <input type="hidden" name="mail" value="<?=$mail?>">
                    <input type="hidden" name="clave" value="<?=$clave?>">
                </div>
                <input type="submit" value="Enviar">
            </form>
        <?php
        }
        ?>
       
		
	</div>	
</div>