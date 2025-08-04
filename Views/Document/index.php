<?php 
    @session_start();
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

<div class="container">
    <h4>All Documents</h4>
    <div class="content-btn">
        <a href="/create" class="btn btn-success">Load File</a>
    </div>
    
    <table class="table table-bordered">
        <thead>
            <th>User</th>
            <th>Category</th>
            <th>Description</th>
            <th>url</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <?php if($result['state'] == 'true'){ ?>
                <?php foreach($result['data'] as $item){ ?>
                    <tr>
                        <td><?= $item['user_name'] ?></td>
                        <td><?= $item['category_name'] ?></td>
                        <td><?= $item['description'] ?></td>
                        <td><a href="<?= '/Storage/'.$item['url'] ?>" target="_blank"><?= $item['url'] ?></a></td>
                        <td><a href="/edit/<?= $item['document_id'] ?>" class="text-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a> <a href="/delete/<?= $item['document_id'] ?>" class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <td><?= $result['message'] ?></td>
            <?php } ?>
        </tbody>
    </table>
</div>


<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'body.php');?>