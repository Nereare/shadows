$(document).ready(function() {

  $("#update-button").on("click", function() {
    $(this)
      .prop("disabled", true)
      .addClass("is-loading");
    $("#notification")
      .addClass("is-hidden")
      .removeClass("is-success is-warning is-danger");

    var uid = $("#user-uid").val();
    var firstname = $("#profile-firstname").val();
    var lastname = $("#profile-lastname").val();
    var location = $("#profile-location").val();
    var birth = $("#profile-birth").val();
    var about = simplemde.value();

    $.ajax({
      method: "GET",
      url: "scripts/login.php",
      data: {
        do: "update",
        uid: uid,
        firstname: firstname,
        lastname: lastname,
        location: location,
        birth: birth,
        about: about
      }
    })
      .fail( function(r) {
        $("#notification").addClass("is-danger");
        $("#notification p").html("The request could not be processed.");
      })
      .done( function(r) {
        if ( r == "0" ) {
          $("#notification").addClass("is-success");
          $("#notification p").html("Profile updated successfully.");
        } else {
          $("#notification").addClass("is-success");
          switch (r) {
            case "401":
              $("#notification p").html("Error with user input.");
              break;
            case "500":
              $("#notification p").html("The server returned an error.");
              break;
            default:
              $("#notification p").html("The request could not be processed.");
          }
        }
      })
      .always( function(r) {
        $("#notification").removeClass("is-hidden");
        $("#update-button")
          .prop("disabled", false)
          .removeClass("is-loading");
      });
  });

});
