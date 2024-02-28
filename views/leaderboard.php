<!DOCTYPE html>
<html>

<head>
    <title>Leaderboard</title>
    <style>
        body {
            background-color: #343A40;
            /* Dark gray bg */
            color: #f8f9fa;
            /* Light text */
            margin: 0;
        }

        .wrapper {
            background-color: rgba(52, 58, 64, 0.5);
            /* Slightly transparent dark gray bg */
            min-height: 100vh;
            padding: 20px;
        }

        .tab-content,
        .table-container {
            min-height: 700px;
            max-height: 700px;
            background-color: #495057;
            /* Gray-dark bg */
            margin-bottom: 20px;
            padding: 20px;
            overflow-y: auto;
        }

        .table {
            border-radius: 0;
            width: 100%;
        }

        .table td,
        .table th {
            vertical-align: middle;
            color: #f8f9fa;
            /* Light text */
        }

        .table .club,
        .table .name {
            width: 30%;
        }

        .row {
            align-items: flex-end;
        }

        #player-search-bar {
            background-color: white;
            color: black;
        }

        #club-search-bar {
            background-color: white;
            color: black;
        }

        .search-bar {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            background-color: white;
            /* Gray-dark bg */
            color: #f8f9fa;
            /* Light text */
        }

        .sticky-header {
            position: sticky;
            top: 0;
            background-color: #495057;
            /* Gray-dark bg */
            z-index: 1;
        }

        .nav-tabs .nav-link.active {
            background-color: #007bff;
            /* Bootstrap primary color */
            color: #fff;
            /* White text */
        }

        /* Adjusted podium colors */
        .table tbody tr[data-rank='1'] {
            background-color: #FFCA34 !important;
            /* Gold */
        }

        .table tbody tr[data-rank='2'] {
            background-color: #9FA3A9 !important;
            /* Silver */
        }

        .table tbody tr[data-rank='3'] {
            background-color: #E58356 !important;
            /* Bronze */
        }

        /* Adjusted podium colors */
        .table-clubs .table tbody tr[data-rank='1'] {
            background-color: #FFCA34 !important;
            /* Gold */
        }

        .table-clubs .table tbody tr[data-rank='2'] {
            background-color: #9FA3A9 !important;
            /* Silver */
        }

        .table-clubs .table tbody tr[data-rank='3'] {
            background-color: #E58356 !important;
            /* Bronze */
        }





        /* Adjusted title color */
        #player-title {
            color: #f8f9fa;
            /* Light text */
        }

        /* Adjusted title color */
        #club-title {
            color: #f8f9fa;
            /* Light text */
        }

        .invite-btn {
            background-color: #007BFF;
            /* Blue */
            border: none;
            color: white;
            padding: 5px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
            transition-duration: 0.4s;
            line-height: 1.5;
            /* Add this line */
        }

        .invite-btn:hover {
            background-color: #0069D9;
            /* Darker blue */
            color: white;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <h1 class="text-center mt-4" style="color: #276ADC;">What is this for?</h1>
            <p class="text-center mb-5 " style="color: white;">This page provides rankings for players and clubs. Use the tabs to navigate between different categories.</p>

            <div class="row justify-content-center">


                <div class="col-lg-6 col-md-12 table-player"> <!-- Change the column class here -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#world" data-toggle="tab">World</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#attackers" data-toggle="tab">Attackers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#midfielders" data-toggle="tab">Midfielders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#defenders" data-toggle="tab">Defenders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#goalkeepers" data-toggle="tab">Goalkeepers</a>
                        </li>
                    </ul>



                    <div class="tab-content player-table-1">
                        <div class="tab-pane active" id="world">
                            <h2 id="player-title">World</h2>
                            <input type="text" id="player-search-bar" class="search-bar" placeholder="Search..."> <!-- Add a search bar -->
                            <table class="table">
                                <thead class="sticky-header"> <!-- Add a sticky header -->
                                    <tr>
                                        <th class="rank">Rank</th>
                                        <th class="name">Name</th>
                                        <th class="club">Club</th>
                                        <th class="skill">Points</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be added here -->

                                </tbody>
                            </table>
                        </div>
                        <!-- More tab panes here -->
                    </div>




                </div>


                <div class="col-lg-6 col-md-12"> <!-- Change the column class here -->
                    <div class="table-container table-clubs">
                        <h2 id="club-title">Clubs</h2>
                        <input id="club-search-bar" type="text" class="search-bar" placeholder="Search..."> <!-- Add a search bar -->
                        <table class="table">
                            <thead class="sticky-header"> <!-- Add a sticky header -->
                                <tr>
                                    <th class="rank">Rank</th>
                                    <th class="club">Club</th>
                                    <th class="won">Won</th>
                                    <th class="tie">Tie</th>
                                    <th class="lost">Lost</th>
                                    <th class="points">Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Add data -->

                            </tbody>
                        </table>
                    </div>
                </div>




            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            var currentType = 'global'; // Keep track of the current type

            var originalData = []; // Variable to store the original table data

            var originalClubData = []; // Variable to store the original club data

            // Function to load players
            function loadPlayers(type) {
                $.ajax({
                    url: '../getPlayers.php', // Your PHP file path
                    type: 'GET',
                    data: {
                        type: type
                    },
                    success: function(data) {
                        console.log(data); // Log the returned data
                        var players = JSON.parse(data);
                        var rank = 1;
                        $('.player-table-1 .table tbody').empty(); // Clear the table
                        originalData = []; // Clear the original data
                        players.forEach(function(player) {
                            var clubColumn = player.club_name !== 'No Club' ? player.club_name : '<button class="invite-btn" data-player-id="' + player.player_id + '">Invite</button>';
                            var row = '<tr data-rank="' + rank + '"><td>' + rank + '</td><td>' + player.name + '</td><td>' + clubColumn + '</td><td>' + player.skill.toFixed(2) + '</td></tr>';
                            $('.player-table-1 .table tbody').append(row);
                            originalData.push({
                                player_id: player.player_id,
                                rank: rank
                            }); // Store the player data with rank
                            rank++;
                        });
                        $('#player-title').text(type.charAt(0).toUpperCase() + type.slice(1));
                        currentType = type; // Update the current type
                    }
                });
            }

            // Load players on page load
            loadPlayers('global');

            // Load players when a tab is clicked
            $('.nav-link').on('click', function() {
                var type = $(this).attr('href').substring(1); // Get the type from the href attribute
                loadPlayers(type);
            });

            // Search players as you type in the search bar
            $('#player-search-bar').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                $.ajax({
                    url: '../searchFunction.php', // Your PHP file path
                    type: 'GET',
                    data: {
                        searchTerm: searchTerm,
                        type: currentType // Pass the current type
                    },
                    success: function(data) {
                        console.log(data); // Log the returned data
                        var players = JSON.parse(data);
                        $('.player-table-1 .table tbody').empty(); // Clear the table
                        players.forEach(function(player) {
                            var clubColumn = player.club_name !== 'No Club' ? player.club_name : '<button class="invite-btn" data-player-id="' + player.player_id + '">Invite</button>';
                            var rank = originalData.find(function(p) {
                                return p.player_id === player.player_id;
                            }).rank; // Get the rank from the original data
                            var row = '<tr data-rank="' + rank + '"><td>' + rank + '</td><td>' + player.name + '</td><td>' + clubColumn + '</td><td>' + player.skill.toFixed(2) + '</td></tr>';
                            $('.player-table-1 .table tbody').append(row);
                        });
                        $('#player-title').text('Global');
                    }
                });
            });



            // Function to load clubs
            function loadClubs() {
                $.ajax({
                    url: '../getClubs.php', // Your PHP file path
                    type: 'GET',
                    success: function(data) {
                        console.log(data); // Log the returned data
                        var clubs = JSON.parse(data);
                        $('.table-clubs .table tbody').empty(); // Clear the table
                        originalClubData = []; // Clear the original club data
                        clubs.forEach(function(club) {
                            var row = '<tr data-rank="' + club.rank + '" data-club-id="' + club.club_id + '"><td>' + club.rank + '</td><td>' + club.name + '</td><td>0</td><td>0</td><td>0</td><td>0</td></tr>';
                            $('.table-clubs .table tbody').append(row);
                            originalClubData.push(club); // Store the club data with rank
                        });
                    }
                });
            }

            // Load clubs on page load
            loadClubs();

            // Search clubs as you type in the search bar
            $('.table-clubs .search-bar').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                $.ajax({
                    url: '../searchFunctionClubs.php', // Your PHP file path
                    type: 'GET',
                    data: {
                        searchTerm: searchTerm
                    },
                    success: function(data) {
                        console.log(data); // Log the returned data
                        var clubs = JSON.parse(data);
                        $('.table-clubs .table tbody').empty(); // Clear the table
                        clubs.forEach(function(club) {
                            var originalClub = originalClubData.find(function(c) {
                                return c.club_id === club.club_id;
                            });
                            var rank = originalClub ? originalClub.rank : ''; // Get the rank from the original data, or use an empty string if the club is not found
                            var row = '<tr data-rank="' + rank + '" data-club-id="' + club.club_id + '"><td>' + rank + '</td><td>' + club.name + '</td><td>0</td><td>0</td><td>0</td><td>0</td></tr>';
                            $('.table-clubs .table tbody').append(row);
                        });
                    }
                });
            });



            // Invite player to club when the invite button is clicked
            $('.player-table-1').on('click', '.invite-btn', function() {
                var playerId = $(this).data('player-id');
                $.ajax({
                    url: '../invitePlayersToClub.php', // Your PHP file path
                    type: 'GET',
                    data: {
                        receiverId: playerId
                    },
                    success: function(response) {
                        console.log(response); // Log the response
                        Swal.fire({
                            title: 'Invite Status',
                            text: response,
                            icon: response.includes('Invite sent') ? 'success' : 'error',
                        });
                    }
                });
            });


        });
    </script>


</body>

</html>