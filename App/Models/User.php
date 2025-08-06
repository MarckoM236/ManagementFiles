<?php
include_once('Model.php');

class User extends Model{
    protected $table = "users";

    protected $allowedColumns = ['id', 'name', 'last_name', 'email', 'password'];
}