<?php


namespace app\model\repositories;


use app\engine\App;
use app\model\entities\User;
use app\model\Repository;

class UserRepository extends Repository
{
    public function getTableName()
    {
        return "users";
    }

    public function getEntityClass()
    {
        return User::class;
    }

    public function getAdultUsers() {
        $age = 18;
        $sql = "SELECT * FROM `users` WHERE `age`>=:age";
        $users = App::call()->db->queryAll($sql, ['age' => $age]);
        return $users;
    }
}