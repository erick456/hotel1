<?php
defined('BASEPATH') OR exit('No direct script access allowed');

session_start();

@$ini_array = parse_ini_file("config.ini");
$host = $ini_array["host"];


if(empty($host)){

     header('Location:'.base_url().'Login');
     echo '<script>
                alert("Debe llenar los parametros de la base de datos");
                window.location="' . base_url() .' ";
            </script>';

    $host = "";
    $username = "";
    $password = "";
    $bd = "";
    $driver = "";
}else{

    $host = $ini_array["host"];
    $username = $ini_array["usuario"];
    $password = $ini_array["password"];
    $bd = $ini_array["basedatos"];
    $driver = $ini_array["driver"];
}


$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = ''.$host;
$db['default']['username'] = ''.$username;
$db['default']['password'] = ''.$password;
$db['default']['database'] = ''.$bd;
$db['default']['dbdriver'] = ''.$driver;

$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = FALSE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

