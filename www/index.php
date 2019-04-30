<?php

use Core\Routing;

function myAutoloader($class)
{
    $classname = substr($class, strpos($class, '\\') + 1);

    $classPath = "Core/".$classname.".php";
    $classModel = "Models/".$classname.".php";
    $classForm = "Form/".$classname.".php";
    $classRepository = "Repository/".$classname.".php";

    if (file_exists($classPath)) {
        require $classPath;
    } elseif (file_exists($classModel)) {
        require $classModel;
    } elseif (file_exists($classForm)) {
        require $classForm;
    } elseif (file_exists($classRepository)) {
        require $classRepository;
    }
}

// La fonction myAutoloader est lancé sur la classe appelée n'est pas trouvée
spl_autoload_register('myAutoloader');

// Récupération des paramètres dans l'url - Routing
$slug = explode('?', $_SERVER['REQUEST_URI'])[0];
$routes = Routing::getRoute($slug);
// TODO: enlever extract
extract($routes);

$container = [];
$container['config'] = require 'config/global.php';
$container += require 'config/di.global.php';

// Vérifie l'existence du fichier et de la classe pour charger le controlleur
if (file_exists($cPath)) {
    include $cPath;
    if (class_exists('\\Controller\\' . $c)) {
        //instancier dynamiquement le controller
        $cObject = $container['Controller\\'. $c]($container);
        //vérifier que la méthode (l'action) existe
        if (method_exists($cObject, $a)) {
            //appel dynamique de la méthode
            $cObject->$a();
        } else {
            die('La methode '.$a." n'existe pas");
        }
    } else {
        die('La class controller '.$c." n'existe pas");
    }
} else {
    die('Le fichier controller '.$c." n'existe pas");
}
