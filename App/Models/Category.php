<?php
include_once('Model.php');

class Category extends Model{
    protected $table = "categories";

    protected $allowedColumns = ['id_category', 'name', 'description','*'];
}