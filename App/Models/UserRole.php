<?php
namespace App\Models;

use App\Models\Model;

class UserRole extends Model{
    protected $table = "roles_users";

    protected $allowedColumns = ['id_role', 'id_user'];
}