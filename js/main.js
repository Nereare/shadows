$(document).ready(function() {

  // Set all aria-delete buttons to delete their parent elements
  $("button.delete").on("click", function() {
    $(this).parent().addClass("is-hidden");
  });

  // Accept cookies
  $("#cookie-accept").on("click", function() {
    $(this)
      .addClass("is-loading")
      .prop("disabled", true);
    $.ajax({
      method: "GET",
      url: "scripts/cookies.php",
      data: {
        accept: true
      }
    }).always( function(r) {
      location.reload();
    });
  });

  // Bulma tags input setting up
  BulmaTagsInput.attach();

  // Check for click events on the navbar burger icon
  $(".navbar-burger").on("click", function() {
    // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
    $(".navbar-burger").toggleClass("is-active");
    $(".navbar-menu").toggleClass("is-active");
  });

  // Log user out
  $("#logout-button").on("click", function() {
    $.ajax({
      method: "GET",
      url: "scripts/login.php",
      data: {
        do: "logout"
      }
    })
      .always( function(r) {
        location.reload();
      });
  });

});
