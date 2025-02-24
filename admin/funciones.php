<?php

require('conexion.php');

function cargarPagina($pagina){

    $pagina=$pagina.".php";

    if(file_exists($pagina)){

        $pagina=$pagina;
    }
    else{

        $pagina="404.php";
    }

    include($pagina);

}

function mostrarMensajes($rta){

    switch($rta){

        case"001":
            $mensaje="<b style=color:red>NOMBRE O APELLIDO INCORRECTO, VERIFICAR :(</b>";
        break;
        case"002":
            $mensaje="<b style=color:red>EMAIL INCORRECTO, VERIFICAR :(</b>";
        break;
        case"003":
            $mensaje="<b style=color:red>MENSAJE INCORRECTO, VERIFICAR :(</b>";
        break;
        case"004":
            $mensaje="<b style=color:green>CORREO ENVIADO CON EXITO :)</b>";
        break;
        case"005":
            $mensaje="<b style=color:red>CORREO NO ENVIADO :(</b>";
        break;
        case"006":
            $mensaje="<b style=color:green>SE CREO UN NUEVO PRODUCTO SATISFACTORIAMENTE :)</b>";
        break;
        case"007":
            $mensaje="<b style=color:red>ERROR AL CREAR UN PRODUCTO :(</b>";
        break;
        case"008":
            $mensaje="<b style=color:green>SE ACTUALIZO SATISFACTORIAMENTE :)</b>";
        break;
        case"009":
            $mensaje="<b style=color:red>ERROR AL ACTUALIZAR :(</b>";
        break;
        case"010":
            $mensaje="<b style=color:green>PRODUCTO ELIMINADO SATISFACTORIAMENTE :)</b>";
        break;
        case"011":
            $mensaje="<b style=color:red>ERROR AL BORRAR EL PRODUCTO :(</b>";
        break;
        case"012":
            $mensaje="<b style=color:red>ERROR EL ARCHIVO SUBIDO NO ES UNA IMAGEN O HAY CAMPOS VACIOS :(</b>";
        break;
        case"013":
            $mensaje="<b style=color:red>ERROR EL USUARIO YA ESTA REGISTRADO :(</b>";
        break;
        case"014":
            $mensaje="<b style=color:green>Registro correcto! Revise su email para activar su cuenta :)</b>";
        break;
        case"015":
            $mensaje="<b style=color:red>Error en la registración, intente de nuevo :(</b>";
        break;
        case "016":
            $mensaje="<b style=color:red>Error! El usuario no se encuentra registrado :(</b>";
        break;
        case "017":
            $mensaje="<b style=color:green>Listo! La cuenta fue activada correctamente ya puede ingresar :)</b>";
        break;
        case "018":
            $mensaje="<b style=color:red>Error! Al activar la cuenta, intente de nuevo :(</b>";
        break;
        case "019":
            $mensaje="<b style=color:red>Error! Usuario o contraseña incorrecta :(</b>";
        break;
        case "020":
            $mensaje="<b style=color:green>Ingreso Exitoso :)</b>";
        break;
        case "021":
            $mensaje="<b style=color:green>Sesion Finalizada !!</b>";
        break;
        case "022":
            $mensaje="<b style=color:red>No existe! un usuarios registrado con ese email :(</b>";
        break;
        case "023":
            $mensaje="<b style=color:green>Revise su casilla de e-mail para recuperar su cuenta :)</b>";
        break;
        case "024":
            $mensaje="<b style=color:red>Error! campo vacio :(</b>";
        break;
        case "025":
            $mensaje="<b style=color:red>Error! Clave de activacion incorrecta :(</b>";
        break;
        case "026":
            $mensaje="<b style=color:green>Clave actualizada satisfactoriamente :)</b>";
        break;
        case "027":
            $mensaje="<b style=color:red>Error! al actualizar la clave :(</b>";
        break;
    }
    
    return $mensaje;
}

