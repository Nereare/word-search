$(function() {
  // Check required values - username
  $("#user-username").on("input change", function() {
    $(this).removeClass("is-success is-warning is-danger is-info");
    if ( $(this).val().match(/^[A-Za-z][A-Za-z0-9_]{5,}$/) ) {
      $(this).addClass("is-success");
    } else {
      $(this).addClass("is-danger");
    }
  });

  // Check required values - password
  $("#user-password").on("input change", function() {
    $(this).removeClass("is-success is-warning is-danger is-info");
    if ( $(this).val().match(/^[A-Za-z0-9\_\-\?\$\(\)\#\@\.\=]{6,}$/) ) {
      $(this).addClass("is-success");
    } else {
      $(this).addClass("is-danger");
    }
  });

  // Run intallation
  $("#install-form").on("submit", function(event) {
    // Prevent default behavior
    event.preventDefault()
    // Disable button
    $(this)
      .addClass("is-loading")
      .prop("disabled", true);

    // Retrieve values for ease of use.
    let instance_name        = $("#instance-name").val().trim();
    let instance_production  = $("#instance-production").is(":checked");
    let instance_uri         = $("#instance-uri").val().trim();
    let instance_protocol    = $("#instance-protocol").val().trim();
    let db_name              = $("#db-name").val().trim();
    let db_username          = $("#db-username").val().trim();
    let db_password          = $("#db-password").val().trim();
    let admin_username       = $("#admin-username").val().trim();
    let admin_password       = $("#admin-password").val().trim();
    let admin_email          = $("#admin-email").val().trim();
    let admin_name_prefix    = $("#admin-name-prefix").val().trim();
    let admin_name_first     = $("#admin-name-first").val().trim();
    let admin_name_last      = $("#admin-name-last").val().trim();
    let admin_name_suffix    = $("#admin-name-suffix").val().trim();

    // Check required values - if they have any contents.
    let req_filled = true;
    $("[required]").each(function() {
      if ( $(this).val() == "" ) {
        req_filled = false;
      }
    });

    // Run AJAX query if all required fields were filled.
    if (req_filled) {
      let reply = null;
      // AJAX Request
      $.ajax({
        method: "GET",
        url: "install.php",
        data: {
          instance_name       : instance_name,
          instance_production : instance_production,
          instance_uri        : instance_uri,
          instance_protocol   : instance_protocol,
          db_name             : db_name,
          db_username         : db_username,
          db_password         : db_password,
          admin_username      : admin_username,
          admin_password      : admin_password,
          admin_email         : admin_email,
          admin_name_prefix   : admin_name_prefix,
          admin_name_first    : admin_name_first,
          admin_name_last     : admin_name_last,
          admin_name_suffix   : admin_name_suffix
        }
      })
        .fail( function() { reply = "500"; })
        .done( function(r) { reply = r; })
        .always( function() {
          // Empty the results div.
          if (reply == "0") {
            // Fill the result div with the replies from the server.
            window.location.href = "/";
          } else {
            // Reply that there was an error.
            setNotification("The installation failed with a return " + reply + ".", "is-danger");
            // Re-enable the button, since there was an error.
            $("#install")
              .removeClass("is-loading")
              .prop("disabled", false);
          }
        });
    } else {
      // Reply that there was missing fields.
      setNotification("There was missing fields needed.", "is-warning");
      // Re-enable button, if required fields weren't all filled.
      $(this)
        .removeClass("is-loading")
        .prop("disabled", false);
    }
  });
});
