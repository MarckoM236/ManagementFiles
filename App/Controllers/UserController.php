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

    // Get all users list
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

    //load form 'create user page'
    public function create($params,$data){
        if (isset($_SESSION['role']) && isset($_SESSION['actions']) && in_array('user.create', $_SESSION['actions']) ){
            $roles = $this->modelRole->getQuery(['id_rol', 'name']);
            $this->render('User'.DIRECTORY_SEPARATOR.'create',['roles'=>$roles]);
        }
        else{
            $this->render('Errors'.DIRECTORY_SEPARATOR.'403');
        }
    }

    // Create new User
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

    //load form 'edit user page'
    public function edit($params,$data){
        $id_user = isset($params[0]) ? $params[0] : null;
        
        if (isset($_SESSION['role']) && isset($_SESSION['actions']) && in_array('user.update', $_SESSION['actions']) ){
            $roles = $this->modelRole->getQuery(['id_rol', 'name']);

            $query = 'Select us.id_user, us.name,us.last_name,us.email,role.id_rol from users as us inner join roles_users as rus on us.id_user = rus.id_user inner join roles as role on rus.id_role = role.id_rol';
            $where = ['us.id_user'=>$id_user];

            $user = $this->model->customQuery($query,$where);
             
            $this->render('User'.DIRECTORY_SEPARATOR.'edit',['roles'=>$roles,'user'=>$user]);
        }
        else{
            $this->render('Errors'.DIRECTORY_SEPARATOR.'403');
        }
    }

    // Update user and role
    public function update($params,$data){
        $id_user = isset($params[0]) ? $params[0] : null;
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
        
        if(!empty($data['confirm_password']) || !empty($data['password'])){
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
        }
        
        

        if (!empty($errors)) {
            $this->fieldValidate('/userEdit/'.$id_user,$errors,$old);
            return; // Detener la ejecución
        }

        //get data POST
        $name = $data['name'];
        $last_name = $data['last_name'];
        $email = $data['email'];
        $role = $data['role'];
       
        $values = ['name'=>[$name,'string'],'last_name'=>[$last_name,'string'],'email'=>[$email,'string']];
        $fields = ['name','last_name','email'];

         if(!empty($data['password'])){
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $values = array_merge($values,['password'=>[$password,'string']]);
            $fields[] = 'password';
         }

        $where = ['id_user'=>[$id_user,'int']];
        $update = $this->model->update($fields,$values,$where);

        //update role
        $valuesUserRole = ['id_role'=>[$role,'int']];
        $updateRole = $this->modelUserRole->update(['id_role'],$valuesUserRole,$where);
        
        if($update['state'] == 'true' && $updateRole['state'] == 'true'){
            $typeMessage = 'success_message';
            $message = $update['message'] . 'and ' . $updateRole['message'];
        }
        else if(($update['state'] == 'true' && $updateRole['state'] !== 'true') || ($update['state'] !== 'true' && $updateRole['state'] == 'true')){
            $typeMessage = 'success_message';
             $message = $update['message'] . ' but Role ' . $updateRole['message'];
        }
        else{
            $typeMessage = 'error_message';
             $message = $update['message'] . 'and ' . $updateRole['message'];
        }

        //redirect to url whit message
        $this->redirectTo('/allUsers',$message,$typeMessage);
    }

    //Delete user
    public function delete($params,$data){
        $id_user = isset($params[0]) ? $params[0] : null;
        $where = ['id_user'=>$id_user];

        if($this->model->getByParams($where)){
            $user = $this->model->delete($where);
        }
        else{
            $result = ['state'=>'false','message'=>'Error when trying to delete the record, !does not exist'];
        }

        //redirect to url whit message
        $typeMessage = $result['state'] == 'true' ? 'success_message' : 'error_message';
        $this->redirectTo('/allUsers',$result['message'],$typeMessage);   
    }
}