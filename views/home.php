<!DOCTYPE html>
<html>

<head>
    <?php include './styles/header.php'; ?>


    <style>
        .home-img-card {
            height: 300px !important;
            max-width: 150px !important;

            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="Home">

        <div style="background-color: rgba(0, 0, 0, 0.5); min-height: 100vh; padding-bottom: 50px; ">
            <div class="p-5 text-white bg-dark text-center"> <!-- Add 'text-center' here -->
                <h1 class="display-4">Rewards Calendar</h1>
                <p class="lead">
                    Login with your soccerstar classic account in order to claim the rewards
                </p>
                <hr class="my-4" />
                <p class="random-sentence"><i>"Your random sentence here"</i></p>
                <button onclick="location.href='/index.php?page=rewards'" class="btn btn-primary btn-lg">Claim Your Reward</button>

            </div>


            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6 bg-white p-4 rounded">
                        <div class="row">
                            <div class="col-md-8 text-left">
                                <h2>Welcome to Classic Soccerstar!</h2>
                                <p><i>Introduction</i></p>
                                <p style="text-align: left;">
                                    We're thrilled to have you here. Before we dive in, we want to make one thing clear: <strong style="color: red;">This is not RELATED the official project</strong>.
                                </p>
                            </div>
                            <div class="col-md-4">
                                <img class="home-img-card img-fluid" src="assets/train3.png" alt="Information" />
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6 bg-white p-4 rounded">
                        <div class="row">
                            <div class="col-md-4">
                                <img class="home-img-card img-fluid" src="assets/train2.png" alt="Information" style="width: 100%;" />
                            </div>
                            <div class="col-md-8 text-left">
                                <h2>Our Aim</h2>
                                <p><i>Goal and objective with the calendar</i></p>
                                <p style="text-align: left;">
                                    Our aim is to create a space that keeps the players engaged, helps them overcome the challenge of running out of stars, and adds a dash of entertainment to the game. We understand that running out of stars can be frustrating, and we're here to help alleviate that problem.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6 bg-white p-4 rounded">
                        <div class="row">
                            <div class="col-md-8 text-left">
                                <h2>Exciting Rewards</h2>
                                <p><i>Stars, coins, items etc</i></p>
                                <p style="text-align: left">
                                    Besides stars, we are also going to reward coins and maybe who knows random items via loot crates. But that's not confirmed yet, we will at least try!
                                </p>
                            </div>
                            <div className="col-md-4">
                                <img class="home-img-card img-fluid" src="assets/train1.png" alt="Information" style="width: 100%" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php include './styles/footer.php'; ?>
    </div>


</body>

</html>