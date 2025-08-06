<?php
include_once('Model.php');

class Document extends Model {

    protected $table = "documents";

    protected $allowedColumns = ['id', 'id_user', 'id_category', 'description', 'url', 'date'];
}