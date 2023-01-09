<?php

// require 'App/Model/Catalog.php';

use App\Model\Catalog;

class Home extends Catalog
{
    public function displayHome()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/View/templates');
        $twig = new \Twig\Environment($loader, [
            'cache' => false // __DIR__ . '/tmp'
        ]);

        $template = $twig->load("home.twig");
        // echo 1;
        if (!isset($_SESSION['connected'])) {
            $_SESSION['connected'] = false;
        }
        echo $twig->render($template, [
            'connected' => $_SESSION['connected'],
            // 'products' => $this::getAll(),
        ]);
    }
}

$obj = new Home();
$obj->displayHome();
