<?php 
    include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'head.php');

    if (isset($_SESSION['error_message'])) {
        echo "<p>{$_SESSION['error_message']}</p>";
        unset($_SESSION['error_message']); 
    }
    if (isset($_SESSION['success_message'])) {
        echo "<p>{$_SESSION['success_message']}</p>";
        unset($_SESSION['success_message']); 
    }
?>

<div class="container content-documents">
    <div class="head-repo-documents">
        <h4>All Documents</h4>
        <div class="content-btn">
            <a href="/create" class="btn btn-success">Load File</a>
        </div>
    </div>
    
    <div class="content-btn-back none" >
        <a href="/documents" title="back"><i class="fa fa-undo fa-2x" aria-hidden="true"></i></a>
    </div>
    <div class="body-repo-documents">
        <?php 
            if(isset($categories['state']) && $categories['state'] == true && isset($categories['data'])){
                foreach($categories['data'] as $category){ 
        ?>
                <div class="folders" data-id="<?= $category['id_category'] ?>">
                    <i class="fa fa-folder fa-5x"></i>
                    <label for=""><?= $category['name'] ?></label>
                </div>
        <?php 
                } 
            }
            else{
        ?>
                <div class="folders">Not found categories.</div>
        <?php
            }
        ?>
    </div>
</div>

<!-- modal edit-->
<div class="modal fade" id="modal-edit-document" tabindex="-1" aria-labelledby="modal-edit-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-edit-label"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-edit-body" id="modal-edit-body">
        ...
      </div>
    </div>
  </div>
</div>

<script src="/Js/documents.js"></script>

<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'body.php');?>