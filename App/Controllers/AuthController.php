<?php
include_once('Controller.php');
include_once(MODEL_PATH.'User.php');

class AuthController extends Controller{
    private $model;

    public function __construct(){
        $this->model = new User();
    }

    public function register(){
        $this->render('Auth'.DIRECTORY_SEPARATOR.'register');
    }

    public function registerStore($params,$data){
        //validate
        $errors = [];
        $old = [];
        $old['name'] = $data['name'];
        $old['last_name'] = $data['last_name'];
        $old['email'] = $data['email'];

        if (empty($data['name'])) {
            $errors['name'] = 'The user name field is obligatory';
        }
        if (empty($data['last_name'])) {
            $errors['last_name'] = 'The user last name field is obligatory';
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
            $this->fieldValidate('/register',$errors,$old);
            return; // Detener la ejecución
        }

        //get data POST
        $name = $data['name'];
        $last_name = $data['last_name'];
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $values = ['name'=>$name,'last_name'=>$last_name,'email'=>$email,'password'=>$password];
        $insert = $this->model->insert(['name','last_name','email','password'],$values);


        //redirect to url whit message
        $typeMessage = $insert['state'] == 'true' ? 'success_message' : 'error_message';
        $this->redirectTo('/register',$insert['message'],$typeMessage);
        
    }

    public function login(){}
    public function logout(){}
}