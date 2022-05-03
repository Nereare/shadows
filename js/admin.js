$(document).ready(function() {

  // Create user
  $("#create-button").on("click", function() {
    $("#create-button")
      .addClass("is-loading")
      .prop("disabled", true);
    $("#notification")
      .addClass("is-hidden")
      .removeClass("is-success is-warning is-danger is-info")
      .find("p").html("");

    // Check if both fields are filled.
    if (
      $("#username").val() == "" ||
      $("#email").val() == ""
    ) {
      // If either field is blank, highlight it.
      $("#username, #email").trigger("change");
      if ( $("#username").val() == "" ) { $("#username").focus(); }
      else { $("#email").focus(); }
      // And reenable button
      $("#create-button")
        .removeClass("is-loading")
        .prop("disabled", false);
    } else {
      // If both fields are filled, send to login logic.
      var username = $("#username").val();
      var email = $("#email").val();

      // AJAX Request
      $.ajax({
        method: "GET",
        url: "scripts/admin.php",
        data: {
          do: "create",
          username: username,
          email: email
        }
      })
        .done( function(r) { reply = r; })
        .fail( function(r) { reply = 500; })
        .always( function(r) {
          switch (reply) {
            case "0":
              msg = "User created successfully.";
              type = "is-success";
              break;
            case "400":
              msg = "Something went wrong on your side, it seems.";
              type = "is-warning";
              break;
            case "401":
              msg = "You do not belong here, do you?";
              type = "is-danger";
              break;
            case "404":
              msg = "This is not the method you are looking for.";
              type = "is-warning";
              break;
            case "418":
              msg = "Is it tea time already?";
              type = "is-info";
              break;
            case "429":
              msg = "Woah woah woah! Hang in there, please. Take your time, go for a walk, see some trees.";
              type = "is-danger";
              break;
            case "500":
              msg = "Something went wrong on our side, it seems. We apologize for the inconvenience.";
              type = "is-danger";
              break;
            default:
              msg = "Good gracious me, how have you gotten yourself here?";
              type = "is-info";
          }
          $("#notification")
            .removeClass("is-hidden")
            .addClass(type)
            .find("p").html(msg);
          $("#username, #email").val("");
          $("#create-button")
            .removeClass("is-loading")
            .prop("disabled", false);
        });
    }
  });

  // Upgrade user to Manager
  $(".button.upgrade").on("click", function() {
    $(this)
      .addClass("is-loading")
      .prop("disabled", true);
    var uid = $(this).data("id");
    // AJAX Request
    $.ajax({
      method: "GET",
      url: "scripts/admin.php",
      data: {
        do: "upgrade",
        uid: uid
      }
    }).always( function(r) { location.reload(); });
  });

  // Downgrade user from Manager
  $(".button.downgrade").on("click", function() {
    $(this)
      .addClass("is-loading")
      .prop("disabled", true);
    var uid = $(this).data("id");
    // AJAX Request
    $.ajax({
      method: "GET",
      url: "scripts/admin.php",
      data: {
        do: "downgrade",
        uid: uid
      }
    }).always( function(r) { location.reload(); });
  });

  // Reset user's password
  $(".button.password-reset").on("click", function() {
    var elem = $(this);
    $(this)
      .addClass("is-loading")
      .prop("disabled", true);
    $("#notification")
      .addClass("is-hidden")
      .removeClass("is-success is-warning is-danger is-info")
      .find("p").html("");
    var uid = $(this).data("id");
    // AJAX Request
    $.ajax({
      method: "GET",
      url: "scripts/admin.php",
      data: {
        do: "reset",
        uid: uid
      }
    })
      .done( function(r) {
        switch (r) {
          case "0":
            type = "is-success";
            msg = "Password reset email sent.";
            break;
          default:
            type = "is-danger";
            msg = "Something went wrong on the server.";
        }
      })
      .fail( function() {
        type = "is-danger";
        msg = "Something went wrong, sorry.";
      })
      .always( function(r) {
        elem
          .removeClass("is-loading")
          .prop("disabled", false);
        $("#notification")
          .removeClass("is-hidden")
          .addClass(type)
          .find("p").html(msg);
      });
  });

});
