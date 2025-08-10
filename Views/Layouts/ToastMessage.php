<?php 
$error_message   = $_SESSION['error_message']   ?? null;
$success_message = $_SESSION['success_message'] ?? null;

unset($_SESSION['error_message'], $_SESSION['success_message']);
?>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <img src="..." class="rounded me-2" alt="...">
      <strong class="me-auto">Notification</strong>
      <small class="toast-time"><?= date("H:i:s") ?></small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <?php if ($error_message): ?>
        <div class="alert alert-danger" role="alert">
            <p><?= htmlspecialchars($error_message) ?></p>
        </div>
      <?php endif; ?>
      <?php if ($success_message): ?>
        <div class="alert alert-success" role="alert">
            <p><?= htmlspecialchars($success_message) ?></p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php if ($error_message || $success_message): ?>
<script>
    $(document).ready(function(){
        var toast = new bootstrap.Toast($('#liveToast')[0]);
        toast.show();
    });
</script>
<?php endif; ?>
