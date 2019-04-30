<?php
declare(strict_types = 1);
namespace Core;

use PDO;

class DbConnection implements DbConnectionInterface
{
    private $pdo;

    public function __construct($driver, $host, $name, $user, $password)
    {
        try {
            $this->pdo = new PDO($driver.':host='.$host.';dbname='.$name, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Erreur SQL : '.$e->getMessage());
        }

        $this->table = get_called_class();
    }

    public function connect(): PDO
    {
        return $this->pdo;
    }
}
