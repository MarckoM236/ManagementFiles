$(document).ready(function(){
    //vars
    let id_file = null;
    let id_category = null;

    //open folder
    $('.folders').click(function(){
        id_category = $(this).data('id');
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
        $('.modal-edit-body').html('');
        
        $.ajax({
            url: '/edit/' + id_file,
            method: 'GET',         
            success: function(respuesta) {
                $('.modal-edit-body').html(respuesta);
                $('#modal-edit-document').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error en la petición AJAX:', error);
            }
        });
    });
    //cancel edit form
    $(document).on('click', '.btn-cancel-document', function(e) {
        e.preventDefault();
        $('#modal-edit-document').modal('hide');
    });
    //send edit form
    $(document).on('submit', '#form-edit-document', function(e) {
        e.preventDefault(); 

        let url = $(this).attr('action');

        let formData = new FormData(this);//incluye campos con archivos

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(respuesta) {
                let res = JSON.parse(respuesta);
                if(res.state == true){
                    $('.body-repo-documents').html('');

                    //toast message
                    $('#liveToast .toast-body').html('Document was updated sucessfully.');
                    $('.toast-time').text(new Date().toLocaleTimeString());

                    // show toast
                    let toast = new bootstrap.Toast(document.getElementById('liveToast'));
                    toast.show();
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
                    $('#modal-edit-document').modal('hide');
                }
                else{
                    //toast message
                    $('#liveToast .toast-body').html('<div class="alert alert-success" role="alert">Document was not updated.</div>');
                    $('.toast-time').text(new Date().toLocaleTimeString());

                    // show toast
                    let toast = new bootstrap.Toast(document.getElementById('liveToast'));
                    toast.show();
                }
            },
            error: function(err) {
                console.error("Error:", err);
                //toast message
                $('#liveToast .toast-body').html('<div class="alert alert-danger" role="alert">Document was not updated.</div>');
                $('.toast-time').text(new Date().toLocaleTimeString());

                // show toast
                let toast = new bootstrap.Toast(document.getElementById('liveToast'));
                toast.show();
            }
        });
    });

    //download
    $(document).on('click', '#download-file', function(e) {
        e.preventDefault();
        
    });
});