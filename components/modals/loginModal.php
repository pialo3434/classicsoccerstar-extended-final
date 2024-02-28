<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Please login with your classic Soccerstar account.</p>
                <form id="loginFormID">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control bg-secondary text-light" id="usernameID" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control bg-secondary text-light" id="passwordID" name="password" required>
                    </div>
                    <a href="#" class="text-primary" id="forgotPasswordLink">Forgot password?</a>
                </form>
            </div>
            <div class="modal-footer border-top border-secondary">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="loginButtonID">Login</button>
            </div>
        </div>
    </div>
</div>

<?php include 'passwordRecoveryModal.php'; ?>

<script>
    $(document).ready(function() {
        $('#forgotPasswordLink').on('click', function(e) {
            e.preventDefault();
            $('#loginModal').modal('hide');
            $('#passwordRecoveryModal').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });

    });
</script>