function mostrarProductos($archivo){

    $fp= fopen($archivo,'r');
    $fila=fgetcsv($fp);

    while($fila=fgetcsv($fp)){

        ?>

        <div class="grid-product">
            <!-- Producto #1 -->
            <div class="product-grid">
                <div class="content_box">
                    <a href="producto.php">
                        <div class="left-grid-view grid-view-left">
                            <img src="images/productos/<?=$fila[0]?>.jpg" class="img-responsive watch-right" alt=""/>
                        </div>
                    </a>
                    <h4><a href="#"><?=$fila[4]?></a></h4>
                    <p><?=$fila[1]?></p>
                    <span><?=$fila[2]?></span>
                </div>
            </div>
        </div>
        
        <?php
    }
}

// funciones del back-end  ---------------------------------------------------------------------------------------------------------

function listarProductos($pagina,$filas){

    global $pdo;
    $posicion=($pagina - 1)*$filas;

    $sql='SELECT p.idProducto,p.Nombre,p.Precio,m.Nombre AS Marca,c.Nombre AS Categoria,p.Presentacion,p.Stock,p.Imagen,p.Estado FROM productos AS p
    JOIN marcas AS m ON m.idMarca=p.Marca
    JOIN categorias AS c ON c.idCategoria=p.categoria LIMIT :posicion,:filas;';

    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(":posicion",$posicion,PDO::PARAM_INT);
    $stmt->bindParam(":filas",$filas,PDO::PARAM_INT);
    $stmt->execute();

    return $stmt;

}

function cambiarEstado($idProducto,$estado){

    global $pdo;

    $sql="UPDATE productos SET Estado=$estado WHERE idProducto=$idProducto";
    $stmt=$pdo->prepare($sql);
    $stmt->execute();

}

function listarMarcas(){

    global $pdo;
    $sql="SELECT * FROM marcas";
    $stmt=$pdo->prepare($sql);
    $stmt->execute();

    return $stmt;

}

function listarCategorias(){

    global $pdo;
    $sql="SELECT * FROM categorias";
    $stmt=$pdo->prepare($sql);
    $stmt->execute();

    return $stmt;
}

