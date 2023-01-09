<?php

namespace App\Model;

// require_once __DIR__ . '/../../vendor/autoload.php';

// require 'App/Model/CRUD.php';

use PDO;

class User extends CRUD
// class Catalog

{

    public static function getUserById($id)
    {
        $db = static::getDB();
        $stmt = $db->query("SELECT * FROM users WHERE UserId = $id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }

    public static function emailUsed($email)
    {
        $db = static::getDB();
        $stmt = $db->query("SELECT * FROM users WHERE Email = '$email'");
        return (sizeof($stmt->fetchAll(PDO::FETCH_ASSOC)) == 0) ? false : true;
    }

    public static function loginMatch($email, $pw)
    {
        $db = static::getDB();
        $stmt = $db->query("SELECT * FROM users INNER JOIN carts WHERE Email = '$email' ");

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // echo var_dump($result);
        if (sizeof($result) == 0) {
            return "wrong login";
        }
        $user = $result[0];
        $userId = $user['UserId'];
        $cartId = $db->query("SELECT * FROM carts WHERE UserId = $userId")->fetchAll(PDO::FETCH_ASSOC)[0]['CartId'];
        if ($email == $user['Email'] && $pw == $user['Password']) {
            return array('Id' => $user['UserId'], 'Name' => $user['FirstName'], 'Role' => $user['Role'], 'CartId' => $cartId);
        }
    }

    public static function createUser($data, $strFields)
    {
        $data = array_values($data);
    }
}
