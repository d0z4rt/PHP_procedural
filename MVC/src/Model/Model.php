<?php

namespace App\Model;

use App\Constant;


abstract class Model
{

    private static \PDO $pdo;
    
    protected string $table;


    public function __construct()
    {
        try {
            //code...
            static::$pdo = new \PDO('mysql:dbname=' . Constant::DB_NAME . ';host=' . Constant::DB_HOST, Constant::DB_USERNAME, Constant::DB_PASSWORD, [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]);
            $this->table = strtolower(explode('\\', get_class($this))[2] . 's');
        } catch (\PDOException $e) {
            echo $e->getMessage();

            die();
        }
    }

    public function all()
    {
        $query = $this->getPDO()->query("SELECT * FROM {$this->table}");

        return $query->fetchAll();
    }

    public function getPDO(): \PDO
    {
        return static::$pdo;
    }
}
