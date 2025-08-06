<?php
namespace App\Models;

use App\Models\Model;

class Document extends Model {

    protected $table = "documents";

    protected $allowedColumns = ['id', 'id_user', 'id_category', 'description', 'url', 'date','*'];
}