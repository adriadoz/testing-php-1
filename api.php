<?php require 'vendor/autoload.php';

use PokemonApi\Module\PhysicalAttributesPokemonController;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


    $physicalAttributes  = new PhysicalAttributesPokemonController($url);
    $result = $physicalAttributes->__invoke();

    if($result["code"]===200){
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        die($result["data"]);
    }elseif ($result["code"]===404){
        header("HTTP/1.1 404 Not Found");
    }

