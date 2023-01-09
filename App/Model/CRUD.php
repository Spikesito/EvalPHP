<?php

namespace App\Model;

use PDO;

class Crud extends Core
// class Catalog

{
    function getFields($table): string
    {
        $db = static::getDB();
        $statement = $db->prepare("DESCRIBE $table");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_COLUMN);
        array_shift($result);
        return implode(', ', $result);
    }

    // function getValuesBy

    public function CrudData($method, $tableName, $strValues)
    {
        $db = static::getDB();
        $strFields = $this->getFields($tableName);
        switch ($method) {
            case 'C':
                echo "user ajouté";
                echo '\n';
                $stmt = $db->query("INSERT INTO $tableName ($strFields) VALUES ($strValues)");
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                break;
            case 'R':
            case 'U':
                // $stmt = $db->prepare('UPDATE' . $tableName . 'SET id = ?, name = ?, email = ?, phone = ?, title = ?, created = ? WHERE id = ?');
                // $stmt->execute($strValues);
                // $msg = 'Updated Successfully!';
                // return $stmt->fetchAll(PDO::FETCH_ASSOC);
                // break;
            case 'D':
                $strValues = explode(',',$strValues);
                echo "DELETE FROM $tableName WHERE $strValues[0] = $strValues[1] AND $strValues[2] = $strValues[3]";
                $stmt = $db->query("DELETE FROM $tableName WHERE $strValues[0] = $strValues[1]");
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                break;
        }
    }

}
