<?php
namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Document;
use App\Models\Category;

class DocumentController extends Controller{
    private $model;
    private $modelCategory;

    public function __construct(){
        $this->model = new Document();
        $this->modelCategory = new Category();
    }

    //initial load page
    public function index($params,$data){
        
        $sql = "SELECT CONCAT(user.name,' ',user.last_name) as user_name, category.name as category_name, documents.id_document as document_id, documents.description as description,documents.url as url
                FROM documents 
                LEFT JOIN users As user ON user.id_user = documents.id_user
                LEFT JOIN categories As category ON category.id_category = documents.id_category";

        $result = $this->model->customQuery($sql,[]);

        $this->render('Document'.DIRECTORY_SEPARATOR.'index',["result"=>$result]);
    }

    //load form 'create page'
    public function create($params,$data){
        $categories = $this->modelCategory->getQuery(['id_category','name']);
        $this->render('Document'.DIRECTORY_SEPARATOR.'create',['categories'=>$categories]);
    }

    //get data by method post and  create register
    public function store($params,$data,$files){
        //validate
        $errors = [];
        $old = [];
        $old['description'] = $data['description'];
        $old['category'] = $data['category'];
        $old['date'] = $data['date'];
        $old['file'] = $files['file'];

        if (empty($data['description'])) {
            $errors['description'] = 'The Description field is obligatory';
        }
        if (empty($data['category'])) {
            $errors['category'] = 'The Category field is obligatory';
        }
        if (empty($data['date'])) {
            $errors['date'] = 'The Date field is obligatory';
        }
        if (!isset($files['file']) || $files['file']['error'] == UPLOAD_ERR_NO_FILE) {
            $errors['file'] = 'The File field is obligatory';  
        }

        if (!empty($errors)) {
            $this->fieldValidate('/create',$errors,$old);
            return; // Detener la ejecución
        }

        //get data POST
        $description = $data['description'];
        $category = $data['category'];
        $date = $data['date'];
        $evidence = "";
    
        try {
            if (isset($files) && $files['file']['error'] == UPLOAD_ERR_OK) {
                $fileTmpPath = $files['file']['tmp_name'];
                $fileName = $files['file']['name'];
                $fileSize = $files['file']['size'];
                $fileType = $files['file']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
        
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        
                $uploadFileDir = BASE_PATH.'Public'.DIRECTORY_SEPARATOR.'Storage'.DIRECTORY_SEPARATOR;
                $dest_path = $uploadFileDir . $newFileName;

                if (!is_dir($uploadFileDir)) {
                    die("El directorio $uploadFileDir no existe");
                }

                if (!is_writable($uploadFileDir)) {
                    die("El directorio $uploadFileDir no tiene permisos de escritura");
                }

        
                if(move_uploaded_file($fileTmpPath, $dest_path)) {
                    $evidence = $newFileName;
                } else {
                    //$message = 'There was some error moving the file to upload directory.';
                    die("Error al mover el archivo desde $fileTmpPath hacia $dest_path");
                }
            } 

            $values = ['id_category'=>$category,'description'=>$description,'url'=>$evidence,'date'=>$date];
            $insert = $this->model->insert(['id_category','description','url','date'],$values);
        } catch (\Throwable $th) {
            die("Error al cargar el documento: " . $th->getMessage());
        }


        //redirect to url whit message
        $typeMessage = $insert['state'] == 'true' ? 'success_message' : 'error_message';
        $this->redirectTo('/',$insert['message'],$typeMessage);

    }

