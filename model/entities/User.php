<?php


namespace app\model\entities;

use app\model\Model;

class User extends Model
{
    protected $id;
    protected $first_name;
    protected $last_name;
    protected $age;

    protected $props = [
        'first_name' => false,
        'last_name' => false,
        'age' => false
    ];

    public function __construct($first_name = null, $last_name = null, $age = null)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->age = $age;
    }
}