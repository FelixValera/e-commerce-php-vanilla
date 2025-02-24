<div class="register">
	
	<?php
	
		validarSesion();
		
		if(isset($_GET['accion'])){

			$accion=$_GET['accion'];
		}
		else{
			$accion='add';
		}

		if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST'){

			switch($accion){

				case 'add':
					crearProducto($_POST);
				break;
				case 'update':
					actualizarProducto($_POST);
				break;
				case 'delete':
					eliminarProducto($_POST);	
				break;

			}


		}
		else{

			switch($accion){

				case 'add':
					$titulo="NUEVO PRODUCTO";
					$btn="Agregar Producto";
					$status="null";
					$producto=optenerProducto();
					$style="null";
				break;
				case 'update':
					$id=$_GET['idProducto'];
					$titulo="ACTUALIZAR PRODUCTO";
					$btn="Actualizar";
					$status="null";
					$producto=optenerProducto($id);
					$style="null";
				break;
				case 'delete':
					$id=$_GET['idProducto'];
					$titulo="ESTAS SEGURO DE ELIMINAR EL SIGUIENTE PRODUCTO ?";
					$btn="Eliminar";
					$status="disabled";
					$style="style=color:tomato";
					$producto=optenerProducto($id);
				break;
			}
		}

	?>

	<div class="register-top-grid">

		<h3 <?=$style?>><?=$titulo?></h3>

		<form enctype= multipart/form-data action="./?page=formulario&accion=<?=$accion?>" method="POST">

			<div class="mation">

                <label><span>Nombre:</span>
				<input type="text" name="nombre" value="<?=$producto['Nombre']?>"<?=$status?>></label>

				<label><span>Precio:</span>
				<input type="number" name="precio"  step="any" value="<?=$producto['Precio']?>" <?=$status?>></label> 

				<label><span>Presentacion:</span>
				<input type="text" name="presentacion" value="<?=$producto['Presentacion']?>" <?=$status?>></label>

				<label><span>Stock</span>
				<input type="text" name="stock" value="<?=$producto['Stock']?>" <?=$status?>></label>

                <label><span>Imagen</span>
				<?php
					if(!empty($producto['Imagen'])){
						?>
					<img src="<?=UPLOADS_URL."/".$producto['Imagen']?>" alt="" width="165px">
					<?php
					}
				?>
				<input type="file" name="imagen" <?=$status?>></label>
				<br>

                <label><span>Marca</span>
					<select name="marca" <?=$status?>>
						<?php
							$marcas=listarMarcas();
							foreach($marcas as $campo){
								?>
								<option value=<?=$campo['idMarca']?> <?php if($campo['idMarca']==$producto['Marca']) echo "selected"?>><?=$campo['Nombre']?></option>
								<?php

							}
						?>
					</select>
				</label>

                <label><span>Categoria:</span>
					<select name="categoria" <?=$status?>>
						<?php
							$categoria=listarCategorias();
							foreach($categoria as $campo){
								?>
								<option value=<?=$campo['idCategoria']?> <?php if($campo['idCategoria']==$producto['Categoria']) echo "selected"?>><?=$campo['Nombre']?></option>
								<?php	
							}
						?>
					</select>
				</label>
				
				<?php
					if(isset($id)){
						?>
						<input type="hidden" name="id" value="<?=$producto['idProducto']?>">
						<input type="hidden" name="imagenActual" value="<?=$producto['Imagen']?>">
						<?php
					}
				?>

				<div class="register-but">
					<input type="submit" value="<?=$btn?>">
				</div>

			</div>
			
		</form>

	</div>
	
    <div class="clearfix"></div>
	
</div>