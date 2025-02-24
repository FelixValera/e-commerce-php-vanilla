<?php
    /*
    //conexion local
    $HOST='localhost';
    $DB='comercioit';
    $PASS='';
    $USER='root';
    */

    // conexion al servidor 
    
    $HOST='localhost';
    $DB='wxylokxy_comercio';
    $PASS='i1-za_r=lgQ_';
    $USER='wxylokxy_felix';
    
    
    try{

        $pdo=new PDO("mysql:host=$HOST;dbname=$DB;charset=utf8","$USER","$PASS");

    }
    catch(PDOException $error){
        
        // al ocurrir un error se muestra el mensaje  
        echo $error->getMessage();

    }
    
    

?>