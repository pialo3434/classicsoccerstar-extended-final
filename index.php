<?php
session_start(); // Start the session here

//var_dump($_SESSION);

include 'header.php';


$page = isset($_GET['page']) ? $_GET['page'] : '';

switch ($page) {
    case '':
        require __DIR__ . '/views/home.php';
        break;
    case 'rewards':
    case 'shop':
        if (!isset($_SESSION['loggedin'])) {
            $_SESSION['error'] = "You must be logged in to view this page.";
            http_response_code(404);
            require __DIR__ . '/views/404.php';
        } else {
            require __DIR__ . "/views/$page.php";
        }
        break;
    case 'faq':
        require __DIR__ . '/views/faq.php';
        break;
    case 'leaderboard':
        if (!isset($_SESSION['loggedin'])) {
            $_SESSION['error'] = "You must be logged in to view this page.";
            http_response_code(404);
            require __DIR__ . '/views/404.php';
        } else {
            require __DIR__ . "/views/$page.php";
        }
        break;
    case 'reset_password':
        require __DIR__ . '/views/reset_password.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}

//echo "<p>$connStatus</p>";
?>

<?php include 'footer.php'; ?>e