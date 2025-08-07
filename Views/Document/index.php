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
            if(isset($categories['state']) && $categories['state'] == true){
                foreach($categories['data'] as $category){ 
        ?>
                <div class="folders" data-id="<?= $category['id_category'] ?>">
                    <i class="fa fa-folder fa-5x"></i>
                    <label for=""><?= $category['name'] ?></label>
                </div>
        <?php 
            } 
                }
        ?>
    </div>
</div>

<script>
    $(document).ready(function(){
        let id_file = null;
        //open folder
        $('.folders').click(function(){
            let id_category = $(this).data('id');
            $('.body-repo-documents').html('');
            $('.content-btn-back').removeClass('none');

            $.ajax({
                url: '/documents/doc/'+id_category, 
                method: 'GET',         
                success: function(respuesta) {
                    $('.body-repo-documents').html(respuesta);
                },
                error: function(xhr, status, error) {
                    console.error('Error en la petición AJAX:', error);
                }
            });

        });

        //not open menu default
        $(document).on('contextmenu', '.files', function(e) {
            e.preventDefault();
        });

        //click right open menu
        $(document).on('mousedown', '.files', function(e) {
            e.preventDefault();
            if (e.which === 3) {
                id_file = $(this).data('id');
                // get icon position
                const offset = $(this).offset();
                const altura = $(this).outerHeight();

                // show menu in the position
                $('#menu-file').css({
                    top: offset.top  + 'px',
                    left: offset.left + 'px'
                }).show();
            }
        });

        //Close the menu
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.folders, #menu-file').length) {
            $('#menu-file').hide();
            }
        });

        //edit
        $(document).on('click', '#edit-file', function(e) {
            e.preventDefault();
            window.open('/edit/' + id_file, '_blank', 'width=800,height=600');
        });
        //download
        $(document).on('click', '#download-file', function(e) {
            e.preventDefault();
            alert('descargar');
        });
    });
</script>

<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'body.php');?>