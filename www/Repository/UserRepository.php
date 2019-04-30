<?php
/**
 * Created by PhpStorm.
 * User: aminejerbouh
 * Date: 29/04/2019
 * Time: 16:46
 */

namespace Repository;

use Core\DbConnectionInterface;
use Models\Users;

class UserRepository
{
    private $dbConnection;
    private $id;
    /**
     * UserRepository constructor.
     * @param $dbconnection
     */
    public function __construct(DbConnectionInterface $dbconnection)
    {
        $this->dbConnection = $dbconnection->connect();
    }

    public function setId($id): void
    {
        $this->id = $id;
        $this->getOneBy(['id' => $id], true);
    }

    /**
     * @param array $where  the where clause
     * @param bool  $object if it will return an array of results ou an object
     *
     * @return mixed
     */
    public function getOneBy(array $where, $object = false)
    {
        $sqlWhere = [];
        foreach ($where as $key => $value) {
            $sqlWhere[] = $key.'=:'.$value;
        }
        $sql = ' SELECT * FROM Users WHERE  '.implode(' AND ', $sqlWhere).';';
        var_dump($sql);
        $query = $this->dbConnection->prepare($sql);

        if ($object) {
            $query->setFetchMode(PDO::FETCH_INTO, $this);
        } else {
            $query->setFetchMode(PDO::FETCH_ASSOC);
        }

        $query->execute($where);

        return $query->fetch();
    }

    public function update($dataSet, $sqlUpdate): void
    {
        $sql = 'UPDATE Users SET '.implode(',', $sqlUpdate).' WHERE id=:id';
        $query = $this->dbConnection->prepare($sql);
        $query->execute($dataSet);
    }

    public function save(Users $users): void
    {

        $dataObject = get_object_vars($users);

        if (is_null($dataObject['id'])) {
            $sql = 'INSERT INTO Users ( '.
                implode(',', array_keys($dataObject)).') VALUES ( :'.
                implode(',:', array_keys($dataObject)).')';

            $query = $this->dbConnection->prepare($sql);
            $query->execute($dataObject);
        } else {
            $sqlUpdate = [];
            foreach ($dataObject as $key => $value) {
                if ('id' != $key) {
                    $sqlUpdate[] = $key.'=:'.$key;
                }
            }
            $this->update($dataObject, $sqlUpdate);
        }
    }
}
