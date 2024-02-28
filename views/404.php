<?php include './styles/header.php'; ?>

<?php

if (isset($_SESSION['error'])) {
    echo '<script type="text/javascript">
        $(document).ready(function() {
            toastr.error("' . $_SESSION['error'] . '");
        });
    </script>';
    unset($_SESSION['error']); // Remove the error message from the session
}

?>



<div class="d-flex align-items-center justify-content-center" style="background-color: rgba(0, 0, 0, 0.5); min-height: 100vh;">
    <div class="card bg-dark text-white" style="max-width: 500px;">
        <div class="card-body">
            <h1 class="card-title text-center" style="font-size: 7em; color: #17a2b8;">404</h1>
            <h2 class="card-subtitle mb-2 text-center" style="color: #ffc107;">Page Not Found</h2>
            <p class="card-text text-left">The page you are looking for might have been <strong style="color: #28a745;">removed</strong>, had its <strong style="color: #28a745;">name changed</strong>, or is <strong style="color: #28a745;">unavailable</strong>. It could also be possible that you do not have <strong style="color: #28a745;">access to it.</strong></p>
            <div class="text-center">
                <a href="/" class="btn btn-light">Go Home</a>
            </div>
        </div>
    </div>
</div>

<?php include './styles/footer.php'; ?>