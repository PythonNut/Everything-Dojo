/*********************************
 * Verification for register.php *
 *********************************/

// Get form element
//var form = document.getElementsByTagName("form")[0];

// Create div to wrap messages in
// Placed here so as to not mess them up
var div = document.createElement("div");

/**
 * Adds messages next to elements
 * @param {String} selector Valid CSS selector to select element to add message next to
 * @param {String} [msg="removeAll"] Message to display to user.
 * @param {String} msgClass Type of message. Can be "error", "valid", or "notification".
 * @param {Function} fn Function that can be called on remove or other
 */

function message(selector, msg, msgClass, fn)
{
  // Default argument testing
  msg = msg || "removeAll";

  // Correllate msgClass with corresponding class for selector
  var type = {
    "error"       : " invalid",
    "valid"       : " good",
    "notification": ""
  };

  // Get elClass
  var elClass  = type[msgClass];

  // Get element to display message next to
  var el = document.querySelector(selector);

  if (msg != "remove" && msg != "removeAll") {
    el.className += (el.className.indexOf(elClass) == -1) ? elClass : "";

    // insert message in DOM right after element
    el.parentNode.insertBefore(div, el.nextSibling);
    div.className = msgClass;
    div.innerHTML = msg;
  } else if (el.nextElementSibling && el.nextElementSibling.className == msgClass) {
    // removes error if msg is removeAll
    if (msg == "removeAll") {
      el.className = el.className.replace(elClass, "");
    }
    el.parentNode.removeChild(el.nextElementSibling);
  }

  if (typeof fn === "function") {
    fn();
  }
}

/**
 * Throws verification error(s). Is a wrapper for message().
 * @param {String} name Name of element with error
 * @param {String} [msg="removeAll"] Error message to display to user. Takes same arguments as `msg` in message()
 */

function err(name, msg)
{
  // Get field with error
  var element = "[name='" + name + "']";

  message(element, msg, "error", function() {
    var submit = document.getElementById("doRegister");
    (msg != "remove" && msg != "removeAll") ? submit.setAttribute("disabled", "disabled") : submit.removeAttribute("disabled");
  });
}

/**
 * Tells user that a field is valid. Is a wrapper for message().
 * @param {String} name Name of valid field
 * @param {String} [msg="removeAll"] Message to display to user. Takes same arguments as `msg` in message()
 */

function valid(name, msg)
{
  // Get field
  var element = "[name='" + name + "']";

  message(element, msg, "valid");
}

/**
 * Validates text that is entered into the fields.
 * @param {String} name Name of field to be validated
 */

function validate(name)
{
  // Get element
  var field = document.querySelector("[name='" + name + "']");

  // Username
  // TODO: Add AJAX to send usernames to PHP backend to check if they are free
  if (name == "user_name") {
    var user = field.value;
    if (!user.match(/^[a-z\d_]{3,20}$/i)) {
      valid(name);
      err(name, "Invalid username. Usernames must be 3-20 characters long and can only contain alphanumeric characters and underscores.");
    } else {
      err(name);
      // ajax to verify username
      var ajaxName = new XMLHttpRequest();
      ajaxName.onreadystatechange = function() {
        if (ajaxName.readyState == 4 ) {
          if (ajaxName.status == 200) {
            err(name);
            valid(name, "Username is valid.");
          }
          else if (ajaxName.status == 400) {
            valid(name);
            err(name, "Username already exists! Please choose a new one.");
          }
          else {
            valid(name);
            err(name, "A " + ajaxName.status + " error occurred. Please try again.", "error");
          }
        }
      };

      ajaxName.open("GET", "register.php?username=" + user, true);
      ajaxName.send();
    }
  }

  // Email
  if (name == "usr_email") {
    var email = field.value;
    if (!email.match(/^\S+@(localhost|([\w\d-]{2,}\.){1,2}[\w]{2,6})$/i)) {
      err(name, "Email entered is not a valid email.");
    } else {
      err(name);
      // ajax to verify email
      var ajaxEmail = new XMLHttpRequest();
      ajaxEmail.onreadystatechange = function() {
        if (ajaxEmail.readyState == 4 ) {
          if (ajaxEmail.status == 200) {
            err(name);
            valid(name, "Email is valid.");
          }
          else if (ajaxEmail.status == 400) {
            valid(name);
            err(name, "Email address already exists in our database! Please do not create multis.");
          }
          else {
            valid(name);
            err(name, "A " + ajaxEmail.status + " error occurred. Please try again.", "error");
          }
        }
      };

      ajaxEmail.open("GET", "register.php?email=" + email, true);
      ajaxEmail.send();
    }
  }

  // Password
  if (name == "pwd") {
    var pwd = field.value;
    if (pwd.length < 6) {
      err(name, "Passwords must be at least 6 characters long.");
    } else {
      err(name);
    }
  }

  // Password verification
  // There has to be a better way to do this
  if (name == "pwd2") {
    var original = document.querySelector("[name='pwd']").value,
        verify   = field.value;
    if (original != verify) {
      err(name, "Passwords do not match.");
    } else {
      err(name);
    }
  }
}

