<?php
namespace App\Models;

use App\Models\Model;

class Role extends Model{
    protected $table = "roles";

    protected $allowedColumns = ['id_rol', 'name'];
}