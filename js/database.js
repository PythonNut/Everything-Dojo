// JavaScript Document
$(document).ready(function() {
  $("#popup-box").hide();
  $("#notifications").hide();

  // Options
  $(".manage-item").each(function () {
    $("#" + $(this).attr("id") + " .option-title").attr("onclick", "optionToggle('" + $(this).attr("id") + "')").addClass("collapsed");
  });
  $(".expanded").removeClass("collapsed");
  $(".expanded").next().slideDown(0);

  // For closing the users popup on body click
  $('body').click(function(e) {
    if($(e.target).closest('.view, #popup-box').length === 0) {
      $("#popup-box").hide("fast", "swing");
    }
  });
  $('body').click(function(e) {
    if($(e.target).closest('.notification-link, #notifications').length === 0){
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
function show_notifications() {
  $("#notifications").toggle(350);
}
function mark_read(id) {
  $.ajax({
    url: '/include/ajax_handler.php',
    data: {
      action: 'mark_read',
      notification_id: id
    },
    type: 'post',
    success: function() {}
  });
}
function mark_all_read(user_id) {
  $.ajax({
    url: '/include/ajax_handler.php',
    data: {
      action: 'mark_all_read',
      user_id: user_id
    },
    type: 'post',
    success: function() {
      location.reload();
    }
  });
}
function idFill(id) {
  $("#user_id").val(id);
}
