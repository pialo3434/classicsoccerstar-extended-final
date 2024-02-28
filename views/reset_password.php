<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <!-- Add SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <style>
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Increase the width of the form-container */
        .form-container {
            width: 30%;
            /* Adjust this value to your preference */
        }

        /* Adjust the width of the button */
        .btn-block {
            width: 30%;
            /* Adjust this value to your preference */
            margin: auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="form-container bg-dark text-white p-5 rounded">
            <h2 class="text-center">Password Reset</h2>
            <form id="resetForm" action="../do_reset.php" method="post">
                <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                <div class="form-group">
                    <label for="password">New Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                </div>
                <input type="submit" value="Reset Password" class="btn btn-primary btn-block">
            </form>
        </div>
    </div>

    <!-- Add SweetAlert JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#resetForm').on('submit', function(e) {
                e.preventDefault();

                // Get the password and confirm password values
                var password = $('#password').val();
                var confirm_password = $('#confirm_password').val();

                // Check if password is at least 6 characters long and does not contain any special characters
                if (password.length < 6 || /[#^?]/.test(password)) {
                    Swal.fire('Error', 'Password must be at least 6 characters long and cannot contain any special characters such as #, ^, ?.', 'error');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            Swal.fire({
                                title: 'Success',
                                text: data.success,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location = 'http://classicsoccerstar-extended.ct8.pl/index.php?page='; // Change this to your home page URL
                                }
                            });
                            // Clear the form fields
                            $('#password').val('');
                            $('#confirm_password').val('');
                        } else if (data.error) {
                            Swal.fire('Error', data.error, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'An error occurred.', 'error');
                    }
                });
            });
        });
    </script>




</body>

</html>