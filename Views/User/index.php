<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'head.php');?>

<div class="container content-category-index">
    <div class="head-pages">
        <h4>All Users</h4>
        <div class="content-btn">
            <a href="/userCreate" class="btn btn-success">New User</a>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <th class="text-center">No</th>
            <th class="text-center">Full name</th>
            <th class="text-center">Email</th>
            <th class="text-center">Role</th>
            <th class="text-center">Actions</th>
        </thead>
        <tbody>
            <?php if($users['state'] == 'true'): ?>
                <?php foreach($users['data'] as $key=>$item){ ?>
                    <tr class="text-center">
                        <td><?= ($key + 1) ?></td>
                        <td><?= ucfirst($item['name']) .' '. ucfirst($item['last_name']) ?></td>
                        <td><?= $item['email'] ?></td>
                        <td><?= ucfirst($item['role_name']) ?></td>
                        <td>
                            <a 
                                href="/userEdit/<?= $item['id_user'] ?>" 
                                class="text-primary <?php if (!isset($_SESSION['role']) || !isset($_SESSION['actions']) || !in_array('user.update', $_SESSION['actions']) ) : echo 'disabled'; endif; ?>">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a> 
                            <a href="/userDelete/<?= $item['id_user'] ?>" 
                                class="text-danger user-delete <?php if (!isset($_SESSION['role']) || !isset($_SESSION['actions']) || !in_array('user.delete', $_SESSION['actions']) ) : echo 'disabled'; endif; ?>">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            <?php else: ?>
                <td><?= $categories['message'] ?></td>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'body.php');?>

<script src="/Js/users.js"></script>
