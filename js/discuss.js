/* jshint browser:true, jquery:true, -W098 */

// JavaScript Document
$(document).ready(function() {
  $("#notifications").hide();

  // For closing the users popup on body click
  $('body').click(function(e) {
    if($(e.target).closest('.notification-link, #notifications').length === 0){
      $("#notifications").hide("fast", "swing");
    }
  });

  // add title attribute to announcements
  // uses .each as otherwise `this` would refer to window
  $(".discuss-announcement").each(function () {
    $(this).attr("title", $(this).text());
  });

  // make forum links undraggable
  $("#fora > a").mousedown(function (e) {
    e.preventDefault();
  });

  // make form submit on ctrl+enter/cmd+enter
  $("[name='desc']").keydown(function (e) {
    if ((e.keyCode == 10 || e.keyCode == 13) && (e.ctrlKey || e.keyCode == 224 || e.keyCode == 17 || e.keyCode == 91)) {
      $(this).parent().submit();
    }
  });
});
function show_notifications() {
  $("#notifications").toggle(350);
}
function mark_all_read(forum_id, user_id) {
  $.ajax({
    url: '/include/ajax_handler.php',
    data: {
      action: 'discuss_mark_read',
      forum_id: forum_id,
      user_id: user_id
    },
    type: 'post',
    success: function() {
      location.reload();
    }
  });
}

$(function () {
});
