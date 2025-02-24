<?php
    validarSesion();
    
    if(isset($_GET['rta'])){

        echo mostrarMensajes($_GET['rta']);
    }
    
    if(isset($_GET['p'])){

        $pagina=$_GET['p'];
    }
    else{
        $pagina=1;

    }
    $filas=2;
?>


<h1>Listado de productos</h1>

<?php
    mostrarTabla($pagina,$filas);
?>

