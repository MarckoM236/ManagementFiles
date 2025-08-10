<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'head.php');?>

<div class="container content-category">
    <h4>Create category</h4>
    
    <form method="POST" action="/categoryUpdate/<?= isset($category['data'][0]['id_category']) ? $category['data'][0]['id_category'] : ''?>" >
        <div class="mb-3">
            <label for="name" class="form-label">Category name</label>
            <input type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?= isset($category['data'][0]['name']) ? $category['data'][0]['name'] : '' ?>">
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
            <input type="text" class="form-control" id="description" aria-describedby="description" name="description" value="<?= isset($category['data'][0]['description']) ? $category['data'][0]['description'] : '' ?>">
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
            <a href="/allCategories" class="btn btn-danger">Cancel</a>
        </div>

    </form>
</div>


<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'body.php');?>