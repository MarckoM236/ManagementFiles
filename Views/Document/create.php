<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'head.php');?>

<div class="container">
    <h4>Carga de archivo</h4>
    
    <form method="POST" action="/store" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="deescription" aria-describedby="description" name="description">
            <div id="descriptionHelp" class="form-text">write description</div>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select name="category" id="category" class="form-control">
                <option value="" selected>Select a category</option>
                <?php 
                    if(isset($categories) && $categories['state']==true){
                        foreach($categories['data'] as $category){
                ?>
                        <option value="<?= $category['id_category']?>"><?= $category['name']?></option>
                <?php
                        }
                    } 
                ?>
            </select>
            <div id="categoryHelp" class="form-text">Categories</div>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Evidence</label>
            <input type="file" class="form-control" id="file" aria-describedby="file" name="file">
            <div id="fileHelp" class="form-text">charge a evidence</div>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">date</label>
            <input type="datetime-local" class="form-control" id="date" aria-describedby="date" name="date">
            <div id="dateHelp" class="form-text">select the date</div>
        </div>
        
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="/" class="btn btn-danger">Cancel</a>

    </form>
</div>


<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'body.php');?>