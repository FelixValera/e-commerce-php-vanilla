<?php

if(isset($_POST['enviar'])){

    $nombre=trim($_POST['nombre']);
    $email=trim($_POST['email']);
    $mensaje=trim($_POST['mensaje']);

    $patron_nombre="/^[^\d][A-Záéíóú\S][^\d]{2,20}$/i";
    $patron_email="/^[A-Z\S]+@[A-Z]+\.[A-Z]{3}$/i";
    $patron_mensaje="/.{5,100}$/i";

    if(!preg_match($patron_nombre,$nombre)){

        header("location:./?page=contacto&rta=001");
    }
    elseif(!preg_match($patron_email,$email)){

        header("location:./?page=contacto&rta=002");

    }
    elseif(!preg_match($patron_mensaje,$mensaje)){

        header("location:./?page=contacto&rta=003");

    }

    else{

        $para="aristidesganzon@gmail.com";
        $asunto="Consulta de cliente";
        $cuerpo="<h1>ComercioIT-Datos de contacto</h1><br>nombre: ".$nombre."<br>email: ".$email."<br>mensaje: <br>".$mensaje;

        // "From" cabecera que indica el remitente, \r= retorno de carro, \n= salto de linea -> esto se usa para concatenar cabeceras 
        $cabecera="From: Tienda online<comercio@it.com>\r\n";
        $cabecera.="Content-type: text/html; charset=utf-8\r\n";
        // "Cc" cabecera para mandar copia a varios correos electronicos 
        //$cabecera.="Cc: felix_gr1995@hotmail.com,fretear@gmail.com\r\n";
        // "Bcc" esta cabecera sirve para mandar una copia oculta  
        //$cabecera.="Bcc: ja7715184@gmail.com\r\n";

        if(mail($para,$asunto,$cuerpo,$cabecera)){

            header("location:./?page=contacto&rta=004");
        }
        else{

            header("location:./?page=contacto&rta=005");
        }
    }

}
else{

    header("location:./?page=contacto");
}

?>