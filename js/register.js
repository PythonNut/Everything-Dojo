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

  // AJAX stuff
  var ajaxName  = new XMLHttpRequest(),
      ajaxEmail = new XMLHttpRequest();

  /**
   * Validation
   */

  // Username
  userName.el.onkeyup = function (e) {
    var user = userName.el.value,
        keycode = ('which' in e) ? e.which : e.keyCode; // key validation

    if ((keycode > 47 && keycode < 58) || (keycode > 64 && keycode < 91) || (keycode > 95 && keycode < 112) || (keycode > 185 && keycode < 193) || (keycode > 218 && keycode < 223) || keycode == 32 || keycode == 8 || keycode == 13 || keycode == 46) {
      if (!user.match(/^[a-z\d_]{3,20}$/i)) {
        clearTimeout(window.userTimeout);
        ajaxName.abort(); // abort ajax request if already sent
        userName.assign("Invalid username. Usernames must be 3-20 characters long and can only contain alphanumeric characters and underscores.", "error").show();
        userName.el.parentNode.lastElementChild.style.display = "none"; // hide loading gif
      } else {
        clearTimeout(window.userTimeout);
        ajaxEmail.abort();
        userName.purge();
        userName.el.parentNode.lastElementChild.style.display = "inline"; // show loading gif
        // ajax to verify username
        ajaxName.onreadystatechange = function() {
          if (ajaxName.readyState == 4 ) {
            if (ajaxName.status == 200) {
              userName.assign("Username is valid.", "correct").show();
            } else if (ajaxName.status == 400) {
              userName.assign("Username already exists! Please choose a new one.", "error").show();
            } else {
              userName.assign("A " + ajaxName.status + " error occurred. Please try again.", "error").show();
            }
            userName.el.parentNode.lastElementChild.style.display = "none"; // hide loading gif
          }
        };

        // set 400ms timeout because we're getting results too fast, and
        // users won't know whether the AJAX got through or not :P
        window.userTimeout = setTimeout(function() {
          ajaxName.open("GET", "register.php?username=" + user, true);
          ajaxName.send();
        }, 300);
      }
    }
  };

  // Email
  userEmail.el.onkeyup = function (e) {
    var email = userEmail.el.value,
        keycode = ('which' in e) ? e.which : e.keyCode; // key validation

    if ((keycode > 47 && keycode < 58) || (keycode > 64 && keycode < 91) || (keycode > 95 && keycode < 112) || (keycode > 185 && keycode < 193) || (keycode > 218 && keycode < 223) || keycode == 32 || keycode == 8 || keycode == 13 || keycode == 46) {
      if (!email.match(/^\S+@(localhost|([\w\d-]{2,}\.){1,2}[\w]{2,6})$/i)) {
        clearTimeout(window.emailTimeout);
        ajaxEmail.abort();
        userEmail.assign("Email entered is not a valid email.", "error").show();
        userEmail.el.parentNode.lastElementChild.style.display = "none"; // hide loading gif
      } else {
        clearTimeout(window.emailTimeout);
        ajaxEmail.abort();
        userEmail.purge();
        userEmail.el.parentNode.lastElementChild.style.display = "inline"; // show loading gif
        // ajax to verify email
        ajaxEmail.onreadystatechange = function() {
          if (ajaxEmail.readyState == 4 ) {
            if (ajaxEmail.status == 200) {
              userEmail.assign("Email is valid.", "correct").show();
            } else if (ajaxEmail.status == 400) {
              userEmail.assign("Email address already exists in our database! Please do not create multis.", "error").show();
            } else {
              userEmail.assign("A " + ajaxEmail.status + " error occurred. Please try again.", "error").show();
            }
            userEmail.el.parentNode.lastElementChild.style.display = "none"; // hide loading gif
          }
        };

        // set 400ms timeout for same reasons as with username
        window.emailTimeout = setTimeout(function() {
          ajaxEmail.open("GET", "register.php?email=" + email, true);
          ajaxEmail.send();
        }, 300);
      }
    }
  };

  // Password
  userPwd.el.onkeyup = function () {
    var pwd = userPwd.el.value;
    if (pwd.length < 6) {
      userPwd.assign("Passwords must be at least 6 characters long.", "error").show();
    } else {
      userPwd.purge();
    }
  };

  // Check password
  userPwdVal.el.onkeyup = function () {
    var original = document.querySelector("[name='pwd']").value,
        verify   = userPwdVal.el.value;
    if (original != verify) {
      userPwdVal.assign("Passwords do not match.", "error").show();
    } else {
      userPwdVal.purge();
    }
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

};
