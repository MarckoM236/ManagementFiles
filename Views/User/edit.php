<?php 
include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'head.php');
?>


<div class="container content-register">
    <h4>Edit User</h4>
    
    <form method="POST" action="/userUpdate/<?=$user['data'][0]['id_user']?>">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?= $user['data'][0]['name']?>">
            <div id="nameHelp" class="form-text">write the name.</div>
           <?php 
            if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
                echo "<p class='text-danger'>{$_SESSION['name']}</p>";
                unset($_SESSION['name']); 
            }
           ?>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last name</label>
            <input type="text" class="form-control" id="last_name" aria-describedby="last_name" name="last_name" value="<?= $user['data'][0]['last_name']?>">
            <div id="last_nameHelp" class="form-text">write the last name.</div>
           <?php 
            if (isset($_SESSION['last_name']) && !empty($_SESSION['last_name'])) {
                echo "<p class='text-danger'>{$_SESSION['last_name']}</p>";
                unset($_SESSION['last_name']); 
            }
           ?>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" aria-describedby="email" name="email" value="<?= $user['data'][0]['email']?>">
            <div id="emailHelp" class="form-text">write the email address.</div>
           <?php 
            if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
                echo "<p class='text-danger'>{$_SESSION['email']}</p>";
                unset($_SESSION['email']); 
            }
           ?>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" class="form-control" id="role">
                <option value="">Select role</option>
                <?php 
                if(isset($roles['state']) && $roles['state']=='true'):
                    foreach($roles['data'] as $role):?>
                        <option value="<?= $role['id_rol']?>" <?php if($user['data'][0]['id_rol']==$role['id_rol']):?> selected <?php endif;?>)><?= $role['name']?></option>
                    <?php 
                    endforeach;
                endif; ?>
            </select>
             <div id="roleHelp" class="form-text">Select the role for the user.</div>
           <?php 
            if (isset($_SESSION['role_field']) && !empty($_SESSION['role_field'])) {
                echo "<p class='text-danger'>{$_SESSION['role_field']}</p>";
                unset($_SESSION['role_field']); 
            }
           ?>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" aria-describedby="password" name="password" value="">
            <div id="passwordHelp" class="form-text">write a secure password.</div>
           <?php 
            if (isset($_SESSION['password']) && !empty($_SESSION['password'])) {
                echo "<p class='text-danger'>{$_SESSION['password']}</p>";
                unset($_SESSION['password']); 
            }
           ?>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm password</label>
            <input type="password" class="form-control" id="confirm_password" aria-describedby="confirm_password" name="confirm_password" value="">
            <div id="confirm_passwordHelp" class="form-text">Confirm the secure password.</div>
           <?php 
            if (isset($_SESSION['confirm_password']) && !empty($_SESSION['confirm_password'])) {
                echo "<p class='text-danger'>{$_SESSION['confirm_password']}</p>";
                unset($_SESSION['confirm_password']); 
            }
           ?>
        </div>
        
        <div class="content-btn-register">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="/allUsers" class="btn btn-danger">Cancel</a>
        </div>

    </form>
</div>


<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'body.php');?>