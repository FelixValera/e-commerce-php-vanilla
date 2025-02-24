<?php

    
    include('../ini.php');

    if(isset($_GET['action'])){
        
        require_once('funciones.php');

        $action=$_GET['action'];

        switch($action){

            case 'adduser':
                $nombre=$_POST['nombre'];
                $apellido=$_POST['apellido'];
                $mail=$_POST['email'];
                $pass=$_POST['pass'];

                registrarUsuarios($nombre,$apellido,$mail,$pass);
            break;
            case 'activeUser':
                $mail=$_GET['u'];
                $clave=$_GET['k'];

                activarUsuario($mail,$clave);
            break;
            case 'loginUser':
                $mail=$_POST['email'];
                $pass=$_POST['pass'];

                iniciarSesion($mail,$pass);
            break;
            case 'logoutUser':
                cerrarSesion();
            break;
            case 'recoveryUser':
                $mail=trim($_POST['email']);
                recuperarClave($mail);
            break;
            case 'savePass':
                if(empty($_POST['pass'])){
                    header('location:../?page=ingreso&rta=024');
                }
                $pass=$_POST['pass'];
                $mail=$_POST['mail'];
                $clave=$_POST['clave'];
                guardarClave($pass,$mail,$clave);
            break;

        }   
    }
?>