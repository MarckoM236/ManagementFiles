<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'head.php');?>

<div class="container">
    <h4>All categories</h4>
    <div class="content-btn">
        <a href="/categoryCreate" class="btn btn-success">New category</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <th>No</th>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <?php if($categories['state'] == 'true'): ?>
                <?php foreach($categories['data'] as $key=>$item){ ?>
                    <tr>
                        <td><?= ($key + 1) ?></td>
                        <td><?= $item['name'] ?></td>
                        <td><?= $item['description'] ?></td>
                        <td><a href="/categoryEdit/<?= $item['id_category'] ?>" class="text-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a> <a href="/categoryDelete/<?= $item['id_category'] ?>" class="text-danger category-delete"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                    </tr>
                <?php } ?>
            <?php else: ?>
                <td><?= $categories['message'] ?></td>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'body.php');?>

<script src="/Js/categories.js"></script>
