<?php
    /*
    //-----------------------------RUTAS PROYECTO LOCAL----------------------------------
    //ruta de la carpeta del proyecto
    define("DIR_RAIZ","/laboratorios/Proyecto");
   
    //indica la ruta del frond-end del proyecto
    define("FRONT_END_PATH",$_SERVER["DOCUMENT_ROOT"].DIR_RAIZ);
    //indica la ruta back-end del proyecto
    define("BACK_END_PATH", FRONT_END_PATH."/admin");

    //indica la url del frond-end del proyecto
    define("FRONT_END_URL" , $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"].DIR_RAIZ);
    //indica la url del back-end del proyecto
    define("BACK_END_URL",FRONT_END_URL."/admin");

    //indica la ruta de la carpeta uploads
    define("UPLOADS",FRONT_END_PATH."/imagen/uploads");
    //indica la url de la carpeta uploads
    define("UPLOADS_URL",FRONT_END_URL."/imagen/uploads");
    */
    


    
    //-----------------------------RUTAS EN EL SERVIDOR-----------------------------------------
    
    define("DIR_RAIZ",$_SERVER['DOCUMENT_ROOT']);
    define("FRONT_END_PATH",DIR_RAIZ);
    define("BACK_END_PATH",FRONT_END_PATH."/admin");

    define("FRONT_END_URL","http://wxylokxy.micerino.urltemporal.com");
    define("BACK_END_URL","http://wxylokxy.micerino.urltemporal.com/admin");
    
    //define("UPLOADS",FRONT_END_PATH."/imagen/uploads");
    define("UPLOADS","../imagen/uploads");
    
    define("UPLOADS_URL","http://wxylokxy.micerino.urltemporal.com/imagen/uploads");
    
    
    
    
    

/*
    echo "directorio raiz: ".DIR_RAIZ;
    echo "<br>";
    echo "ruta del frond-end del proyecto: ".FRONT_END_PATH;
    echo "<br>";
    echo "ruta del back-end del proyecto: ".BACK_END_PATH;
    echo "<br>";
    echo "url del frond-end del proyecto: ".FRONT_END_URL;
    echo "<br>";
    echo "url del back-end del proyecto: ".BACK_END_URL;
    echo "<br>";
    echo "UPLOADS_URL: ".UPLOADS_URL;
    echo "<br>";
    echo "UPLOADS: " .UPLOADS;
    
*/
    
    
    
    
    
    

?>