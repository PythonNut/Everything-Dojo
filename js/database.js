// JavaScript Document
$(document).ready(function() {
  $("#popup-box").hide();
  $("#notifications").hide();
  for (var i=2; i<=4; i++) {
    $("#manage-" + i).hide();
  }
  $("#header-1").click(function() {
    $("#manage-1").slideToggle(350, function() {
      if($(this).is(':visible')) {
        $('#header-1').css('background-image','url(../../images/up-arrow.png)');
      } else {
        $('#header-1').css('background-image','url(../../images/down-arrow.png)');
      }
    });
  });
  $("#header-2").click(function() {
    $("#manage-2").slideToggle(350, function() {
      if($(this).is(':visible')) {
          $('#header-2').css('background-image','url(../../images/up-arrow.png)');
      } else {
          $('#header-2').css('background-image','url(../../images/down-arrow.png)');
      }
    });
  });
  $("#header-3").click(function() {
    $("#manage-3").slideToggle(350, function() {
      if($(this).is(':visible')) {
          $('#header-3').css('background-image','url(../../images/up-arrow.png)');
      } else {
          $('#header-3').css('background-image','url(../../images/down-arrow.png)');
      }
    });
  });
  $("#header-4").click(function() {
    $("#manage-4").slideToggle(350, function() {
      if($(this).is(':visible')) {
          $('#header-4').css('background-image','url(../../images/up-arrow.png)');
      } else {
          $('#header-4').css('background-image','url(../../images/down-arrow.png)');
      }
    });
  });

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
  $("d#notifications").toggle(350);
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
