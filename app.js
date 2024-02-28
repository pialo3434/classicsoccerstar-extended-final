$(document).ready(function () {
  // GLOBAL VARIABLES ETC HERE

  var quotes = [
    "You knew in classic soccerstar there is a legendary player with the name B? Is he hacking...?",
    "If you click me you lose stars lol",
    "There might be an easter egg in this website... Try your luck ^^",
    "This game is even better than league of legends, trust...",
    "A collab with FIFA would be cool right?",
    "Free stars always nice :D",
    "I will scam you the moment you press that blue juicy button :>",
    // Add more quotes as needed
  ];

  var randomQuote = quotes[Math.floor(Math.random() * quotes.length)];

  // -------------------------

  $("#loginButtonID")
    .off("click")
    .on("click", function () {
      var username = $("#usernameID").val(); // Get the username from the input field
      var password = $("#passwordID").val(); // Get the password from the input field

      // Check if the username or password fields are empty
      if (!username || !password) {
        toastr.warning("Please enter both username and password");
        return;
      }

      // You can now use the username and password for your login logic
      console.log("Username:", username);
      console.log("Password:", password);

      $.ajax({
        type: "POST",
        url: "./components/comps/login.php",
        data: { username: username, password: password },
        success: function (response) {
          if (response.trim().includes("success")) {
            toastr.success("Login successful.");
            $("#loginModal").modal("hide"); // Hide the modal

            // Change the login button to a logout button
            var logoutButton =
              '<a href="./components/comps/logout.php" class="btn btn-light">Logout</a>';
            $("nav").find(".btn").replaceWith(logoutButton);
          } else {
            toastr.error("Login failed");
            console.log(response);
          }
        },
      });
    }); // This is the closing brace for the click event handler

  // Add this event listener
  $("#loginModal").on("hidden.bs.modal", function () {
    $(".modal-backdrop").remove(); // Remove the modal backdrop manually
  });

  $(".random-sentence").html('<i>"' + randomQuote + '"</i>');
});
