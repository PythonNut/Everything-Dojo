/* jshint browser:true */
/* global Message:false */

/**
 * Provides field validation to register.php
 */

document.onready = function () {

  "use strict";

  /**
   * Set variables
   */

  // Messages
  var userName   = new Message("[name='user_name']"),
      userEmail  = new Message("[name='usr_email']"),
      userPwd    = new Message("[name='pwd']"),
      userPwdVal = new Message("[name='pwd2']");

  // Timeouts
  var userTimeout;

  // AJAX stuff
  var ajaxName  = new XMLHttpRequest();

  // Submit button
  var submit = document.getElementById("doRegister");

  /**
   * Validation
   */

  // Username
  userName.el.onkeyup = function (e) {
    var user    = userName.el.value,
        keycode = ('which' in e) ? e.which : e.keyCode; // key validation

    if ((keycode > 47 && keycode < 60) || (keycode > 64 && keycode < 91) || (keycode > 95 && keycode < 112) || (keycode > 185 && keycode < 193) || (keycode > 218 && keycode < 223) || keycode == 32 || keycode == 8 || keycode == 13 || keycode == 46) {
      if (!/^[a-z\d_]{3,20}$/i.test(user)) {
        clearTimeout(userTimeout);
        ajaxName.abort(); // abort ajax request if already sent
        userName.assign("Invalid username. Usernames must be 3-20 characters long and can only contain alphanumeric characters and underscores.", "error").show();
        userName.el.parentNode.lastElementChild.style.display = "none"; // hide loading gif
        submit.setAttribute("disabled", true);
      } else {
        clearTimeout(userTimeout);
        userName.purge();
        userName.el.parentNode.lastElementChild.style.display = "inline"; // show loading gif
        // ajax to verify username
        ajaxName.onreadystatechange = function () {
          if (ajaxName.readyState == 4 ) {
            if (ajaxName.status == 200) {
              if (ajaxName.responseText == "success") {
                userName.assign("Username is valid.", "correct").show();
                toggleSubmitDisabled();
                userName.el.parentNode.lastElementChild.style.display = "none"; // hide loading gif
              } else if (ajaxName.responseText == "error") {
                userName.assign("Username already exists! Please choose a new one.", "error").show();
                submit.setAttribute("disabled", true);
                userName.el.parentNode.lastElementChild.style.display = "none";
              }
            } else if (ajaxName.status !== 0) { // if an error actually occured, not just a request being aborted
              userName.assign("A " + ajaxName.status + " error occurred. Please try again.", "error").show();
              submit.setAttribute("disabled", true);
              userName.el.parentNode.lastElementChild.style.display = "none";
            }
          }
        };

        // set 100ms timeout to account for typing
        userTimeout = setTimeout(function () {
          try {
            ajaxName.open("GET", "register.php?username=" + user, true);
            ajaxName.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            ajaxName.send();
          } catch (error) {
            window.alert("An AJAX error occured. Please check your internet connection and try again.");
            if (window.evdoDebug === true) {
              console.log("Error: " + error);
            }
          }
        }, 100);
      }
    }
  };

  // Email
  userEmail.el.onkeyup = function (e) {
    var email   = userEmail.el.value,
        keycode = ('which' in e) ? e.which : e.keyCode; // key validation

    if ((keycode > 47 && keycode < 60) || (keycode > 64 && keycode < 91) || (keycode > 95 && keycode < 112) || (keycode > 185 && keycode < 193) || (keycode > 218 && keycode < 223) || keycode == 32 || keycode == 8 || keycode == 13 || keycode == 46) {
      if (!/^\S+@(localhost|([\w\d-]{2,}\.){1,2}[a-z]{2,6})$/i.test(email)) {
        userEmail.assign("Email entered is not a valid email.", "error").show();
        submit.setAttribute("disabled", true);
      } else {
        userEmail.purge();
        toggleSubmitDisabled();
      }
    }
  };

  // Passwords
  userPwd.el.onkeyup = userPwdVal.el.onkeyup = function () {
    var original = userPwd.el.value,
        verify   = userPwdVal.el.value;
    if (original.length < 6) {
      userPwd.assign("Passwords must be at least 6 characters long", "error").show();
    } else if (original != verify) {
      userPwdVal.assign("Passwords do not match.", "error").show();
      submit.setAttribute("disabled", true);
    } else {
      userPwd.purge();
      userPwdVal.purge();
      toggleSubmitDisabled();
    }
  };

  /**
   * Validate on paste
   *
   * Arguments passed to onkeyup are an ugly hack to trigger key validation
   * In this case, 8 is just an arbitrary keycode.
   *
   * And yes, I know onpaste is nonstandard.
   */
  userName.el.onpaste = function () {
    userName.el.onkeyup({"which": 8, "keyCode": 8});
  };

  userEmail.el.onpaste = function () {
    userEmail.el.onkeyup({"which": 8, "keyCode": 8});
  };

  /**
   * Onblur effects
   */
  userName.el.onblur = function () {
    userName.hide();
  };

  userEmail.el.onblur = function () {
    userEmail.hide();
  };

  userPwd.el.onblur = function () {
    userPwd.hide();
  };

  userPwdVal.el.onblur = function () {
    userPwdVal.hide();
  };

  /**
   * Functions
   */
  function validateFinal () {
    var list = [userName.el, userEmail.el, userPwd.el, userPwdVal.el];
    for (var i = 0; i < list.length; i++) {
      if (/invalid/.test(list[i].className) || !list[i].value) {
        return false;
      }
    }
    return true;
  }

  function toggleSubmitDisabled () {
    if (!validateFinal()) {
      submit.setAttribute("disabled", true);
    } else {
      submit.removeAttribute("disabled");
    }
  }

  /**
   * Submit form over AJAX
   *
   * Uses jQuery
   */

  /* global jQuery:true, Recaptcha:true */

  (function ($) {
    // Elements
    var $form   = $("[name='regForm']"),
        $submit = $("[name='doRegister']");

    // ReCAPTCHA error message init
    var recaptchaMsg = new Message("#message");

    // Prep form for AJAX submission
    $form.attr("onsubmit", "return false;").removeAttr("action");
    $("[name='ajax']").val(true);
    $submit.attr("type", "button");

    $submit.click(function () {
      $.ajax({
        type: "POST",
        url: "register.php",
        data: $("[name='regForm']").serialize(),
        beforeSend: function () {
          submit.setAttribute("disabled", true);
          recaptchaMsg.purge();
          $submit.next().css({
            display : "inline",
            left    : "4rem",
            top     : "0"
          });
        },
        success: function (msg) {
          setTimeout(function () {
            if (msg.indexOf("r") !== -1) {
              recaptchaMsg.assign("Recaptcha failed! Please try again.", "error").show(function () {
                recaptchaMsg.el.nextElementSibling.style.bottom = "1em";
                recaptchaMsg.el.nextElementSibling.style.left = "325px";
              });
              submit.removeAttribute("disabled");
            }
            if (msg.indexOf("n") !== -1) {
              userName.assign("Username is not a valid username.", "error").show();
            }
            if (msg.indexOf("e") !== -1) {
              userEmail.assign("Email is not a valid email.", "error").show();
            }
            if (msg.indexOf("u") !== -1) {
              userName.assign("Username already exists in database.", "error").show();
            }
            if (msg.indexOf("a") !== -1) {
              userEmail.assign("Email already exists in database.", "error").show();
            }
            if (msg.indexOf("p") !== -1) {
              userPwd.assign("Passwords did not meet the requirements or did not match.", "error").show();
              userPwdVal.assign("Passwords did not meet the requirements or did not match.", "error").show();
            }
            if (msg.indexOf("s") !== -1) {
              $("#content").animate({
                opacity: 0
              }, 500, function () {
                $(this).css("opacity", 1).html("<p>Thank you; your registration is now complete. After activation, you can login <a href='login.php'>here</a>.</p>");
              });
            }
            $submit.next().css("display", "");
            Recaptcha.reload(); // automatically reload reCAPTCHA
          }, 1000);
        }
      });
    });
  })(jQuery);

};
