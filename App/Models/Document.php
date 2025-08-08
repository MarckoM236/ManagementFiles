<?php
namespace App\Models;

use App\Models\Model;

class Document extends Model {

    protected $table = "documents";

    protected $allowedColumns = ['id_document', 'id_user', 'id_category', 'description', 'url', 'date','*'];
}