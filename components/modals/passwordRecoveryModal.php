<!-- Password Recovery Modal -->
<style>
    .alert {
        padding: 10px;
    }

    .alert-info {
        background-color: #0f0;
        color: #fff;
    }

    .alert-danger {
        background-color: #f00;
        color: #fff;
    }
</style>
<div class="modal fade" id="passwordRecoveryModal" tabindex="-1" role="dialog" aria-labelledby="passwordRecoveryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-bottom border-secondary">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h5 class="modal-title" id="passwordRecoveryLabel">Password Recovery</h5>
                </div>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body text-center">
                <div id="step1" class="mt-3">
                    <form id="passwordRecoveryFormID" action="password_recovery.php" method="post">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control bg-secondary text-light" id="emailID" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div id="message" style="display: none;" class="mt-3 alert"></div>
            </div>

            <div class="modal-footer border-top border-secondary justify-content-between">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#passwordRecoveryFormID').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'password_recovery.php',
                data: $(this).serialize(),
                success: function(response) {
                    // Remove any existing classes
                    $("#message").removeClass("alert-info alert-danger");

                    // Add the appropriate class and text based on response
                    if (response.includes("Message has been sent")) {
                        $("#message").addClass("alert-info").text("Email sent successfully!");
                    } else if (response.includes("ERROR")) {
                        $("#message").addClass("alert-danger").text(response);
                    } else {
                        $("#message").addClass("alert-info").text(response);
                    }

                    // Display the message and reset fields after 5 seconds
                    $("#message").show();
                    setTimeout(function() {
                        $("#message").text("").removeClass("alert-info alert-danger");
                        $("#passwordRecoveryFormID").find("input[type='text']").val("");
                    }, 5000);
                }
            });
        });
    });
</script>