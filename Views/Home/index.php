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
    <div class="content-home-background">
         <img src="/Assets/Images/fondo.png" alt="Management Files">
    </div>
   
</div>


<?php include(VIEW_PATH.'Layouts'.DIRECTORY_SEPARATOR.'body.php');?>