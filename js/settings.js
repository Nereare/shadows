$(document).ready(function() {

  $("#password-button").on("click", function() {
    $(this)
      .prop("disabled", true)
      .addClass("is-loading");
    $("#notification")
      .addClass("is-hidden")
      .removeClass("is-success is-warning is-danger");

    var uid = $("#user-uid").val();
    var passwordold = $("#password-old").val();
    var passwordnew1 = $("#password-new1").val();
    var passwordnew2 = $("#password-new2").val();

    if (
      passwordnew1 == passwordnew2 &&
      passwordnew1 != "" &&
      passwordnew2 != ""
    ) {
      $.ajax({
        method: "GET",
        url: "scripts/login.php",
        data: {
          do: "password",
          uid: uid,
          old: passwordold,
          new: passwordnew1
        }
      })
        .fail( function(r) {
          $("#notification").addClass("is-danger");
          $("#notification p").html("The request could not be processed.");
        })
        .done( function(r) {
          if ( r == "0" ) {
            $("#notification").addClass("is-success");
            $("#notification p").html("Password changed successfully.");
          } else {
            $("#notification").addClass("is-warning");
            switch (r) {
              case "401":
                $("#notification p").html("Error with user input.");
                break;
              case "500":
                $("#notification p").html("The server returned an error.");
                break;
              default:
                $("#notification p").html("The server returned an unknown reply.");
            }
          }
        })
        .always( function(r) {
          $("#notification").removeClass("is-hidden");
          $("#password-old, #password-new1, #password-new2").val("");
          $("#password-button")
            .prop("disabled", false)
            .removeClass("is-loading");
        });
    } else {
      $("#password-new1, #password-new2").on("change input", function() {
        if ( $(this).val() == "" ) { $(this).addClass("is-danger"); }
        else {
          if ( $("#password-new1").val() == $("#password-new2").val() ) {
            $(this).removeClass("is-danger");
          } else { $("#password-new1, #password-new2").addClass("is-danger"); }
        }
      }).trigger("change");
      $("#password-button")
        .prop("disabled", false)
        .removeClass("is-loading");
    }
  });

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
              $("#notification p").html("The server returned an unknown reply.");
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
