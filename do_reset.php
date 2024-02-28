<?php
// Include your database connection file
require 'db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the token and password from the form
    $password_reset_token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if password and confirm password are the same
    if ($password != $confirm_password) {
        echo json_encode(['error' => 'Passwords do not match.']);
        exit();
    }

    // Check if password is at least 6 characters long and does not contain any special characters
    if (strlen($password) < 6 || preg_match('/[#^?]/', $password)) {
        echo json_encode(['error' => 'Password must be at least 6 characters long and cannot contain any special characters such as #, ^, ?.']);
        exit();
    }

    // Hash the password
    $hashed_password = hash('sha256', md5($password));

    // Prepare an SQL statement to check if the token exists in the database
    $stmt = $conn->prepare("SELECT * FROM player WHERE password_reset_token = ?");
    $stmt->bind_param("s", $password_reset_token);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if the token exists
    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();

        // Check if the last password reset was more than 1 day ago
        if ($user['last_password_reset'] && (time() - strtotime($user['last_password_reset'])) < 86400) {
            echo json_encode(['error' => 'You can only reset your password once every 24 hours.']);
            exit();
        }

        // Prepare an SQL statement to update the password and reset the token for the user with the matching token
        $stmt = $conn->prepare("UPDATE player SET password = ?, password_reset_token = NULL, last_password_reset = NOW() WHERE password_reset_token = ?");
        $stmt->bind_param("ss", $hashed_password, $password_reset_token);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(['success' => 'Password has been reset. You can now log in with your new password.']);
        } else {
            echo json_encode(['error' => 'Error: ' . $stmt->error]);
        }
    } else {
        echo json_encode(['error' => 'Invalid token. Please generate a token by going in "Forgot password?" option in the login form.']);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid request.']);
}
