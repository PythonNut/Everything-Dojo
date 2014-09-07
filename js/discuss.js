/* jshint browser:true, jquery:true, -W098 */
/* global Message:false */

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

  // JS validation
  $("[name='title']").keyup(function (e) {
    var title = new Message($(this)),
        keycode = ('which' in e) ? e.which : e.keyCode; // key validation

    if ((keycode > 47 && keycode < 58) || (keycode > 64 && keycode < 91) || (keycode > 95 && keycode < 112) || (keycode > 185 && keycode < 193) || (keycode > 218 && keycode < 223) || keycode == 32 || keycode == 8 || keycode == 13 || keycode == 46) {
      if ($(this).val().match(/\S/g) === null || $(this).val().match(/\S/g).length < 5) {
        title.assign("The title must have at least 5 characters (excluding whitespace)", "error").show();
        $("#post").attr("disabled", "");
      } else if ($(this).val().length > 64) {
        title.assign("The title cannot have more than 64 characters", "error").show();
        $("#post").attr("disabled", "");
      } else {
        title.purge();
        if ($("[name='desc']").val().match(/\S/g) !== null && $("[name='desc']").val().match(/\S/g).length >= 10) {
          $("#post").removeAttr("disabled");
        }
      }
    }
  });
  $("[name='desc']").keyup(function (e) {
    var message = new Message($(this)),
        keycode = ('which' in e) ? e.which : e.keyCode; // key validation

    if ((keycode > 47 && keycode < 58) || (keycode > 64 && keycode < 91) || (keycode > 95 && keycode < 112) || (keycode > 185 && keycode < 193) || (keycode > 218 && keycode < 223) || keycode == 32 || keycode == 8 || keycode == 13 || keycode == 46) {
      if ($(this).val().match(/\S/g) === null || $(this).val().match(/\S/g).length < 10) {
        message.assign("The message must have at least 10 characters (excluding whitespace)", "error").show(function () {
          $("[name='desc']").next().css({
            top: 0,
            bottom: 'auto'
          });
        });
        $("#post").attr("disabled", "");
      } else if ($(this).val().length > 40000) {
        message.assign("The message cannot have more than 40000 characters", "error").show(function () {
          $("[name='desc']").next().css({
            top: 0,
            bottom: 'auto'
          });
        });
        $("#post").attr("disabled", "");
      } else {
        message.purge();
        if ($("[name='title']").val().match(/\S/g) !== null && $("[name='title']").val().match(/\S/g).length >= 5) {
          $("#post").removeAttr("disabled");
        }
      }
    }
  });

  // make form submit on ctrl+enter/cmd+enter
  $("[name='desc']").keydown(function (e) {
    if ((e.keyCode == 10 || e.keyCode == 13) && (e.ctrlKey || e.keyCode == 224 || e.keyCode == 17 || e.keyCode == 91)) {
      $(this).parents("#form").trigger("submit");
    }
  });

  // close form on escape
  $("[name='title'], [name='desc']").keydown(function (e) {
    if (e.keyCode == 27) {
      $("#cancel").trigger("click");
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
