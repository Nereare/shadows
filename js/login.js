$(document).ready(function() {
  $("#login-user, #login-pw").on("input change", function() {
    if ( $(this).val() == "" ) {
      $(this).addClass("is-danger");
    } else {
      $(this).removeClass("is-danger");
    }
  });

  $("#login-do").on("click", function() {
    // Check if both fields are filled.
    if (
      $("#login-user").val() == "" ||
      $("#login-pw").val() == ""
    ) {
      // If either field is blank, highlight it.
      $("#login-user, #login-pw").trigger("change");
      if ( $("#login-user").val() == "" ) {
        $("#login-user").focus();
      } else {
        $("#login-pw").focus();
      }
    } else {
      // If both fields are filled, send to login logic.
      var user = $("#login-user").val();
      var pw = $("#login-pw").val();
      var remember = $("#login-remembe").is(":checked");
      var reply = null;

      // AJAX Request
      $.ajax({
        method: "GET",
        url: "scripts/login.php",
        data: {
          do: "login",
          username: user,
          password: pw,
          remember: remember
        }
      })
        .done( function(r) { reply = r; })
        .fail( function(r) { reply = 500; })
        .always( function(r) {
          var url = new URL(location.href);
          url.searchParams.set("reply",reply);
          location.replace(url);
        });
    }
  });

});
