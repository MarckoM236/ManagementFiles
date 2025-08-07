<?php
namespace App\Models;

use App\Models\Model;

class Category extends Model{
    protected $table = "categories";

    protected $allowedColumns = ['id_category', 'name', 'description','id_user','*'];
}