    //update register
    public function update($params,$data, $files){
        $id_document = isset($params[0]) ? $params[0] : null;
        //validate
        $errors = [];
        $old = [];

        if (empty($data['description'])) {
            $errors['description'] = 'The Description field is obligatory';
        }
        if (empty($data['category'])) {
            $errors['category'] = 'The Category field is obligatory';
        }
        if (empty($data['date'])) {
            $errors['date'] = 'The Date field is obligatory';
        }

        //validate only not exits fiel old
        if (!isset($data['file_exits']) && (!isset($files['file']) || $files['file']['error'] == UPLOAD_ERR_NO_FILE)) {
                $errors['file'] = 'The File field is obligatory';  
        }

        if (!empty($errors)) {
            $this->fieldValidate('/edit/'.$id_document,$errors,$old);
            return; // Detener la ejecución
        }

        
        //get data POST
        $description = $data['description'];
        $category = $data['category'];
        $date = $data['date'];
        $evidence = $data['file_exits'] ?? "";
    
        try {
            if (isset($files) && $files['file']['error'] == UPLOAD_ERR_OK) {
                $fileTmpPath = $files['file']['tmp_name'];
                $fileName = $files['file']['name'];
                $fileSize = $files['file']['size'];
                $fileType = $files['file']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
        
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        
                $uploadFileDir = BASE_PATH.'Public'.DIRECTORY_SEPARATOR.'Storage'.DIRECTORY_SEPARATOR;
                $dest_path = $uploadFileDir . $newFileName;

                if (!is_dir($uploadFileDir)) {
                    die("El directorio $uploadFileDir no existe");
                }

                if (!is_writable($uploadFileDir)) {
                    die("El directorio $uploadFileDir no tiene permisos de escritura");
                }

        
                if(move_uploaded_file($fileTmpPath, $dest_path)) {
                    $evidence = $newFileName;

                    //delete fiel old
                    if(isset($data['file_exits'])){
                        if(file_exists($uploadFileDir.$data['file_exits'])){
                            unlink($uploadFileDir.$data['file_exits']);
                        }
                    }

                } else {
                    //$message = 'There was some error moving the file to upload directory.';
                    die("Error al mover el archivo desde $fileTmpPath hacia $dest_path");
                }
            } 

            $values = ['id_category'=>$category,'description'=>$description,'url'=>$evidence,'date'=>$date];

            //function update of the model
            //--
            
        } catch (\Throwable $th) {
            die("Error al cargar el documento: " . $th->getMessage());
        }
        
    }

    //load form 'edit page'
    public function edit($params,$data){
        $categories = $this->modelCategory->getQuery(['id_category','name']);
        $where = isset($params[0]) ? ['id_document'=>$params[0]] : [];
        $document = $this->model->getQuery(['*'],$where);

        $this->render('Document'.DIRECTORY_SEPARATOR.'edit',['categories'=>$categories,'document'=>$document]);
    }

    //delete a register and file if exist by id
    public function delete($params,$data){
        $where = isset($params[0]) ? ['id_document'=>$params[0]] : [];

        if($this->model->getByParams($where)){
            $queryDocument = $this->model->getQuery(['url'],$where);
            
            $urlDocument = $queryDocument['state'] == 'true' && $queryDocument['data'][0]['url'] != "" ? $queryDocument['data'][0]['url'] : "";
            if($urlDocument != ""){
                if(file_exists(BASE_PATH.'Public'.DIRECTORY_SEPARATOR.'Storage'.DIRECTORY_SEPARATOR.$urlDocument)){
                    if (unlink(BASE_PATH.'Public'.DIRECTORY_SEPARATOR.'Storage'.DIRECTORY_SEPARATOR.$urlDocument)) {
                        $result = $this->model->delete($where);
                    } else {
                        $result = ['state'=>'false','message'=>'Error when trying to delete the registry'];
                    }
                }
                else{
                    $result = ['state'=>'false','message'=>'file does not exist '.BASE_PATH.'Public'.DIRECTORY_SEPARATOR.'Storage'.$urlDocument];
                }
            }
            else{
                $result = $this->model->delete($where);
            }
        }
        else{
            $result = ['state'=>'false','message'=>'Error when trying to delete the record, !does not exist'];
        }

        //redirect to url whit message
        $typeMessage = $result['state'] == 'true' ? 'success_message' : 'error_message';
        $this->redirectTo('/',$result['message'],$typeMessage);
        
    }
}