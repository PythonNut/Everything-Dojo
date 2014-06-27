/*********************************
 * Verification for register.php *
 *********************************/

// Get form element
//var form = document.getElementsByTagName("form")[0];
//var form = function() { document.getElementById("register"); };

/**
 * Throw errors
 * @param {String} name Name of element next to which we throw errors to
 * @param {String} msg Error message to display to user. If "remove", removes error message.
 */

function err(name, msg)
{
  // (1) Get field with error
  // (2) Create div to wrap error message in
  var el  = document.querySelector("[name='" + name + "']"), // (1)
      div = document.createElement("div");                   // (2)

  if (el.className.indexOf("invalid") == -1 && msg != "remove") {
    el.className += " invalid";

    // insert error message in DOM right after offending field
    el.parentNode.insertBefore(div, el.nextSibling);
    div.className += "error";
    div.innerHTML = msg;
  } else if (el.nextElementSibling.className == "error") {
    // removes error
    el.className = el.className.replace(/(?:^|\s)invalid(?!\S)/, ''); // https://stackoverflow.com/a/9959811
    el.parentNode.removeChild(el.nextElementSibling);
  }
}

/**
 * Validate text that is entered into the fields
 * @param {String} name Name of field to be validated
 */

function validate(name)
{
  // Get element
  var field = document.querySelector("[name='" + name + "']");

  // Username
  if (name == "user_name") {
    var user = field.value;
    if (!user.match(/^[a-z\d_]{3,20}$/i)) {
      err(name, "Invalid username. Usernames must be 3-20 characters long and can only contain alphanumeric characters and underscores.");
    } else {
      err(name, "remove");
    }
  }

  // Email
  if (name == "usr_email") {
    var email = field.value;
    if (!email.match(/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/i)) {
      err(name, "Email entered is not a valid email.");
    } else {
      err(name, "remove");
    }
  }
}
