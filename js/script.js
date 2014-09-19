/* jshint browser:true, jquery:true, -W098 */
/* global ZeroClipboard:false, prettyPrint:false, randomColor:false */

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

  el.className = !el.className.match(/(invalid|valid)/) ? el.className + this.elType : el.className.replace(/(invalid|valid)/, this.elType);

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
    this.el.className = this.el.className.replace(/(invalid|valid)/, this.elType);
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

// js/jQ functions that are available to run on any page. requires jQuery.

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
  };

  /**
   * Generate random colour
   * Uses randomColor.js
   */

  $.fn.styleRandomColor = function () {
    var colour = randomColor();
    this.prev(".text").val(colour).trigger("keyup");
    this.next(".color-picker").spectrum("set", colour);
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
  };

}(jQuery));

/**
 * makes the header an absolutely positioned element with a slide
 * in/out button for pages which can't have elements affecting
 * viewport size (themizer, try-it)
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
 * slide sidebar in/out
 */

function sliderSidebar () {
  // figure out width of sidebar for positioning when hidden/shown
  var sideWidth = $("#sidebar").width();

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
}

/**
 * Themizer init
 */
function themizer () {
  /*************
   * VARIABLES *
   *************/
  // get viewport height
  var vh = $(window).height()/100;

  // find width of sidebar and of sideButton
  var sideWidth       = 32*vh,
      sideButtonWidth =  2*vh;

  // set whether user is active or not for later
  var idleTimer = null,
      idleState = true;

  /*************
   * FUNCTIONS *
   *************/
  // sidebar sliding init
  sliderSidebar();

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

  // view mode radios
  $("[name='view']").change(function () {
    $("#blog-body").load("blog/blog-" + $("[name='view'] :checked").val() + ".html");
  });
  $("[name='base']").change(function () {
    $("link[id='base-theme']").attr('href', "blog/css/" + $("[name='base'] :checked").val() + ".css");
    baseTheme = $("[name='base'] :checked").val();
  });

  // resize sidebar
  // modified from https://stackoverflow.com/a/4139860
  $("#side-resizer").mousedown(function () {
    $(document).mousemove(function (event) { // use document to avoid conflict with sideButton
      var mousePosX = event.pageX;
      sideWidth = mousePosX > 32*vh ? mousePosX : sideWidth; // set original width as minimum
      $("#sidebar-inner").width(sideWidth);
      // move sideButton and remove transitions as they screw the former up
      $("#side-button").css({
        "left": sideWidth,
        "transition": "0s linear"
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
    if (event.pageX < sideWidth*2/3) {
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

/**
 * Themizer (Regular mode)
 */
function themizerRegular () {
  themizer();
  // Base style
  $("head").append("<link href='blog/css/core.css' type='text/css' rel='stylesheet' id='base-theme'>");

  /* Get Code */
  $("#submit").click(function () {

    var code = '';

    $.ajax({
      url: "/blog/css/" + baseTheme + ".css",
      async: false,
      success: function(cssContent) {
        code += cssContent + "\n\n";
      }
    });

    code += "/* --- CUSTOM THEMIZER STYLING --- */\n\n";

    var selectors = {};
    for (var i in styles) {
      var split = i.split('-'),
          selector = split[0].replace(/([a-z])(?=[A-Z])/, "$1-").toLowerCase().replace("class_", ".").replace("id_", "#"),
          attribute = split[1].replace(/([a-z])([A-Z])/, "$1-$2").toLowerCase(),
          value = styles[i];
      if (selectors.hasOwnProperty(selector) === false) {
        selectors[selector] = {};
      }
      selectors[selector][attribute] = value;
    }

    var thiselement;
    for (var j in selectors) {
      thiselement = '';
      thiselement += j + " {\n";
      for (var k in selectors[j]) {
        if (selectors[j][k] || selectors[j][k] !== '') {
          thiselement += "    " + k + ": " + selectors[j][k] + ";\n";
        }
      }
      thiselement += "}\n\n";
      code += thiselement;
    }

    /**
     * ZeroClipboard
     */
    var client = new ZeroClipboard($("#copycode"));

    client.on("ready", function (readyEvent) {
      client.on("aftercopy", function (event) {
        event.target.innerHTML= "Copied";
        event.target.classList.add("hover");
      });
    });

    /**
     * Lightbox
     */
    // Add code to the pre
    $("#lightbox-wrap pre").html(code);

    // Reset #copybutton to pre-copied state
    $("#copycode.hover").text("Copy code to clipboard").removeClass("hover");

    // Google-Code-Prettify won't do its job if the pre has class `prettyprinted`
    // http://stackoverflow.com/a/15984048/3472393
    $("#lightbox-wrap pre.prettyprinted").removeClass("prettyprinted");
    prettyPrint();
    $("#lightbox").show();

  });

  /**
   * Styling
   */

  // Check inputs for validity
  $("[type='url']").keyup(function () {
    if ($(this).val().match(/^(https?:\/\/|\/\/)?[a-z0-9-\.]+\.[a-z]{2,4}\/([^\s<>%"\,\{\}\\|\\\^\[\]`]+)?\.(gif|jpg|jpeg|png|php|svg)(\?\w=\w)?(&\w=\w)*/) || !$(this).val()) {
      $(this).prev(".invalid-msg").remove();
      $(this).removeClass("invalid");
    } else if (!$(this).hasClass("invalid")) {
      $("<p class=\"invalid-msg\">This URL is invalid!</p>").insertBefore(this);
      $(this).addClass("invalid");
    }
  });

  // Body
  $("#body-backgroundImage").style();
  $("[name='body-backgroundRepeat']").style(true);
  $("#body-fontFamily").style();

  /**
   * Spectrum
   */

  // Initialize default settings
  $(".spectrum.color-picker").spectrum({
    preferredFormat: "name",
    showAlpha: true,
    showInitial: true,
    showButtons: false,
    // change corresponding text input's value when user drags slider(s)
    move: function (color) {
            // this is as the IDs follow the pattern
            // spectrum-<selector>-<CSSProperty (camelCased)>
            // Hence, we can deconstruct the id to produce our desired selectors.
            var id   = $(this).attr("id").split(/-/),
                el   = id[1].replace(/([a-z])(?=[A-Z])/, "$1-").toLowerCase().replace("class_", ".").replace("id_", "#"),
                prop = id[2].replace(/([a-z])([A-Z])/, "$1-$2").toLowerCase();
            $(this).prevAll(".text").val(color);
            $(el).css(prop, color);

            // update styles
            styles[id[1] + "-" + id[2]] = color;
          }
  });
  // Set color picker to corresponding text input's value when user types
  $(".spectrum.text").keyup(function () {
    var color  = $(this).val(),
        id     = $(this).attr("id").split(/-/),
        el     = id[1].replace(/([a-z])(?=[A-Z])/, "$1-").toLowerCase().replace("class_", ".").replace("id_", "#"),
        prop   = id[2].replace(/([a-z])([A-Z])/, "$1-$2").toLowerCase();
    $(el).css(prop, color);
    $(this).nextAll(".color-picker").spectrum("set", color);

    // update styles
    styles[id[1] + "-" + id[2]] = color;
  });
  // Reposition picker when user scrolls sidebar
  $("#sidebar-inner").bind("scroll", function () {
    $(".spectrum.color-picker").spectrum("reflow");
  });

  $(window).mousemove();
}

/**
 * Themizer (Developer mode)
 */
function themizerDev () {
  themizer();
  $("head").append('<style id="dev-style"></style>');

  // remove submit button and make sidebar-inner full height
  $("#submit").remove();
  $("#sidebar-inner").css("padding-bottom", "0");
}
/**
 * Try-It init
 */

function tryit () {
  /*************
   * VARIABLES *
   *************/
  // get viewport height
  var vh = $(window).height()/100;

  // find width of header and of headerButton
  var headerHeight = 11.6*vh,
      headerButtonHeight =  2*vh;

  // set whether user is active or not for later
  var idleTimer = null,
      idleState = true;

  /*************
   * FUNCTIONS *
   *************/
  // header sliding init
  sliderHeader();

  // Set header styles
  $("header")        .css("font-size", 2.22*vh);
  $("#headerwrap")   .height(headerHeight);
  $("#header-button").css("top", headerHeight);

  // Show/hide headerButton
  // modify headerButton on click
  $("#header-button").click(function () {
    // fires when header is to be closed
    if ($("header").css("top") == "0px" && $("header").hasClass("opened")) {
      $("#header-button").addClass("triggered");
      $("#blog-body").animate({
        marginTop: 0
      }, 400);
      idleState = true; // since user is active
    } else {
      $("#header-button").removeClass("targeted");
      $("#blog-body").animate({
        marginTop: 13.6*vh
      });
    }
  });

  // show headerButton on mousemove + scroll
  // taken and modified from http://css-tricks.com/snippets/jquery/fire-event-when-user-is-idle/
  $(window).bind('mousemove scroll', function (event) {
    clearTimeout(idleTimer); // clear timeout if user acts

    // user active
    if (idleState === true) {
      // Reactivated event
      $(".closed #header-button").addClass("triggered").animate({
        top: headerHeight
      }, 100);
    }

    // user mouse in "targeted" zone
    // We cannot use jQuery animations as they are too CPU-intensive
    // Instead, we just add .targeted.
    if ($("header").hasClass("closed")) {
      if (event.pageY < headerHeight) {
        $(".closed #header-button").addClass("targeted");
        $("#blog-body").css("margin-top", 2*vh);
      } else {
        $(".closed #header-button").removeClass("targeted");
        $("#blog-body").css("margin-top", 0);
      }
    }

    idleState = false;

    // user inactive
    idleTimer = setTimeout(function () {
      // Idle Event
      // cursor outside target zone
      $("#header-button").removeClass("triggered");
      $(".closed #header-button:not(:hover):not(.targeted)").animate({
        top: headerHeight - headerButtonHeight
      }, 1500);
      // cursor inside target zone
      $("#header-button").removeClass("targeted");
      idleState = true;
    }, 4000);
  });

  $(window).mousemove();
}
