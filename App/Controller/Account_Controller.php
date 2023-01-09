<?php

use App\Model\User;

class Account extends User
{
    public function displayAccount()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/View/templates');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);

        $template = $twig->load("account.twig");
        echo $twig->render($template, [
            'connected' => $_SESSION['connected'],
            'data' => $this::getUserById($_SESSION['data']['Id'])
        ]);
    }

    public function checkUpdate($data)
    {
        // echo var_dump($this->getUserById($data['UserId'])['Email']) . " User DATA";
        if (strlen($data['Password']) < 7) {
            return "Please enter a valid password";
        }
        if ($data['Password'] != null) {
            if (!(preg_match('/[a-zA-Z]/', $data['Password']) && preg_match('/\d/', $data['Password']) && preg_match('/[^a-zA-Z\d]/', $data['Password']))) {
                return "Please enter a valid password";
            }
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
        if ($this::emailUsed($data['Email']) && $data['Email'] != $this->getUserById($data['UserId'])['Email']) {
            return "Email already Used";
        }
        if ($data['Password'] !== $data['Password2']) {
            return "Both password doesn't match";
        }

        return "Modification Successful";
    }
}

$obj = new Account;
if (isset($_SESSION['connected']) && $_SESSION['connected'] == true) {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $obj->displayAccount();
    } else {
        echo var_dump($_POST) . " Post DATA";
        $regStatus = $obj->checkUpdate($_POST);
        if ($regStatus === "Modification Successful") {
            $_POST['Password'] = md5($_POST['Password']);
            unset($_POST['Password2']);

            echo "'" . implode("', '", array_values($_POST)) . "', '170794'";
            // $obj->CrudData('C', "users", "'" . implode("', '", array_values($_POST)) . "', '170794'");
            header("Location: /account", true, 301);
            exit();
        } else {
            // afficher barre rouge avec valeur de $regStatus
            // echo $regStatus;
            
            $template = $twig->load("account.twig");
    
            echo $twig->render($template, [
                'connected' => $_SESSION['connected'],
                'status' => $regStatus,
                'statusColor' => 'red',
                'data' => $obj::getUserById($_SESSION['data']['Id'])
            ]);
        }
    }
} else {
    header("Location: /404", true, 301);
    exit();
}