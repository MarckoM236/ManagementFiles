<?php 
if(isset($documents['message'])){
    echo $documents['message'];
}
else{
    if(isset($documents['data'])){
        foreach($documents['data'] as $document){ 
?>
            <div class="files" data-id="<?= $document['document_id'] ?>" >
                <i class="fa fa-file fa-5x"></i>
                <label for=""><?= $document['url'] ?></label>
                <label for=""><?= $document['description'] ?></label>
                <label for=""><?= $document['date'] ?></label>
            </div>
<?php 
    }   }
} 
?>

<!-- menu -->
 <div id="menu-file" style="display:none; position:absolute; background:#fff; border:1px solid #ccc; padding:10px;">
    <a href="#" id="edit-file">Edit</a>
    <a href="#" id="delete-file">Delete</a>
    <a href="#" id="download-file">Download</a>
</div>
