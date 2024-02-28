<?php
session_start();
?>

<?php include './styles/header.php'; ?>

<div class="container-fluid" style="background-color: rgba(0, 0, 0, 0.5); min-height: 100vh;">
    <div class="row justify-content-center align-items-center h-100" style="padding-top: 100px; padding-bottom: 100px;">
        <div class="col-12 text-center">
            <h1 class="text-white">DAILY REWARD!</h1>
            <p class="text-white mb-5" style="font-size: 1rem;">Claim your prizes every day! If you miss a day, you won't lose your reward, but you will lose your streak.</p>
            <h2 class="text-white mb-5 countdown" style="font-size: 3rem;">
                Time until next reward:
                <span id="timer" style="font-family: 'Courier New', monospace;
                min-width: 6em;
                display: inline-block;
                text-align: right;">d h m s</span>
            </h2>
        </div>

        <div class="col-1 d-flex align-items-center justify-content-end">
            <button class="btn btn-secondary" style="background-color: #1260CC;" id="scroll-left">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>

        <div class="col-10 d-flex flex-nowrap cards-container" style="background-color: transparent; scrollbar-width: none; padding: 0 20px; scroll-behavior: smooth; max-width: 1200px; overflow-x: hidden;">
            <!-- Cards will be inserted here by JavaScript -->
        </div>

        <div class="col-1 d-flex align-items-center justify-content-start">
            <button class="btn btn-secondary" style="background-color: #1260CC;" id="scroll-right">
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var container = $('.cards-container');

        $.getJSON('./components/comps/loadCards.php')
            .done(function(data) {
                if (data.error) {
                    console.log("Error: " + data.error);
                    return;
                }

                var cards = data;
                console.log(cards); // This will print the fetched data to the console

                var requests = cards.map(function(card, i) {
                    return $.ajax({
                        url: './components/cards/rewardCard.php',
                        data: {
                            day: card.day,
                            rewardType: card.rewardType,
                            rewardValue: card.rewardValue,
                            imgSrc: card.imgSrc,
                            reward: card.reward,
                            reward_id: card.reward_id // Pass the reward_id as data
                        }
                    }).then(function(data) {
                        var cardElement = $(data); // Convert the HTML string to a jQuery object
                        if (card.isClaimed) {
                            cardElement.find('.card-header').css('background-color', 'green');
                            cardElement.find('.claimButton')
                                .css('background-color', 'green')
                                .text('Claimed');
                        } else {
                            var now = new Date();
                            var can_claim_at = new Date(card.can_claim_at);
                            if (can_claim_at < now) {
                                cardElement.find('.card-header').css('background-color', '#FFA500');
                                cardElement.find('.claimButton')
                                    .css('background-color', '#FFA500')
                                    .text('Claim');
                            }
                        }
                        return cardElement;
                    });
                });
                $.when.apply($, requests).then(function() {
                    var cardElements = Array.prototype.slice.call(arguments).map(function(response) {
                        return response[0];
                    });
                    container.append(cardElements);
                });
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.log("AJAX request failed: " + textStatus + ", " + errorThrown);
            });

        $('#scroll-left').click(function() {
            container.animate({
                scrollLeft: "-=300"
            }, 10); // Adjust this value to make the animation faster or slower
        });

        $('#scroll-right').click(function() {
            container.animate({
                scrollLeft: "+=300"
            }, 10); // Adjust this value to make the animation faster or slower
        });


        // TIMER CODE FOR COUNTDOWN
        // Get the element with id "timer"
        var timerElement = document.getElementById("timer");

        // Create an audio element for the sound effect
        var audioElement = new Audio('../assets/thicking.mp3');
        audioElement.loop = true; // This will make the audio loop

        // Function to update the timer
        function updateTimer() {
            // Get the current date and time
            var now = new Date();

            // Calculate the time until midnight
            var midnight = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1);
            var timeUntilMidnight = midnight - now;

            // Calculate the number of hours, minutes, and seconds
            var hours = Math.floor((timeUntilMidnight % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((timeUntilMidnight % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((timeUntilMidnight % (1000 * 60)) / 1000);

            // Update the timer element
            timerElement.innerHTML = hours + "h " + minutes + "m " + seconds + "s ";

            // Play the sound effect in a loop
            if (audioElement.paused) {
                //audioElement.play();
            }

            // Request the next frame
            requestAnimationFrame(updateTimer);
        }


        //audioElement.play();
        updateTimer();




    });
</script>

<?php include './styles/footer.php'; ?>