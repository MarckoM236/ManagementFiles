<?php
namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;

class UserController extends Controller{
    private $model;
    private $modelRole;
    private $modelUserRole;

    public function __construct(){
        $this->model = new User();
        $this->modelRole = new Role();
        $this->modelUserRole = new UserRole();
    }

    public function index(){
        if (isset($_SESSION['role']) && isset($_SESSION['actions']) && in_array('user.query', $_SESSION['actions']) ){
            $query = 'Select us.id_user, us.name,us.last_name,us.email,role.name as role_name from users as us inner join roles_users as rus on us.id_user = rus.id_user inner join roles as role on rus.id_role = role.id_rol';

            $users = $this->model->customQuery($query);
            
            $this->render('User'.DIRECTORY_SEPARATOR.'index',['users'=>$users]);
        }
        else{
            $this->render('Errors'.DIRECTORY_SEPARATOR.'403');
        }
    }

    //load form 'create page'
    public function create($params,$data){
        if (isset($_SESSION['role']) && isset($_SESSION['actions']) && in_array('user.create', $_SESSION['actions']) ){
            $roles = $this->modelRole->getQuery(['id_rol', 'name']);
            $this->render('User'.DIRECTORY_SEPARATOR.'create',['roles'=>$roles]);
        }
        else{
            $this->render('Errors'.DIRECTORY_SEPARATOR.'403');
        }
    }

    public function store($params,$data){
        //validate
        $errors = [];
        $old = [];
        $old['name'] = $data['name'];
        $old['last_name'] = $data['last_name'];
        $old['email'] = $data['email'];
        $old['role'] = $data['role'];

        if (empty($data['name'])) {
            $errors['name'] = 'The user name field is obligatory';
        }
        if (empty($data['last_name'])) {
            $errors['last_name'] = 'The user last name field is obligatory';
        }
        if (empty($data['email'])) {
            $errors['email'] = 'The user email field is obligatory';
        }
        if (empty($data['role'])) {
            $errors['role_field'] = 'The user role field is obligatory';
        }
        if (empty($data['password'])) {
            $errors['password'] = 'The user password field is obligatory';
        }
        if (empty($data['confirm_password'])) {
            $errors['confirm_password'] = 'The user confirm password field is obligatory';
        }
        if ($data['confirm_password'] !== $data['password']) {
            $errors['confirm_password'] = 'The user confirm password and the user password are not the same';
        }
        if ((strlen($data['confirm_password']) < 8) || strlen($data['password']) < 8 ) {
            $errors['password'] = 'The password must contain a minimum of 8 characters.';
        }
        

        if (!empty($errors)) {
            $this->fieldValidate('/userCreate',$errors,$old);
            return; // Detener la ejecución
        }

        //get data POST
        $name = $data['name'];
        $last_name = $data['last_name'];
        $email = $data['email'];
        $role = $data['role'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $values = ['name'=>$name,'last_name'=>$last_name,'email'=>$email,'password'=>$password];
        $insert = $this->model->insert(['name','last_name','email','password'],$values);

        if($insert['state']=='true'){
            $valuesUserRole = ['id_role'=>$role,'id_user'=>$insert['id']];
            $insertRole = $this->modelUserRole->insert(['id_role','id_user'],$valuesUserRole);
        }


        //redirect to url whit message
        $typeMessage = $insert['state'] == 'true' ? 'success_message' : 'error_message';
        $this->redirectTo('/allUsers',$insert['message'],$typeMessage);
    }
}