<?php
include_once('Controller.php');
include_once(MODEL_PATH.'Category.php');

class CategoryController extends Controller{
    private $model;

    public function __construct(){
        $this->model = new Category();
    }

    public function index(){
        $categories = $this->model->getQuery(['*']);
        $this->render('Category'.DIRECTORY_SEPARATOR.'index',['categories'=>$categories]);
    }

    //load form 'create page'
    public function create($params,$data){
        $this->render('Category'.DIRECTORY_SEPARATOR.'create');
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

        $values = ['name'=>$name,'description'=>$description];
        $insert = $this->model->insert(['name','description'],$values);


        //redirect to url whit message
        $typeMessage = $insert['state'] == 'true' ? 'success_message' : 'error_message';
        $this->redirectTo('/allCategories',$insert['message'],$typeMessage);

    }
}