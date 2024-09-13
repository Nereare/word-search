$(function() {
  // DOM Ready
  console.log("DOM Ready");

  // Bulma tags input setting up
  BulmaTagsInput.attach();

  // Set all aria-delete buttons to delete their parent elements
  $("button.delete").on("click", function() {
    $(this).parent().addClass("is-hidden");
  });

  // Check for click events on the navbar burger icon
  $(".navbar-burger").on("click", function() {
    // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
    $(".navbar-burger").toggleClass("is-active");
    $(".navbar-menu").toggleClass("is-active");
  });

  // Login
  $("#login").on("submit", function(e) {
    e.preventDefault();
    // Disable button
    $("#login-login")
      .addClass("is-loading")
      .prop("disabled", true);

    // Retrieve values for ease of use.
    let username = $("#login-username").val().trim();
    let password = $("#login-password").val().trim();
    let remember = $("#login-persistent").is(":checked");

    if ( username != "" && password != "" ) {
      let reply = null;
      $.ajax({
        method: "GET",
        url: "php/login.php",
        data: {
          username : username,
          password : password,
          remember : remember
        }
      })
        .fail(function() {
          resetNotification( $("#notification") );
          $("#notification")
            .addClass("is-danger")
            .removeClass("is-hidden")
            .find("p").html("We could not connect to the server.");
          // Reenable button
          $("#login-login")
            .removeClass("is-loading")
            .prop("disabled", false);
        })
        .done(function(r) {
          if ( r == "0" ) {
            resetNotification( $("#notification") );
            $("#notification")
              .addClass("is-success")
              .removeClass("is-hidden")
              .find("p").html("You are now logged in.");
            // Reload page
            location.reload();
          } else {
            resetNotification( $("#notification") );
            $("#notification")
              .addClass("is-danger")
              .removeClass("is-hidden")
              .find("p").html("The user data is invalid.");
            // Focus on username field
            $("#login-username").trigger("focus");
            // Reenable button
            $("#login-login")
              .removeClass("is-loading")
              .prop("disabled", false);
          }
        });
    } else {
      // Reenable button
      $("#login-login")
        .removeClass("is-loading")
        .prop("disabled", false);
    }
  });

  // Logout
  $("#logout").on("click", function() {
    $.ajax({
      method: "GET",
      url: "php/logout.php"
    }).always(function() { location.reload(); });
  });

});

function resetNotification() {
  $("#notification")
    .removeClass("is-success is-danger is-warning is-info is-dark is-light")
    .addClass("is-hidden");
}
function setNotification(msg, class_name = "is-info") {
  $("#notification")
    .addClass(class_name)
    .removeClass("is-hidden")
    .find("p")
      .html(msg);
}
