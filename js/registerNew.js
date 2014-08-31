"use strict"

/**********************************************************************
 *                                                                    *
 *                   Adds messages next to elements                   *
 *        Originially designed for register.php, now site-wide        *
 *                                                                    *
 **********************************************************************/

/**
 * Base class for adding messages.
 *
 * TODO: Add support for multiple elements
 *
 * @class Message
 * @constructor
 */
function Message (selector)
{
  this.el = document.querySelector(selector);
  if (this.el.length < 2) {
    this.el = this.el[0];
  } else {
    this.multiple = true;
  }
}

/**
 * Assigns text and type to an element's message. Alias for <el>.msg = msg and <el>.type = type
 *
 * @method assign
 * @param {String} msg The message.
 * @param {String} type The type.
 * @chainable
 */
Message.prototype.assign = function (msg, type) {
  this.msg = msg;
  this.type = type;
  return this;
};

/**
 * Shows an element's message
 *
 * @method show
 * @param {Function} [fn] A function to be fired when the event is complete
 * @chainable
 */
Message.prototype.show = function (fn) {
  var type = {
    "error"       : " invalid",
    "valid"       : " good",
    "notification": ""
  };

  var el = this.el;

  // Get elClass
  var elClass  = type[this.type];

  el.className += (el.className.indexOf(elClass) == -1) ? elClass : "";

  // insert message in DOM right after element
  if (!el.nextElementSibling || !el.nextElementSibling.className.match(/(^|\s)(error|valid|notification)($|\s)/)) {
    var insertEl = "<div class='note " + this.type + "'>" + this.msg + "</div>";
    el.insertAdjacentHTML("afterend", insertEl);
  }

  if (typeof fn === "function") {
    fn();
  }

  return this;
};

/**
 * Replaces an element's message
 *
 * @method replace
 * @param {Function} [fn] A function to be fired when the event is complete
 * @chainable
 */
Message.prototype.replace = function (fn) {
  var msgWrap = this.el.nextElementSibling;
  if (msgWrap) {
    msgWrap.className = msgWrap.className.replace(/(error|valid|notification)/, this.type);
    msgWrap.innerHTML = this.msg;
  }

  if (typeof fn === "function") {
    fn();
  }

  return this;
};

/**
 * Hides an element's message, but keeps the corresponding class
 *
 * @method hide
 * @param {Function} [fn] A function to be fired when the event is complete
 */
Message.prototype.hide = function (fn) {
  var msgWrap = this.el.nextElementSibling;
  if (msgWrap && msgWrap.className.match(/(^|\s)(error|valid|notification)($|\s)/)) {
    this.el.parentNode.removeChild(msgWrap);
  }

  if (typeof fn === "function") {
    fn();
  }
};

/**
 * Completely removes all traces of an element's message
 *
 * @method purge
 * @param {Function} [fn] A function to be fired when the event is complete
 */
Message.prototype.purge = function (fn) {
  this.hide();

  this.el.className = this.el.className.replace(/(^|\s)(invalid|good)($|\s)/, "");

  if (typeof fn === "function") {
    fn();
  }
};

/*
function FieldError (selector)
{
  Message.call(this, selector);

  this.type = "error";
}

FieldError.prototype = Object.create(Message.prototype);

FieldError.prototype.constructor = FieldError;
*/
