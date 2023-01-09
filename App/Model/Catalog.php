<?php

namespace App\Model;

// require_once __DIR__ . '/../../vendor/autoload.php';

// require 'App/Model/CRUD.php';

use PDO;

class Catalog extends Crud
// class Catalog

{
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query("SELECT * FROM products;");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // return "it works";
    }

    public static function getDetailById($id)
    {
        $db = static::getDB();
        $stmt = $db->query("SELECT * FROM products WHERE ProductId = $id");
        $final = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        $categ = $db->query("SELECT Name FROM category INNER JOIN products ON category.CategoryId = products.CategoryId WHERE ProductId = $id");
        // echo $categ->fetchAll(PDO::FETCH_ASSOC)[0]['Name'];
        $final['Category'] = $categ->fetchAll(PDO::FETCH_ASSOC)[0]['Name'];
        return $final;
    }

}

