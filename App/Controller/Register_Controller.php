<?php

use App\Model\User;

class Registration extends User
{

    public function displayRegister()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/View/templates');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);

        $template = $twig->load("register.twig");
        echo $twig->render($template, [
            'connected' => $_SESSION['connected'],
        ]);
    }

    public function checkRegistration($data)
    {
        if (strlen($data['Password']) < 7) {
            return "Please enter a valid password";
        }
        // if (str_contains($data['Password'], "\"!#$%&'()*+,-./:;<>=?@[]\^_`{}|~"ZZ)) {
        // }
        if (!(preg_match('/[a-zA-Z]/', $data['Password']) && preg_match('/\d/', $data['Password']) && preg_match('/[^a-zA-Z\d]/', $data['Password']))) {
            return "Please enter a valid password";
        }
        if (strlen($data['FirstName']) < 2) {
            return "Please enter a first name";
        }
        if (strlen($data['LastName']) < 2) {
            return "Please enter a last name";
        }
        if (strlen($data['FirstName']) < 2) {
            return "Please enter a first name";
        }
        if ($this::emailUsed($data['Email'])) {
            return "Email already Used";
        }
        if ($data['Password'] !== $data['Password2']) {
            return "Both password doesn't match";
        }

        return "ok";
    }
}



$loader = new \Twig\Loader\FilesystemLoader('App/View/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false
]);


$obj = new Registration();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $obj->displayRegister();
} else {
    echo var_dump($_POST);
    $regStatus = $obj->checkRegistration($_POST);
    // echo var_dump($regStatus);
    if ($regStatus === "ok") {
        $_POST['Password'] = md5($_POST['Password']);
        unset($_POST['Password2']);
        echo "'" . implode("', '", array_values($_POST)) . "', '170794'";
        $obj->CrudData('C', "users", "'" . implode("', '", array_values($_POST)) . "', '170794'");
        header("Location: /login", true, 301);
        exit();
    } else {
        // afficher barre rouge avec valeur de $regStatus
        // echo $regStatus;
        $template = $twig->load("register.twig");

        echo $twig->render($template, [
            'connected' => $_SESSION['connected'],
            'status' => $regStatus,
            'statusColor' => 'red'
        ]);
    }
}

// echo $_SESSION['connected'];
// echo var_dump($_SESSION['data']);
