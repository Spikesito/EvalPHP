<?php

// require 'App/Model/User.php';

use App\Model\Cart;

class UserCart extends Cart
{
    public function displayUserCart()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/View/templates');
        $twig = new \Twig\Environment($loader, [
            'cache' => false // __DIR__ . '/tmp'
        ]);

        $template = $twig->load("cart.twig");
        // echo 1;
        // echo var_dump($this::getCartById($_SESSION['data']['Id']));
        $pIdList = $this::getCartById($_SESSION['data']['Id']);
        $final = [];
        // echo var_dump($pIdList);
        // echo var_dump($this::getDetailById(83253));
        // echo var_dump($this::getDetailById(83309));
        for ($i = 0; $i < sizeof($pIdList); $i++) {
            // echo $pIdList[$i]['ProductId'];
            array_push($final, $this->getDetailById($pIdList[$i]['ProductId']));
        }
        $total = 0;
        for ($i = 0; $i < sizeof($final); $i++) {
            $total += $final[$i]['Price'];
        }
        // echo var_dump($final);
        echo $twig->render($template, [
            'content' => $final,
            'total' => $total,
            'connected' => $_SESSION['connected']
        ]);
    }
}

// echo var_dump($_SESSION);
if (isset($_SESSION['connected']) && $_SESSION['connected'] == true) {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $obj = new UserCart();
        $obj->displayUserCart();
    } else {
        $obj = new UserCart();
        if (isset($_POST['deletePId'])) {
            $status = $obj->deleteFromCart($_POST['deletePId'], 1);
            if ($status == "ok") {
                header("Location: /cart", true, 301);
                exit();
            }
        } else {
            $status = $obj->addToCart($_POST['pId'], 1);
            if ($status == "ok") {
                header("Location: /detail/" . $_POST['pId'], true, 301);
                exit();
            }
        }
    }
} else {
    header("Location: /404", true, 301);
    exit();
    // echo "suicid incoming";
}
