<?php 
@session_start();
include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'head.php');

//old values
$email_old = isset($_SESSION['olds']) && !empty($_SESSION['olds']['email'] ) ? $_SESSION['olds']['email'] : '';

//clear session old
unset($_SESSION['olds']); 

//messages response
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
    <h4>Login</h4>
    
    <form method="POST" action="/postLogin">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" aria-describedby="email" name="email" value="<?= $email_old?>">
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
        
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="/" class="btn btn-danger">Cancel</a>

    </form>
</div>


<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'body.php');?>