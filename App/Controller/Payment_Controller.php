<?php

// require 'App/Model/Catalog.php';

use App\Model\Cart;

class Payment extends Cart
{
    public function displayHome()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/View/templates');
        $twig = new \Twig\Environment($loader, [
            'cache' => false // __DIR__ . '/tmp'
        ]);

        $template = $twig->load("home.twig");
        // echo 1;
        echo $twig->render($template, [
            'connected' => $_SESSION['connected'],
            'status' => "payment successful",
            'statusColor' => "green"
            // 'products' => $this::getAll(),
        ]);
    }
    public function addToInvoices($pId, $quant)
    {
        $pd = $this::getDetailById($pId);
        if ($pd['Quantity'] < $quant) {
            return "insufficient supply";
        }
        $cartId = $_SESSION['data']['UserId'];
        $totalPrice = $pd['Price'] * $quant;
        $this->CrudData("C", "invoices", "'$cartId','$pId','$quant','$totalPrice'");
        return 'ok';
    }
}

$obj = new Payment();
// call addToInvoices()
$obj->displayHome();
