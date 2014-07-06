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
 * @param {String} msg Message to display to user. Can be a string, "remove", or "removeAll".
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
 * @param {String} msg Error message to display to user. Takes same arguments as `msg` in message(), and can be empty in place of "remove".
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
 * @param {String} msg Message to display to user. Takes same arguments as `msg` in message(), and can be empty in place of "remove".
 */

function valid(name, msg)
{
  // Get field
  var element = "[name='" + name + "']";

  message(element, msg, "valid");
}

/** 
 * Checks to see if usernames are available.
 * @param {String} username Username to be checked
 */

// function checkUsername(username) {
//   var ajax = new XMLHttpRequest();
//   ajax.onreadystatechange = function() {
//     if (ajax.readyState == 4 ) {
//       if(ajax.status == 200){
//         return true;
//       }
//       else if(ajax.status == 400) {
//         return false;
//       }
//       else {
//         err("user_name", "A " + ajax.status + " error occurred. Please try again.", "error");
//       }
//     }
//   }
// 
//   ajax.open("GET", "register.php?username=" + username, true);
//   ajax.send();
// }


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
//    } else if (!checkUsername(user)) {
//      valid(name);
//      err(name, "Username already exists! Please choose a new one.");
    } else {
      err(name);
      valid(name, "Username is valid");
    }
  }

  // Email
  if (name == "usr_email") {
    var email = field.value;
    if (!email.match(/^\S+@([\w\d-]{2,}\.){1,2}[\w]{2,6}$/i)) {
      err(name, "Email entered is not a valid email.");
    } else {
      err(name);
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

