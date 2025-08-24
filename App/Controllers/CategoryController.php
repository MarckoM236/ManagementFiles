<?php
namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller{
    private $model;

    public function __construct(){
        $this->model = new Category();
    }

    // Get all categories list
    public function index(){
        if (isset($_SESSION['role']) && isset($_SESSION['actions']) && in_array('category.query', $_SESSION['actions']) ){
            $where = ['id_user'=>$_SESSION['user_id']];
            $categories = $this->model->getQuery(['*'],$where);
            $this->render('Category'.DIRECTORY_SEPARATOR.'index',['categories'=>$categories]);
        }
        else{
            $this->render('Errors'.DIRECTORY_SEPARATOR.'403');
        }
    }

    //load form 'create page'
    public function create($params,$data){
        if (isset($_SESSION['role']) && isset($_SESSION['actions']) && in_array('category.create', $_SESSION['actions']) ){
            $this->render('Category'.DIRECTORY_SEPARATOR.'create');
        }
        else{
            $this->render('Errors'.DIRECTORY_SEPARATOR.'403');
        }
    }

    //get data by method post and  create register
    public function store($params,$data){
        //validate
        $errors = [];
        $old = [];
        $old['name'] = $data['name'];
        $old['description'] = $data['description'];

        if (empty($data['name'])) {
            $errors['name'] = 'The Category name field is obligatory';
        }
        if (empty($data['description'])) {
            $errors['description'] = 'The Description field is obligatory';
        }
        

        if (!empty($errors)) {
            $this->fieldValidate('/categoryCreate',$errors,$old);
            return; // Detener la ejecución
        }

        //get data POST
        $description = $data['description'];
        $name = $data['name'];
        $id_user = $_SESSION['user_id'];

        $values = ['name'=>$name,'description'=>$description,'id_user'=>$id_user];
        $insert = $this->model->insert(['name','description','id_user'],$values);


        //redirect to url whit message
        $typeMessage = $insert['state'] == 'true' ? 'success_message' : 'error_message';
        $this->redirectTo('/allCategories',$insert['message'],$typeMessage);

    }

    //load form 'edit page'
    public function edit($params,$data){
        $id_category = isset($params[0]) ? $params[0] : null;

        if (isset($_SESSION['role']) && isset($_SESSION['actions']) && in_array('category.update', $_SESSION['actions']) ){
            $where = ['id_category'=>$id_category];
            $category = $this->model->getQuery(['*'],$where);
            $this->render('Category'.DIRECTORY_SEPARATOR.'edit',['category'=>$category]);
        }
        else{
            $this->render('Errors'.DIRECTORY_SEPARATOR.'403');
        }
    }

    //Update category
    public function update($params,$data){
        $id_category = isset($params[0]) ? $params[0] : null;
        //validate
        $errors = [];
        $old = [];

        if (empty($data['name'])) {
            $errors['name'] = 'The Name field is obligatory';
        }
        if (empty($data['description'])) {
            $errors['description'] = 'The Description field is obligatory';
        }

        if (!empty($errors)) {
            $this->fieldValidate('/categoryEdit/'.$id_category,$errors,$old);
            return; // Detener la ejecución
        }

        
        //get data POST
        $name = $data['name'];
        $description = $data['description'];
    
        try {

            $values = ['name'=>[$name,'string'],'description'=>[$description,'string']];

            //function update of the model
            $where = ['id_category'=>[$id_category,'int']];
            $categoryUpdate = $this->model->update(['name','description'],$values,$where);

            //--
            
        } catch (\Throwable $th) {
            die("Error al cargar el documento: " . $th->getMessage());
        }

        //redirect to url whit message
        $typeMessage = $categoryUpdate['state'] == true ? 'success_message' : 'error_message';
        $this->redirectTo('/allCategories',$categoryUpdate['message'],$typeMessage);
        
    }

    //Delete category
    public function delete($params,$data){
        $id_category = isset($params[0]) ? $params[0] : null;
        $where = ['id_category'=>$id_category];

        if($this->model->getByParams($where)){
            $result = $this->model->delete($where);
        }
        else{
            $result = ['state'=>'false','message'=>'Error when trying to delete the record, !does not exist'];
        }

        //redirect to url whit message
        $typeMessage = $result['state'] == 'true' ? 'success_message' : 'error_message';
        $this->redirectTo('/allCategories',$result['message'],$typeMessage);
        
    }
}