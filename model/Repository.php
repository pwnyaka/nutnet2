<?php


namespace app\model;


use app\engine\App;
use app\engine\Db;
use app\interfaces\IRepository;

abstract class Repository implements IRepository
{
    public function getOne($id)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        return App::call()->db->queryObject($sql, ["id" => $id], $this->getEntityClass());
    }

    public function getAll()
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return App::call()->db->queryAll($sql);
    }

    public function insert(Model $entity)
    {
        $fields = [];
        $params = [];

        foreach ($entity->props as $key => $value) {

            $params[":{$key}"] = $entity->$key;
            $fields[] = "`$key`";

        }

        $fields = implode(', ', $fields);
        $values = implode(', ', array_keys($params));
        $sql = "INSERT INTO `{$this->getTableName()}` ({$fields}) VALUES ({$values})";
        App::call()->db->execute($sql, $params);
        $entity->id = App::call()->db->lastInsertId();
    }

    public function update(Model $entity)
    {
        $fields = [];
        $params = [];

        foreach ($entity->props as $key => $value) {
            if ($value) {
                $fields[] = "`{$key}` = :{$key}";
                $params[":{$key}"] = $entity->$key;
                $entity->props[$key] = false;
            }
        }
        $fields = implode(', ', $fields);
        $params[':id'] = $entity->id;

        $sql = "UPDATE `{$this->getTableName()}` SET {$fields} WHERE id =:id";
        App::call()->db->execute($sql, $params);
    }

    public function delete(Model $entity)
    {
        $tableName = $this->getTableName();
        $id = $entity->id;
        $sql = "DELETE FROM {$tableName} WHERE id = :id";
        return App::call()->db->execute($sql, ["id" => $id])->rowCount();
    }

    public function save(Model $entity) {
        if (is_null($entity->id))
            $this->insert($entity);
        else
            $this->update($entity);
    }

    abstract public function getTableName();

    abstract public function getEntityClass();
}