<div class="col mb-4" style="max-width: 300px; flex: none; margin: 0; "> <!-- Dark gray background -->
    <div class="card h-100" style="height: 400px; width: 250px;">
        <div class="card-header text-center" style="background-color: #1260CC;"> <!-- Blue header -->
            <h5 style="color: #FFFFFF;">Day <?php echo $_REQUEST['day']; ?></h5> <!-- White text -->
        </div>
        <img src="<?php echo $_REQUEST['imgSrc']; ?>" class="card-img-top mx-auto d-block mt-5" alt="Reward" style="width: 75px; height: 120px;" />
        <div class="card-body d-flex flex-column justify-content-between"> <!-- White text -->
            <p class="card-text"><?php echo $_REQUEST['reward']; ?></p>
            <button class="btn btn-custom claimButton d-block mx-auto mt-auto" style="background-color: #1260CC; color: white;" data-reward-id="<?php echo $_REQUEST['reward_id']; ?>">Claim Reward</button>
        </div>
    </div>
    <script>
        $('.claimButton').off('click').on('click', function() {
            var reward_id = $(this).data('rewardId'); // Get the reward_id from the data attribute of the button
            var button = $(this); // Get the clicked button
            var header = button.closest('.card').find('.card-header'); // Get the card header

            button.prop('disabled', true); // Disable the button

            $.ajax({
                type: 'POST',
                url: './components/comps/claimRewards.php',
                data: {
                    reward_id: reward_id
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        Swal.fire(
                            'Success!',
                            data.success,
                            'success'
                        )
                        button.css('background-color', 'green').text('Claimed'); // Change the button color and text
                        header.css('background-color', 'green'); // Change the header color
                    } else if (data.error) {
                        Swal.fire(
                            'Error!',
                            data.error,
                            'error'
                        )
                        if (data.error == 'Reward is not available yet. Please wait until the defined day...') {
                            var originalButtonColor = button.css('background-color'); // Save the original button color
                            var originalHeaderColor = header.css('background-color'); // Save the original header color

                            button.css('background-color', 'red').text('Not Available'); // Change the button color and text to red
                            header.css('background-color', 'red'); // Change the header color to red

                            setTimeout(function() {
                                button.css('background-color', originalButtonColor); // Change the button color back to the original color
                                header.css('background-color', originalHeaderColor); // Change the header color back to the original color
                                button.text('Claim Reward'); // Change the button text back to 'Claim Reward'
                            }, 5000);
                        }
                    }
                },
                complete: function() {
                    setTimeout(function() {
                        button.prop('disabled', false); // Re-enable the button after 5 seconds
                    }, 5000);
                }
            });
        });
    </script>



</div>