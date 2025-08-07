<?php
namespace App\Models;

use App\Models\Model;

class User extends Model{
    protected $table = "users";

    protected $allowedColumns = ['id_user', 'name', 'last_name', 'email', 'password'];
}