function optenerProducto($id=0){
    
    if($id==0){

        $producto=[

            'idProducto'=>'',
            'Nombre'=>'',
            'Precio'=>'',
            'Marca'=>'',
            'Categoria'=>'',
            'Presentacion'=>'',
            'Stock'=>'',
            'Imagen'=>'',
            'Estado'=>''

        ];
    }

    if($id != 0){
        
        global $pdo;
        $sql="SELECT * FROM productos WHERE idProducto=?";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(1,$id);
        $stmt->execute();

        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    return $producto;
}

//Recibe todos los datos del formulario mediante el method=POST
function crearProducto(){

    global $pdo;

    $nombre= !empty($_POST['nombre']) ? $_POST['nombre'] :  header("location:".BACK_END_URL."/?rta=012");
    $precio= !empty($_POST['precio']) ? $_POST['precio'] :  header("location:".BACK_END_URL."/?rta=012");
    $presentacion= !empty($_POST['presentacion']) ? $_POST['presentacion'] : header("location:".BACK_END_URL."/?rta=012");
    $stock= $_POST['stock'];
    $marca= $_POST['marca'];
    $categoria= $_POST['categoria'];

    //comprobamos si el usuarios selecciono una imagen para subir
    if(isset($_FILES['imagen']['tmp_name']) && !empty($_FILES['imagen']['tmp_name'])){
        
        $imagen=sha1_file($_FILES['imagen']['tmp_name']);
        $tmp_name=$_FILES['imagen']['tmp_name'];
    }
    else{
        $tmp_name='null';
    }
    //comprobamos que alchivo subido sea una imagen 
    if(getimagesize($tmp_name)){

        move_uploaded_file($tmp_name,UPLOADS."/$imagen");

        $sql="INSERT INTO productos (Nombre,Precio,Marca,Categoria,Presentacion,Stock,Imagen) VALUES (:nombre,:precio,:marca,:categoria,:presentacion,:stock,:imagen)";

        $stmt=$pdo->prepare($sql);
        
        $stmt->bindParam(':nombre',$nombre);
        $stmt->bindParam(':precio',$precio);
        $stmt->bindParam(':marca',$marca);
        $stmt->bindParam(':categoria',$categoria);
        $stmt->bindParam(':presentacion',$presentacion);
        $stmt->bindParam(':stock',$stock);
        $stmt->bindParam(':imagen',$imagen);

        if($stmt->execute()){

            $rta="006";
        }
        else{
            $rta="007";
        }

        header("location:".BACK_END_URL."/?rta=".$rta);
    }
    else{

        $rta="012";
        header("location:".BACK_END_URL."/?rta=".$rta);
    }

}

function actualizarProducto(){
    global $pdo;

    //-------- comprobamos que el arhivo subido sea una imagen ---------------------- 
    // condicion1= si el archivo a subir no esta vacio "y" el archivo a subir es una imagen RETURN TRUE
    // condicion2= si el archivo a subir esta vacion "y" el arhcivo que ya esta en el directorio es una imagen RETURN TRUE

    $condicion1=(!empty($_FILES['imagen']['tmp_name']) && getimagesize($_FILES['imagen']['tmp_name']));
    $condicion2=(empty($_FILES['imagen']['tmp_name']) && getimagesize(UPLOADS."/".$_POST['imagenActual']));
   
    if( $condicion1 || $condicion2 ){

        if($condicion2){

            $imagen=$_POST['imagenActual'];
        }
        else{

            $imagen=sha1_file($_FILES['imagen']['tmp_name']);
            $tmp_name=$_FILES['imagen']['tmp_name'];
            
            unlink(UPLOADS."/".$_POST['imagenActual']);
            move_uploaded_file($tmp_name,UPLOADS."/$imagen");
        }

        $id=$_POST['id'];
        $nombre=$_POST['nombre'];
        $precio=$_POST['precio'];
        $presentacion=$_POST['presentacion'];
        $stock=$_POST['stock'];
        $marca=$_POST['marca'];
        $categoria=$_POST['categoria'];

        $sql="UPDATE productos SET Nombre=:nombre,Precio=:precio,Marca=:marca,Categoria=:categoria,Presentacion=:presentacion,Stock=:stock,Imagen=:imagen WHERE idProducto=:id";

        $stmt=$pdo->prepare($sql);

        $stmt->bindParam(':nombre',$nombre);
        $stmt->bindParam(':precio',$precio);
        $stmt->bindParam(':marca',$marca);
        $stmt->bindParam(':categoria',$categoria);
        $stmt->bindParam(':presentacion',$presentacion);
        $stmt->bindParam(':stock',$stock);
        $stmt->bindParam(':imagen',$imagen);
        $stmt->bindParam(':id',$id);

        if($stmt->execute()){

            $rta="008";
        }
        else{
            $rta="009";
        }

        header("location:".BACK_END_URL."/?rta=$rta");
    }
    else{

        $rta="012";
        header("location:".BACK_END_URL."/?rta=$rta");

    }
}

function eliminarProducto(){

    global $pdo;

    $id=$_POST['id'];
    $imagen=$_POST['imagenActual'];
    unlink(UPLOADS."/$imagen");

    $sql="DELETE FROM productos WHERE idProducto=:id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':id',$id);
    
    if($stmt->execute()){

        $rta="010";
    }
    else{
        $rta="011";
    }

    header("location:".BACK_END_URL."/?rta=$rta");

}

function mostrarTabla($pagina,$filas){

    ?>
    <table class="table table-bordered">
    
        <br>
        <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Marca</th>
            <th>Categoria</th>
            <th>Presentacion</th>
            <th>Stock</th>
            <th>Actualizar</th>
            <th>Eliminar</th>
            <th>OFF/ON</th>
        </tr>

        <?php



            if(isset($_GET['accion']) && $_GET['accion']=='cambiar'){

                $estado= ($_GET['estado']==1) ? 0 : 1;
                $idProducto=$_GET['idProducto'];
                cambiarEstado($idProducto,$estado);

            } 

            $registros=listarProductos($pagina,$filas);

            foreach($registros as $valor){

            ?>

            <tr>
                <td><img style="max-width:100px" src="<?=UPLOADS_URL."/".$valor['Imagen']?>" alt=""></td>
                <td style="padding-top:5%"><?=$valor['Nombre']?></td>
                <td style="padding-top:5%"><?=$valor['Precio']?></td>
                <td style="padding-top:5%"><?=$valor['Marca']?></td>
                <td style="padding-top:5%"><?=$valor['Categoria']?></td>
                <td style="padding-top:5%"><?=$valor['Presentacion']?></td>
                <td style="padding-top:5%"><?=$valor['Stock']?></td>

                <td style="padding-top:5%">
                    <a href="./?page=formulario&idProducto=<?=$valor['idProducto']?>&accion=update">

                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg>
            
                    </a>
                </td>

                <td style="padding-top:5%">
                    <a href="./?page=formulario&idProducto=<?=$valor['idProducto']?>&accion=delete">

                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>

                    </a>
                </td>

                <td style="padding-top:5%">
                    <a href="./?page=panel&idProducto=<?=$valor['idProducto']?>&accion=cambiar&estado=<?=$valor['Estado']?>&p=<?=$pagina?>">
                        
                        <?php
                            if($valor['Estado']==1){
                                ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-toggle-on" viewBox="0 0 16 16">
                                    <path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
                                </svg>
                                <?php

                            }
                            else{
                                ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-toggle-off" viewBox="0 0 16 16">
                                    <path d="M11 4a4 4 0 0 1 0 8H8a4.992 4.992 0 0 0 2-4 4.992 4.992 0 0 0-2-4h3zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5z"/>
                                </svg>
                                <?php
                            }
                        ?>
                    
                    </a>
                </td>
            </tr>
            <?php
            }
        ?>

    </table>
    <?php
    mostrarPaginador($pagina,$filas);
}

function mostrarPaginador($pagina,$fila){

    global $pdo;

    $stmt=$pdo->prepare('SELECT COUNT(*) FROM productos;');
    $stmt->execute();
    $total_filas=$stmt->fetchColumn();
    $pagina_total=ceil($total_filas/$fila);
    ?>
    
    <ul id="paginador">
        
        <?php
        if($pagina!=1){
            ?>
            <li><a href="<?=BACK_END_URL."/?p=".($pagina-1)?>">Anterior</a></li>
            <?php
        }

        for($i=1;$i<=$pagina_total;$i++){

            echo"<li><a href=".BACK_END_URL."/?p=".$i.">$i</a></li>\n";
        }

        if($pagina!=$pagina_total){
            ?>
           <li><a href="<?=BACK_END_URL."/?p=".($pagina+1)?>">Siguiente</a></li>
           <?php
        }
        ?>    
       
    </ul>
    <?php

}

function registrarUsuarios($nombre,$apellido,$mail,$pass){

    // procedemos a realizar la validacion de los campos
    $patron_nombre="/^[^\d][A-Záéíóú\S][^\d]{2,20}$/i";
    $patron_email="/^[A-Z\S]+@[A-Z]+\.[A-Z]{3}$/i";
    $nombre=trim($nombre);
    $apellido=trim($apellido);
    $mail=trim($mail);
    $hast=password_hash($pass,PASSWORD_DEFAULT);

    if(!preg_match($patron_nombre,$nombre)){
        $rta="001";
        header("location:../index.php?page=registro&rta=$rta");
    }
    elseif(!preg_match($patron_nombre,$apellido)){
        $rta="001";
        header("location:../index.php?page=registro&rta=$rta");
    }
    elseif(!preg_match($patron_email,$mail)){
        $rta="002";
        header("location:../index.php?page=registro&rta=$rta");
    }

    else{
        // verificamos si el usuario ya estaba registrado
        global $pdo;

        $rta="013";
        $stmt=$pdo->prepare('SELECT Email FROM usuarios WHERE Email=:mail and Estado=1;');
        $stmt->bindParam(":mail",$mail);
        $stmt->execute();

        if($stmt->rowCount()==0){
            //creamos la clave de activacion para habilitar la cuenta 
            $string="abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789ª!·$%&/()=?¿*^¨ç_:;\|@#~€¬][}{}]";
            $clave=str_shuffle($string);
            $clave=md5($clave);

            $stmt=$pdo->prepare('INSERT INTO usuarios (Nombre,Apellido,Email,Pass,Activacion) VALUES (:nombre,:apellido,:mail,:pass,:clave);');
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':apellido',$apellido);
            $stmt->bindParam(':mail',$mail);
            $stmt->bindParam(':pass',$hast);
            $stmt->bindParam(':clave',$clave);

            if($stmt->execute()){
                //procedemos a crear el contenido del correo a enviar
                $url_activacion=BACK_END_URL."/usuario.php?u=$mail&k=$clave&action=activeUser";

                $cuerpo="<h1>Bienvenido a tu Tienda</h1><br>";
                $cuerpo.="Nombre: $nombre<br>";
                $cuerpo.="Apellido: $apellido<br>";
                $cuerpo.="Usuario: $mail<br>";
                $cuerpo.="<p>Por favor active su cuenta para operar en la plataforma</p>";
                $cuerpo.="<a style='background-color:blue;color:white;display:block;padding:10px' href='".$url_activacion."'>ACTIVE SU CUENTA</a>";

                $cabeceras="From: no-reply@".$_SERVER['SERVER_NAME']."\r\n";
                $cabeceras.="MIME-Version:1.0\r\n";
                $cabeceras.="Content-type: text/html; charset=utf-8\r\n";

                mail($mail,'Alta nuevo usuario',$cuerpo,$cabeceras);
                //para ver el mensaje del correo y poder probar otras funciones
                
                $rta="014";
            }
            else{
               
                $rta="015";
            }

        }
        
        header("location:../index.php?page=registro&rta=$rta");
    }
}

