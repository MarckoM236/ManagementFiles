<?php 
if(isset($documents['message'])) :
    echo $documents['message'];

else :
    if(isset($documents['data'])) :
        foreach($documents['data'] as $document) :
?>
            <div class="files" data-id="<?= $document['document_id'] ?>" >
                <i class="fa fa-file fa-5x"></i>
                <label for=""><?= $document['url'] ?></label>
                <label for=""><?= $document['description'] ?></label>
                <label for=""><?= $document['date'] ?></label>
            </div>
<?php 
        endforeach;   
    endif;
endif;
?>

<!-- menu -->
 <div id="menu-file" style="display:none; position:absolute; background:#fff; border:1px solid #ccc; padding:10px;">
    <a href="#" id="edit-file" <?php if (!isset($_SESSION['role']) || !isset($_SESSION['actions']) || !in_array('document.update', $_SESSION['actions']) ) : echo 'class="disabled" onclick="return false;"'; endif; ?>>Edit</a>
    <a href="#" id="delete-file" <?php if (!isset($_SESSION['role']) || !isset($_SESSION['actions']) || !in_array('document.delete', $_SESSION['actions']) ) : echo 'class="disabled" onclick="return false;"'; endif; ?>>Delete</a>
    <a href="#" id="download-file" <?php if (!isset($_SESSION['role']) || !isset($_SESSION['actions']) || !in_array('document.download', $_SESSION['actions']) ) : echo 'class="disabled" onclick="return false;"'; endif; ?>>Download</a>
</div>
