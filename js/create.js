$(document).ready(function() {

  // Initialize MDE textarea
  var simplemde = new SimpleMDE({
    element: $("textarea")[0],
    spellChecker: false
  });

  // Set required fields to highlight when empty
  $("[required]").on("input change", function() {
    if ( $(this).val() == "" ) { $(this).addClass("is-danger"); }
    else { $(this).removeClass("is-danger"); }
  });

  // Create adventure method
  $("#create-adventure").on("click", function() {
    // Disable run button
    $("#create-adventure")
      .addClass("is-loading")
      .prop("disabled", true);

    // Check validity of required fields
    requireds = true;
    $("[required]").each(function() {
      if ( $(this).val() == "" ) { requireds = false; }
    });
    // Check validity of description textarea
    area = true;
    if ( simplemde.value() == "" ) { area = false; }

    // Run creation method if all required fields are cleared
    if ( requireds && area ) {
      // Hide notification
      $("#create-notification")
        .removeClass("is-success is-danger is-warning is-info")
        .addClass("is-hidden")
        .find("p").val("");

      // Retrieve field data
      name         = $("#name").val();
      cover        = $("#cover").val();
      setting      = $("#setting").val();
      level_start  = parseInt( $("#level-start").val() );
      level_end    = parseInt( $("#level-end").val() );
      pcs          = parseInt( $("#pcs").val() );
      version      = $("#version").val();
      advancement  = $("#advancement").val();
      is_public    = ( $("#is-public").val() === "true" );
      dev_status   = $("#dev-status").val();
      tw           = $("#tw").val();
      description  = simplemde.value();

      // AJAX Request
      $.ajax({
        method: "GET",
        url: "scripts/create-do.php",
        data: {
          do: "adventure",
          name: name,
          cover: cover,
          setting: setting,
          level_start: level_start,
          level_end: level_end,
          pcs: pcs,
          version: version,
          advancement: advancement,
          is_public: is_public,
          dev_status: dev_status,
          tw: tw,
          description: description
        }
      })
        .done( function(r) { reply = r; })
        .fail( function(r) { reply = "500"; })
        .always( function(r) {
          switch ( reply ) {
            case "0":
              notif_class = "is-success";
              notif_msg = "Adventure created successfully!";
              // TODO: Include link to adventure page in the message above
              break;
            case "424":
              notif_class = "is-warning";
              notif_msg = "Sent data was deemed invalid by the server.";
              break;
            case "404":
              notif_class = "is-danger";
              notif_msg = "Creation script not found.";
              break;
            default:
              notif_class = "is-danger";
              notif_msg = "The server could not process this request at this time, sorry.";
          }
          // Show notification
          $("#create-notification")
            .removeClass("is-hidden is-success is-danger is-warning is-info")
            .addClass(notif_class)
            .find("p").val(notif_msg);
          // Remove the loading effect from the button.
          $("#create-adventure")
            .removeClass("is-loading")
            .html("Done");
        });
    } else {
      $("[required]").trigger("change");
      $("#create-adventure")
        .removeClass("is-loading")
        .prop("disabled", false);
    }
  });

});