function activarUsuario($mail,$clave){

    global $pdo;
    $rta="016";
    $stmt=$pdo->prepare('SELECT * FROM usuarios WHERE Email=:mail  AND Activacion=:clave;');
    $stmt->bindParam(':mail',$mail);
    $stmt->bindParam(':clave',$clave);
    
    if($stmt->execute()){

        $stmt=$pdo->prepare('UPDATE usuarios SET Estado=1 WHERE Email=:mail;');
        $stmt->bindParam(':mail',$mail);

        if($stmt->execute()){
            $rta="017";
        }
        else{
            $rta="018";
        }
    }

    header("location:../index.php?page=ingreso&rta=$rta");
    
}

function iniciarSesion($mail,$pass){

    global $pdo;
    $rta="019";
    $ruta="../index.php?page=ingreso&rta=$rta";
    $stmt=$pdo->prepare('SELECT * FROM usuarios WHERE Email=:mail AND Estado=1');
    $stmt->bindParam(':mail',$mail);
    $stmt->execute();

    if($stmt->rowCount()>0){

        $usuario=$stmt->fetch();
        if(password_verify($pass,$usuario['Pass'])){

            session_start();
            $_SESSION['usuario']=[

                "nombre"=>$usuario['Nombre'],
                "apellido"=>$usuario['Apellido'],
                "email"=>$usuario['Email']
            ];
            $rta="020";
            $ruta="./?page=panel&rta=$rta";
        }
    }
    header("location:$ruta");
}

