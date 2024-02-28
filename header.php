<!DOCTYPE html>
<html>

<head>
    <?php include './styles/header.php'; ?>
</head>


<body>
    <header class="bg-dark text-white p-3">
        <nav class="d-flex justify-content-between align-items-center">
            <img src="assets/icon-main.png" alt="logo" class="logo img-fluid" style="height: 85px !important; width: 100px !important;" /> <!-- Add your logo here -->
            <ul class="nav">
                <li class="nav-item">
                    <a href="/index.php?page=" class="nav-link">HOME</a>
                </li>
                <li class="nav-item">
                    <a href="/index.php?page=faq" class="nav-link">FAQ</a>
                </li>
                <li class="nav-item">
                    <a href="/index.php?page=rewards" class="nav-link">REWARDS</a>
                </li>
                <li class="nav-item">
                    <a href="/index.php?page=shop" class="nav-link">SHOP</a>
                </li>
                <li class="nav-item">
                    <a href="/index.php?page=leaderboard" class="nav-link">SCOREBOARD</a>
                </li>
                <!-- Add more navigation links if needed -->
            </ul>
            <div style="display: flex; gap: 10px;">
                <?php
                if (isset($_SESSION['loggedin']) && $_SESSION['user_id'] == 166) {
                    echo '<button class="btn btn-light" id="resetRewardsButton">Reset Rewards</button>';
                }

                if (isset($_SESSION['loggedin'])) {
                    echo '<a href="./components/comps/logout.php" class="btn btn-light">Logout</a>';
                } else {
                    echo '<button class="btn btn-light" data-toggle="modal" data-target="#loginModal">Login</button>';
                }
                ?>
            </div>
        </nav>
    </header>



    <?php include './styles/footer.php'; ?>
    <?php include './components/modals/loginModal.php'; ?>

    <script>
        $(document).ready(function() {
            $("#resetRewardsButton").click(function() {
                $.post("./reset_rewards.php", function(data, status) {
                    alert("Data: " + data + "\nStatus: " + status);
                });
            });
        });
    </script>
</body>

</html>