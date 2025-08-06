<?php 
include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'head.php');?>
<div class="container content-load-documents">
    <h4>Edit Evidence</h4>
    
    <form method="POST" action="/update/<?=$document['state']==true ? $document['data'][0]['id_document'] : ''?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" aria-describedby="description" name="description" value="<?= $document['state']==true ? $document['data'][0]['description'] : '' ?>">
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
                <option value="">Select a category</option>
                <?php 
                    if(isset($categories) && $categories['state']==true){
                        foreach($categories['data'] as $category){
                ?>
                        <option value="<?= $category['id_category']?>" <?php if($document['state'] == true && $document['data'][0]['id_category'] == $category['id_category']){ ?> selected <?php } ?>"><?= $category['name']?></option>
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
            <?php if($document['state'] == true && $document['data'][0]['url'] && file_exists(BASE_PATH.'Public'.DIRECTORY_SEPARATOR.'Storage'.DIRECTORY_SEPARATOR.$document['data'][0]['url'])){ ?>
                <a href="<?= '/Public'.DIRECTORY_SEPARATOR.'Storage'.DIRECTORY_SEPARATOR.$document['data'][0]['url'] ?>" target="_blank"> <?= $document['data'][0]['url'] ?> </a>
                <input type="hidden" name="file_exist" value="<?$document['data'][0]['url']?>">
            <?php } else { ?>
                <input type="hidden" name="file_exist" value="">
            <?php } ?>
            <?php 
            if (isset($_SESSION['file']) && !empty($_SESSION['file'])) {
                echo "<p>{$_SESSION['file']}</p>";
                unset($_SESSION['file']); 
            }
           ?>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">date</label>
            <input type="datetime-local" class="form-control" id="date" aria-describedby="date" name="date" value="<?= $document['state']==true ? $document['data'][0]['date'] : '' ?>">
            <div id="dateHelp" class="form-text">select the date</div>
            <?php 
            if (isset($_SESSION['date']) && !empty($_SESSION['date'])) {
                echo "<p>{$_SESSION['date']}</p>";
                unset($_SESSION['date']); 
            }
           ?>
        </div>
        
        <div class="content-btn-documents">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="/documents" class="btn btn-danger">Cancel</a>
        </div>

    </form>
</div>


<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'body.php');?>