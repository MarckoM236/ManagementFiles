<?php
namespace App\Models;

use App\Models\Model;

class User extends Model{
    protected $table = "users";

    protected $allowedColumns = ['id', 'name', 'last_name', 'email', 'password'];
}