<?php 
@session_start();
include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'head.php');

//old values
$name_old = isset($_SESSION['olds']) && !empty($_SESSION['olds']['name'] ) ? $_SESSION['olds']['name'] : '';
$description_old = isset($_SESSION['olds']) && !empty($_SESSION['olds']['description'] ) ? $_SESSION['olds']['description'] : '';

//clear session old
unset($_SESSION['olds']); 
?>


<div class="container content-category">
    <h4>Create category</h4>
    
    <form method="POST" action="/categoryStore">
        <div class="mb-3">
            <label for="name" class="form-label">Category name</label>
            <input type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?= $name_old?>">
            <div id="nameHelp" class="form-text">write description</div>
           <?php 
            if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
                echo "<p>{$_SESSION['name']}</p>";
                unset($_SESSION['name']); 
            }
           ?>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" aria-describedby="description" name="description" value="<?= $description_old?>">
            <div id="descriptionHelp" class="form-text">write description</div>
           <?php 
            if (isset($_SESSION['description']) && !empty($_SESSION['description'])) {
                echo "<p>{$_SESSION['description']}</p>";
                unset($_SESSION['description']); 
            }
           ?>
        </div>
        
        <div class="content-btn-category">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="/" class="btn btn-danger">Cancel</a>
        </div>

    </form>
</div>


<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'body.php');?>