function cerrarSesion(){

    $rta="021";
    session_start();
    setcookie(session_name().null);
    session_unset();
    session_destroy();

    header("location:../?page=ingreso&rta=$rta");
}

function recuperarClave($mail){

    //validamos el campo 
    $patron_email="/^[A-Z\S]+@[A-Z]+\.[A-Z]{3}$/i";

    if(!preg_match($patron_email,$mail)){

        header("location:../?page=ingreso&rta=002");
    }

    global $pdo;
    $rta="022";
    $stmt=$pdo->prepare('SELECT * FROM usuarios WHERE Email=:mail AND Estado=1');
    $stmt->bindParam(':mail',$mail);
    $stmt->execute();
    
    if($stmt->rowCount()>0){

        $rta="018";
        //creamos la clave de activacion 
        $string="abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789ª!·$%&/()=?¿*^¨ç_:;\|@#~€¬][}{}]";
        $clave=str_shuffle($string);
        $clave=md5($clave);

        $stmt=$pdo->prepare('UPDATE usuarios SET Activacion=:clave WHERE Email=:mail');
        $stmt->bindParam(':clave',$clave);
        $stmt->bindParam('mail',$mail);
        
        if($stmt->execute()){
            $rta="023";
            //procedemos a crear el correo a enviar
            $url_recupero=FRONT_END_URL."/?page=reseteo&u=$mail&k=$clave";

            $cuerpo="<h1>Recuperar cuenta</h1><br>";
            $cuerpo.="Usuario: ".$mail."<br>";
            $cuerpo.="<p>Por favor haga click para recuperar su cuenta.</p>";
            $cuerpo.="<a style='background-color:blue;color:white;padding:10px;display:block;' href='".$url_recupero."'>RECUPERAR CUENTA</a>";

            $cabecera = "From: no-reply@" . $_SERVER["SERVER_NAME"] . "\r\n";
			$cabecera.= "MIME-Version: 1.0" . "\r\n";
			$cabecera.= "Content-Type: text/html; charset=utf-8" . "\r\n";

            mail($mail,'Recuperar Cuenta',$cuerpo,$cabecera);
        }
    }
    
    header("location:../?page=ingreso&rta=$rta");
}

