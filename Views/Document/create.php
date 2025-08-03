<?php 
@session_start();
include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'head.php');

//old values
$description_old = isset($_SESSION['olds']) && !empty($_SESSION['olds']['description'] ) ? $_SESSION['olds']['description'] : '';
$category_old = isset($_SESSION['olds']) && !empty($_SESSION['olds']['category'] ) ? $_SESSION['olds']['category'] : '';
$date_old = isset($_SESSION['olds']) && !empty($_SESSION['olds']['description'] ) ? $_SESSION['olds']['description'] : '';

//clear session old
unset($_SESSION['olds']); 
?>


<div class="container">
    <h4>Upload Evidence</h4>
    
    <form method="POST" action="/store" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="deescription" aria-describedby="description" name="description" value="<?= $description_old?>">
            <div id="descriptionHelp" class="form-text">write description</div>
           <?php 
            if (isset($_SESSION['description']) && !empty($_SESSION['description'])) {
                echo "<p>{$_SESSION['description']}</p>";
                unset($_SESSION['description']); 
            }
           ?>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select name="category" id="category" class="form-control">
                <option value="" selected>Select a category</option>
                <?php 
                    if(isset($categories) && $categories['state']==true){
                        foreach($categories['data'] as $category){
                ?>
                        <option value="<?= $category['id_category']?>" <?php if($category_old == $category['id_category']){?> selected <?php } ?>><?= $category['name']?></option>
                <?php
                        }
                    } 
                ?>
            </select>
            <div id="categoryHelp" class="form-text">Categories</div>
            <?php 
            if (isset($_SESSION['category']) && !empty($_SESSION['category'])) {
                echo "<p>{$_SESSION['category']}</p>";
                unset($_SESSION['category']); 
            }
           ?>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Evidence</label>
            <input type="file" class="form-control" id="file" aria-describedby="file" name="file">
            <div id="fileHelp" class="form-text">charge a evidence</div>
            <?php 
            if (isset($_SESSION['file']) && !empty($_SESSION['file'])) {
                echo "<p>{$_SESSION['file']}</p>";
                unset($_SESSION['file']); 
            }
           ?>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">date</label>
            <input type="datetime-local" class="form-control" id="date" aria-describedby="date" name="date" value="<?= $date_old?>">
            <div id="dateHelp" class="form-text">select the date</div>
            <?php 
            if (isset($_SESSION['date']) && !empty($_SESSION['date'])) {
                echo "<p>{$_SESSION['date']}</p>";
                unset($_SESSION['date']); 
            }
           ?>
        </div>
        
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="/" class="btn btn-danger">Cancel</a>

    </form>
</div>


<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'body.php');?>