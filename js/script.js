/* global ZeroClipboard:false, Prism:false, randomColor:false */

//This document requires jQuery to be loaded in order to properly run.


/*******************
 * ARRAY FUNCTIONS *
 *******************/

/**
 * Returns the `nth` last element of an array. If `nth` is not
 * specified or `nth > Array.length`, returns the last element instead.
 *
 * @param {Integer} [nth] If specified, the nth last element of the array
 */
Array.prototype.last = function(nth) {
  return this[this.length - (1 <= nth && nth < this.length ? nth : 1)];
};

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
function Message (selector) {
  if (typeof selector === "string") {
    this.el = document.querySelector(selector);
  } else if (selector instanceof jQuery) {
    this.el = selector.context;
  } else if (selector instanceof Element) {
    this.el = selector;
  } else {
    throw new Error("selector does not refer to an element.");
  }
//  if (this.el.length < 2) {
//    this.el = this.el[0];
//  console.log(this.el);
//  } else {
//    this.multiple = true;
//  }
}

/**
 * Assigns text and type to an element's message. Alias for <el>.msg = msg and <el>.type = type
 *
 * @method assign
 * @param {String} msg The message.
 * @param {String} [type] The type.
 * @chainable
 */
Message.prototype.assign = function (msg, type) {
  this.msg = msg;
  if (type || this.type) {
    this.type = type || this.type;
  } else {
    console.error("Type is undefined");
  }
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
  var tmpType = {
    "error"       : " invalid",
    "correct"     : " valid",
    "notification": ""
  };

  var el = this.el;

  // Get elClass
  this.elType = tmpType[this.type] || this.type;

  el.className = !el.className.match(/(invalid|valid)/) ? el.className + this.elType : el.className.replace(/ (invalid|valid)/, this.elType);

  // insert message in DOM right after element
  if (!el.nextElementSibling || !el.nextElementSibling.className.match(/(error|correct|notification)/)) {
    var insertEl = "<div class='note " + this.type + "'>" + this.msg + "</div>";
    el.insertAdjacentHTML("afterend", insertEl);
  } else if (el.nextElementSibling.className.match(/(error|correct|notification)/)) {
    this.replace();
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
    msgWrap.className = msgWrap.className.replace(/(error|correct|notification)/, this.type);
    msgWrap.innerHTML = this.msg;
    this.el.className = this.el.className.replace(/ (invalid|valid)/, this.elType);
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
  if (msgWrap && msgWrap.className.match(/(^|\s)(error|correct|notification)($|\s)/)) {
    this.el.parentNode.removeChild(msgWrap);
  }

  if (typeof fn === "function") {
    fn();
  }

  return this;
};

/**
 * Completely removes all traces of an element's message
 *
 * @method purge
 * @param {Function} [fn] A function to be fired when the event is complete
 */
Message.prototype.purge = function (fn) {
  this.hide();

  this.el.className = this.el.className.replace(/(^|\s)(invalid|valid)($|\s)/, "$3");

  if (typeof fn === "function") {
    fn();
  }
  return this;
};


/******************
 * jQuery PLUGINS *
 ******************/

(function ($) {
  /**
   * Popup function
   * Mainly for #credits, but can be used in other places
   *
   * @param {String} top How far the popup should be from the top of the window
   */
  $.fn.popUp = function(top) {
    var that = this,
        itop = that.css("top");
    this.css("top", top);
    $(".overlay-wrapper").css({
      "pointer-events"  : "all",
      "background-color": "rgba(255, 255, 255, 0.5)"
    });

    //Exit popup
    $(".overlay-wrapper").click(function() {
      that.css("top", itop);
      $(".overlay-wrapper").css({
        "pointer-events"  : "",
        "background-color": ""
      });
    });
    $('#credits').click(function(e){
        e.stopPropagation(); //clicking on the box doesn't work, but only OUTSIDE of the box closes.
    });

    return this;
  };

  /**
   * Scroll to an element.
   * Based on https://stackoverflow.com/a/6677069
   *
   * @param {Integer} [duration=1000] Duration, in milliseconds, of the animation
   */
  $.fn.scrollTo = function (duration) {
    duration = duration || 1000;

    $('html, body').animate({
      scrollTop: this.offset().top
    }, duration);

    // make chainable
    return this;
  };

  /**
   * Toggle options
   */
  $.fn.optionToggle = function () {
    $(this).next().slideToggle();
    var content = $(this);

    if (content.hasClass("collapsed")) {
      content.removeClass("collapsed").addClass("expanded");
    } else {
      content.removeClass("expanded").addClass("collapsed");
    }

    return this;
  };

  /**
   * Generate random colour
   * Uses randomColor.js
   */

  $.fn.styleRandomColor = function () {
    var colour = randomColor();
    this.prev(".text").val(colour).trigger("keyup");
    this.next(".color-picker").spectrum("set", colour);

    return this;
  };

  /**
   * Style an element with a CSS property and a valid value, with the
   * former two being derived from `<selector>` and the latter being
   * derived from `<selector>`'s value.
   *
   * @param {Boolean} [useName] Whether or not the fields should be selected by their `name` attribute
   * @param {String}  [value]   An optional value to assign to the CSS property
   */

  $.fn.style = function (useName, value) {
    var // Get selector of corresponding field
        id       = useName === true ? "[name='" + this.attr("name") + "']" : "#" + this.attr("id"),
        // Create a temp variable from which we decompose the selector and property
        cssId    = useName === true ? this.attr("name") : this.attr("id"),
        cssArray = cssId.split("-"),
        // Get selector for elements
        el       = cssArray[0].replace(/([a-z])(?=[A-Z])/, "$1-").toLowerCase().replace("class_", ".").replace("id_", "#"),
        // Get CSS property
        prop     = cssArray[1].replace(/([a-z])([A-Z])/, "$1-$2").toLowerCase(),
        thisVal;

    this.change(function () {
      thisVal = useName !== true ? value || this.value : null; // this.val() throws error

      if (!$(this).hasClass("invalid")) {
        switch(prop) {
          // font-family
          case "font-family":
            if (thisVal.indexOf(" ") !== -1) {
              thisVal = '"' + thisVal + '"';
            }
            $(el).css("font-family", thisVal ? (thisVal + ", Calibri, Verdana, Arial, sans-serif") : "");
            break;

          // background-image
          case "background-image":
            if (thisVal) {
              thisVal = "url('" + ((thisVal.indexOf("http") !== 0 && thisVal.indexOf("//") !== 0) ? "//" + thisVal : thisVal) + "')";
            }
            $(el).css("background-image", thisVal);
            break;

          // background-repeat
          case "background-repeat":
            thisVal = $(id + ":checked").val();
            $(el).css("background-repeat", thisVal);
            break;

          // default case
          default:
            $(el).css(prop, thisVal);
        }

        styles[cssId] = thisVal;
      }
    });

    return this;
  };

}(jQuery));

/**
 * makes the header an absolutely positioned element with a slide
 * in/out button for pages which can't have elements affecting
 * viewport size (themizer, try-it)
 * NOT IN USE
 */

function sliderHeader () {
  var classcolor = $("header").attr("class");
  var headerHeight = $("header").height();
  $("header").css("position", "absolute")
             .append('<div id="header-button" class="slideButton down ' + classcolor + '"></div>');

  var openHeader = true;
  $("header").addClass("opened");

  $("#header-button").click(function () {
    if (openHeader) {
      $("header").animate({
        top: -headerHeight
      }, 400, function () {
        $(this).removeClass("opened").addClass("closed");
      });

      $(this).animate({
        top: headerHeight
      }, 400);

      openHeader = false;

    } else {
      $("header").removeClass("closed").addClass("opened").animate({
        top: 0
      }, 400);

      $(this).animate({
        top: headerHeight
      }, 400);

      openHeader = true;
    }
  });
}

/**
 * sliding sidebar in and out with responsive sizing and ultra cool open close button functionality
 */
function sliderSidebar () { //referring to the exact and non-general (for lack of a better word) functionality of the sidebar in Themizer and Try-It
  /*** VARIABLES ***/
  // get viewport height
  var vh = $(window).height()/100;

  // find width of sidebar and of sideButton
  var sideWidth = $("#sidebar").width(), //32 * vh used to be here but it was being overwritten by this later declaration w/ CSS
      sideButtonWidth =  2*vh;

  // set whether user is active or not for later
  var idleTimer = null,
      idleState = true;

  // figure out width of sidebar for positioning when hidden/shown

  /*** FUNCTIONS ***/
  // add open/hide button
  $("#sidebar").append('<div id="side-button" class="slideButton right">&laquo;</div>');

  // sidebar is opened at first
  var openSide = true;
  $("#sidebar").addClass("opened");

  // main sliding function
  $("#side-button").click(function () {
    sideWidth = $("#sidebar").width(); // in case sidebar has been resized
    if (openSide) {
      $("#sidebar").animate({
        left: -sideWidth
      }, 400, function () {
        $(this).removeClass("opened").addClass("closed");
      });

      $(this).html("&raquo;")
             .animate({
        left: sideWidth
      }, 400);

      openSide = false;

    } else {
      $("#sidebar").removeClass("closed").addClass("opened").animate({
        left: 0
      }, 400);

      $(this).html("&laquo;")
             .animate({
        left: sideWidth
      }, 400);

      openSide = true;
    }
  });

  // Set sidebar styles
  $("#sidebar")      .css("font-size", 2*vh);
  $("#sidebar-inner").width(sideWidth);
  $("#side-button")  .css("left", sideWidth);

  $("#blog-body").load("blog/blog-index.html");

  // option slides sliding init
  $(".option").each(function () {
    var id = $(this).attr('id');
    $("#" + id + " .option-title").attr("onclick", "$(this).optionToggle()").addClass("collapsed");
  });

  // set all options with class `expanded` to be open
  $(".expanded").removeClass("collapsed");
  $(".expanded").next().slideDown();

  // view mode radios; these appear in both themizer & try-it
  $("[name='view']").change(function () {
    $("#blog-body").load("blog/blog-" + $("[name='view'] :checked").val() + ".html", function () {
      $(".text").trigger("keyup");
    });
  });
  $("[name='base']").change(function () {
    $("link[id='base-theme']").attr('href', "blog/css/" + $("[name='base'] :checked").val() + ".css", function () {
      $(".text").trigger("keyup");
    });
    baseTheme = $("[name='base'] :checked").val();
  });

  // resize sidebar
  // modified from https://stackoverflow.com/a/4139860
  $("#side-resizer").mousedown(function () {
    $(document).mousemove(function (event) { // use document to avoid conflict with sideButton
      var mousePosX = event.pageX;
      sideWidth = mousePosX > 34*vh ? mousePosX : sideWidth; // set original width as minimum
      $("#sidebar-inner").css({
        "width": sideWidth - 2*vh,
        "transition": "0.1s linear"
      });
      // move sideButton and remove transitions as they screw the former up
      $("#side-button").css({
        "left": sideWidth - 2*vh,
        "transition": "0.1s linear"
      });
    });
  });
  $(document).bind("mouseup click", function () {
    $(document).unbind("mousemove");
    // readd transitions
    $("#side-button").css({
      "transition": ""
    });
  });

  // Show/hide sideButton
  // modify sideButton on click
  $("#side-button").click(function () {
    // fires when sidebar is to be closed
    if ($("#sidebar").css("left") == "0px" && $("#sidebar").hasClass("opened")) {
      $("#side-button").addClass("triggered");
      idleState = true; // since user is active
    } else {
      $("#side-button").removeClass("targeted");
    }
  });

  // show sideButton on mousemove + scroll
  // taken and modified from http://css-tricks.com/snippets/jquery/fire-event-when-user-is-idle/
  $(window).bind('mousemove scroll', function (event) {
    clearTimeout(idleTimer); // clear timeout if user acts

    // user active
    if (idleState === true) {
      // Reactivated event
      $(".closed #side-button").addClass("triggered").animate({
        left: sideWidth
      }, 100);
    }

    // user mouse in "targeted" zone
    // We cannot use jQuery animations as they are too CPU-intensive
    // Instead, we just add .targeted.
    if (event.pageX < sideWidth * 2/3) {
      $(".closed #side-button").addClass("targeted");
    } else {
      $(".closed #side-button").removeClass("targeted");
    }

    idleState = false;

    // user inactive
    idleTimer = setTimeout(function () {
      // Idle Event
      // cursor outside target zone
      $("#side-button").removeClass("triggered");
      $(".closed #side-button:not(:hover):not(.targeted)").animate({
        left: sideWidth - sideButtonWidth
      }, 1500);
      // cursor inside target zone
      $(".closed #side-button.targeted:not(:hover)").animate({
        left: sideWidth - 2*sideButtonWidth
      }, 3000, function() {
        $("#side-button").removeClass("targeted");
      });
      idleState = true;
    }, 4000);
  });
}

/*******************
 *   THEMIZER JS   *
 *******************/

// Specify base theme
var baseTheme = "core";

// Set object for styling
var styles = {
  "body-backgroundColor"            : "white",
  "body-backgroundImage"            : "",
  "body-backgroundRepeat"           : "",
  "body-fontFamily"                 : "",
  "id_wrapper-backgroundColor"      : "#EDEDEA",
  "class_entry-backgroundColor"     : "#EDEDEA",
  "class_entrywrap-backgroundColor" : "#EDEDEA",
  "class_row1-backgroundColor"      : "#EDEDEA",
  "class_row2-backgroundColor"      : "#EDEDEA"
};


/*******************
 *    TRY-IT JS    *
 *******************/
/**
 * Try-It init
 */
function tryit () {
  sliderSidebar();
  $(window).mousemove();
}


/*******************
 *  NOTIFICATIONS  *
 *******************/
$(function () {
  $("#notifications").hide();

  $('body').click(function (e) {
    if($(e.target).closest('.notification-link, #notifications').length === 0) {
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
