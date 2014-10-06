$(function () {
  $("#popup-box").hide();

  // Options
  $(".manage-item").each(function () {
    $("#" + $(this).attr("id") + " .option-title").attr("onclick", "optionToggle('" + $(this).attr("id") + "')").addClass("collapsed");
  });
  $(".expanded").removeClass("collapsed");
  $(".expanded").next().slideDown(0);

  // For closing the users popup on body click
  $('body').click(function (e) {
    if($(e.target).closest('.view, #popup-box').length === 0) {
      $("#popup-box").hide("fast", "swing");
    } else if ($(e.target).closest('.notification-link, #notifications').length === 0) {
      $("#notifications").hide("fast", "swing");
    }
  });
});

function popup_box() {
  $("#popup-box").toggle(350);
}

function popup_options(mode, id) {
  $("#popup-header").text(mode);
  $("#popup-header").css('textTransform', 'capitalize');
  $("#replace").text(mode);
  $("#replace-id").val(id);
  $("#replace-form").val(mode);
  $("#popup-box").toggle(350);
}

function idFill(id) {
  $("#user_id").val(id);
}
