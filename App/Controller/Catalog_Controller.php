<?php

// namespace App\Controller;


// require 'App/Model/Catalog.php';

use App\Model\Catalog;
use App\Model\Product;

// echo $_SESSION['connected'];
// echo var_dump($_SESSION['data']);

class Cat extends Catalog
{

    public function displayCatalog()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/View/templates');
        $twig = new \Twig\Environment($loader, [
            'cache' => false // __DIR__ . '/tmp'
        ]);
        $template = $twig->load("catalog.twig");
        // echo 1;
        echo $twig->render($template, [
            'connected' => $_SESSION['connected'],
            'products' => $this::getAll()
        ]);
    }
}

$a = new Cat();
$a->displayCatalog();
// echo var_dump($_SESSION);