function guardarClave($pass,$mail,$clave){
    //procedemos a seleccionar el registro con la clave de activacion correcta
    $rta="025";
    global $pdo;
    $stmt=$pdo->prepare('SELECT * FROM usuarios WHERE Email=:mail AND Activacion=:clave');
    $stmt->bindParam(':mail',$mail);
    $stmt->bindParam(':clave',$clave);
    $stmt->execute();
    
    if($stmt->rowCount()>0){
        //Si existe el registro procedemos a actualizar la contraseña
        $pass=password_hash($pass,PASSWORD_DEFAULT);
        $stmt=$pdo->prepare('UPDATE usuarios SET Pass=:pass WHERE Email=:mail');
        $stmt->bindParam(':pass',$pass);
        $stmt->bindParam(':mail',$mail);

        if($stmt->execute()){
            $rta="026";
        }
        else{
            $rta="027";
        }
    }

    header("location:../?page=ingreso&rta=$rta");
}

function validarSesion($estado=false){

    $ruta= $estado ? BACK_END_URL."/?page=panel" : FRONT_END_URL."/?page=ingreso";
    session_start();
    
    if(isset($_SESSION['usuario']) == $estado){

        header("location: $ruta");
    }

}

function inicio($texto,$orden,$fila,$pagina){
    
    $posicion=($pagina-1)*$fila;
    global $pdo;
    
    if($texto!='false' && $orden=='false'){
        //$texto=substr($texto,1,-1);
        $flag=true; //sirve para parametrizar datos o no, para mostrar o no el contador
        $buscar="%$texto%";

        $sql="SELECT * FROM productos WHERE Estado=1 AND upper(Nombre) LIKE upper(:buscar) OR upper(Presentacion) LIKE upper(:buscar) LIMIT :posicion,:fila";
        
        $stmt= $pdo->prepare($sql);
        $stmt->bindParam(':buscar',$buscar);
        $stmt->bindParam(':posicion',$posicion,PDO::PARAM_INT);
        $stmt->bindParam(':fila',$fila,PDO::PARAM_INT);

    }
    
    else if($texto=='false' && $orden!='false'){
        // Al parecer en PDO no se pueden parametrizar las palabras claves de SQL
        //a continuacion la solucion
        $flag=false;

        $sql="SELECT * FROM productos WHERE Estado=1 ORDER BY Precio $orden LIMIT :posicion,:fila";
       
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':posicion',$posicion,PDO::PARAM_INT);
        $stmt->bindParam(':fila',$fila,PDO::PARAM_INT);
        
    }
    else if($texto!='false' && $orden!='false'){
        //$texto=substr($texto,1,-1);
        $flag=true;
        $buscar="%$texto%";

        $sql="SELECT * FROM productos WHERE Estado=1 AND upper(Nombre) LIKE upper(:buscar) OR upper(Presentacion) LIKE upper(:buscar) ORDER BY Precio $orden LIMIT :posicion,:fila";
        
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':buscar',$buscar);
        $stmt->bindParam(':posicion',$posicion,PDO::PARAM_INT);
        $stmt->bindParam(':fila',$fila,PDO::PARAM_INT);
    }
    else{
        $flag=false;
        $sql="SELECT * FROM productos WHERE Estado=1 LIMIT :posicion,:fila";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':posicion',$posicion,PDO::PARAM_INT);
        $stmt->bindParam(':fila',$fila,PDO::PARAM_INT);
    }

    $stmt->execute();
   
    foreach($stmt as $valor){
        ?>
        
        <div class="col-sm-4 col-md-4">
            <a href="./?page=producto&id=<?=$valor['idProducto']?>"><img class="img-responsive chain" src="<?=UPLOADS_URL."/".$valor['Imagen']?>" alt=" " /></a>
            <div class="grid-chain-bottom">
                <h6><a href="./?page=producto&id=<?=$valor['idProducto']?>"><?=$valor['Nombre']?></a></h6>
                <div class="star-price">
                    <div class="dolor-grid"> 
                        <span class="actual"><?=$valor['Precio']?></span>
                    </div>
                    <a class="now-get get-cart" href="./?page=producto&id=<?=$valor['idProducto']?>">VER MÁS</a> 
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <?php

    }
    //En el siguiente codigo optenemos la misma consulta SQL y quitamos el LIMIT para saber cuanto son los registros totales de la consulta y saber si mostramos el paginador o no  
    $consulta=substr($sql,0,-21);
    $stmt=$pdo->prepare($consulta);
    if($flag){
       
        $stmt->bindParam(':buscar',$buscar);
    }

    $stmt->execute();
    $registros=$stmt->rowCount();
    
    if($registros > $fila){

       $pagina_total=ceil($registros/$fila);
        ?>
        
        <div class="clearfix"></div>
        <div class="clearfix"> </div>

        <ul id="paginador">
            
            <?php
            // OJO HAY QUE LIMPIAR LA VARIABLE TEXTO 
            if($pagina!=1){
                ?>
                <li><a href="<?=FRONT_END_URL."/?p=".($pagina-1)."&orden=".$orden."&texto=".$texto?>">Anterior</a></li>
                <?php
            }

            for($i=1;$i<=$pagina_total;$i++){

                echo"<li><a href=".FRONT_END_URL."/?p=".$i."&orden=".$orden."&texto=$texto>$i</a></li>\n";
            }

            if($pagina!=$pagina_total){
                ?>
            <li><a href="<?=FRONT_END_URL."/?p=".($pagina+1)."&orden=".$orden."&texto=".$texto?>">Siguiente</a></li>
            <?php
            }
            ?>    
        
        </ul>
        <?php
    }

    
}

function mostrarProducto($id){

    $producto=optenerProducto($id);

    ?>
    <div class="single_grid">

        <div class="grid images_3_of_2">
            <ul id="etalage">
                <li>
                    <img class="img-responsive chain" src="<?=UPLOADS_URL."/".$producto['Imagen']?>" class="img-responsive" />
                </li>
            </ul>
            <div class="clearfix"></div>		
        </div>

        <div class="desc1 span_3_of_2">
            <h4><?=$producto['Nombre']?></h4>
            <div class="cart-b">
                <div class="left-n "><?=$producto['Precio']?></div>
                <a class="now-get get-cart-in" href="#">COMPRAR</a> 
                <div class="clearfix"></div>
            </div>
            <h6><?=$producto['Stock']?> unid. en stock</h6>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            <div class="share">
                <h5>Compartir Producto:</h5>
                <ul class="share_nav">
                    <li><a href="http://www.facebook.com" target="_black"><img src="imagen/facebook.png" title="facebook"></a></li>
                    <li><a href="http://www.twitter.com" target="_black"><img src="imagen/twitter.png" title="Twiiter"></a></li>
                </ul>
            </div>
        </div>

        <div class="clearfix"></div>

    </div>
    <?php
}

?>