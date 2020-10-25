<?php


namespace app\interfaces;

interface IRepository
{
    public function getOne($id);
    public function getAll();
    public function getTableName();
    public function getEntityClass();
}