<?php 
include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'head.php');
?>


<div class="container content-register">
    <h4>My profile</h4>
    <form method="POST" action="/profileUpdate">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?= isset($profile['data'][0]['name']) ? $profile['data'][0]['name'] : ''; ?>">
            <div id="nameHelp" class="form-text">write your name.</div>
           <?php 
            if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
                echo "<p>{$_SESSION['name']}</p>";
                unset($_SESSION['name']); 
            }
           ?>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last name</label>
            <input type="text" class="form-control" id="last_name" aria-describedby="last_name" name="last_name" value="<?= isset($profile['data'][0]['last_name']) ? $profile['data'][0]['last_name'] : ''; ?>">
            <div id="last_nameHelp" class="form-text">write your last name.</div>
           <?php 
            if (isset($_SESSION['last_name']) && !empty($_SESSION['last_name'])) {
                echo "<p>{$_SESSION['last_name']}</p>";
                unset($_SESSION['last_name']); 
            }
           ?>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" aria-describedby="email" name="email" value="<?= isset($profile['data'][0]['email']) ? $profile['data'][0]['email'] : ''; ?>">
            <div id="emailHelp" class="form-text">write your email address.</div>
           <?php 
            if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
                echo "<p>{$_SESSION['email']}</p>";
                unset($_SESSION['email']); 
            }
           ?>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" aria-describedby="password" name="password" value="">
            <div id="passwordHelp" class="form-text">write your secure password.</div>
           <?php 
            if (isset($_SESSION['password']) && !empty($_SESSION['password'])) {
                echo "<p>{$_SESSION['password']}</p>";
                unset($_SESSION['password']); 
            }
           ?>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm password</label>
            <input type="confirm_password" class="form-control" id="confirm_password" aria-describedby="confirm_password" name="confirm_password" value="">
            <div id="confirm_passwordHelp" class="form-text">Confirm your secure password.</div>
           <?php 
            if (isset($_SESSION['confirm_password']) && !empty($_SESSION['confirm_password'])) {
                echo "<p>{$_SESSION['confirm_password']}</p>";
                unset($_SESSION['confirm_password']); 
            }
           ?>
        </div>
        
        <div class="content-btn-register">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="/" class="btn btn-danger">Cancel</a>
        </div>

    </form>
</div>


<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'body.php');?>