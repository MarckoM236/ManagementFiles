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
        if (empty($data['email'])) {
            $errors['email'] = 'The user email field is obligatory';
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

     public function login(){
        $this->render('Auth'.DIRECTORY_SEPARATOR.'login');
    }
    
    public function postLogin($params, $data){
        //validate
        $errors = [];
        $old = [];
        $old['email'] = $data['email'];
        $response = false;

        if (empty($data['email'])) {
            $errors['email'] = 'The user email field is obligatory';
        }
        if (empty($data['password'])) {
            $errors['password'] = 'The user password field is obligatory';
        }

        if (!empty($errors)) {
            $this->fieldValidate('/login',$errors,$old);
            return; // Detener la ejecución
        }

        $where = ['email'=>[$data['email'],'string']];
        $userData = $this->model->getQueryStatement(['name','last_name','password'],$where);

        if($userData['state'] == 'true'){
            if(password_verify($data['password'], $userData['data']['password'])){
                session_regenerate_id(true);
                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['user_name'] = $userData['name'];
                $_SESSION['loggedin'] = true;

                $this->redirectTo('/','Welcome '. $userData['data']['name'] . ' ' . $userData['data']['last_name'],'success_message');
            }
            else{
                $this->redirectTo('/login','User or password are incorrect. Please verify.','error_message');
            }
        }
        else{
            $this->redirectTo('/login','User or password are incorrect. Please verify.','error_message');
        }

        
    }
    public function logout(){
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }


        session_destroy();


        $this->redirectTo('/login', 'successfully logged out.', 'success_message');
    }
}