// JavaScript Document
$(document).ready(function() {
  $("#notifications").hide();
  $('body').click(function(e) {
    if($(e.target).closest('.notification-link, #notifications').length === 0){
      $("#notifications").hide("fast", "swing");
    }
  });
});
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