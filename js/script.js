// js/jQ functions that are available to run on any page. requires jQuery.

// Set object for styling
var styles = {
  "baseTheme"                       : "core",
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

/******************
 * jQuery PLUGINS *
 ******************/

(function ($) {
  /**
   * makes the header an absolutely positioned element with a slide
   * in/out button for pages which can't have elements affecting
   * viewport size (themizer, try-it)
   */

  $.fn.sliderHeader = function () {
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
  };

  /**
   * slide sidebar in/out
   */

  $.fn.sliderSidebar = function () {
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
        // Split cssId into array so we can decompose it
        cssArray = cssId.split("-"),
        // Get selector for elements
        el       = cssArray[0].replace(/([a-z])(?=[A-Z])/, "$1-").toLowerCase().replace("class_", ".").replace("id_", "#"),
        // Get CSS property
        prop     = cssArray[1].replace(/([a-z])([A-Z])/, "$1-$2").toLowerCase(),
        // Value of `this`
        thisVal;

    this.change(function () {
      thisVal = useName !== true ? value || this.value : null; // this.val() throws error

      if (!$(this).hasClass("invalid")) {
        switch(prop) {
          // font-family
          case "font-family":
            var font = thisVal;
            if (font.indexOf(" ") !== -1) {
              font = '"' + font + '"';
            }
            font ? $(el).css("font-family", font + ", Calibri, Verdana, Arial, sans-serif") : $(el).css("font-family", "");
            break;

          // background-image
          case "background-image":
            $(el).css("background-image", "url(" + (thisVal.indexOf("http") === -1 ? "//" + thisVal : thisVal) + ")");
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
 * Toggle options
 *
 * Used to be jQuery plugin, but due to weird bugs was moved back to being a standalone function
 */
function optionToggle (id) {
  $("#" + id + " .option-wrap").slideToggle();
  var content = $("#" + id + " .option-title");

  if (content.hasClass("collapsed")) {
    content.removeClass("collapsed").addClass("expanded");
  } else {
    content.removeClass("expanded").addClass("collapsed");
  }
};

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
  // Set sidebar styles
  $("#sidebar")      .css("font-size", 2*vh);
  $("#sidebar-inner").width(sideWidth);
  $("#side-button").css("left", sideWidth);

  $("#blog-body").load("blog/blog-index.html");
  $("head").append("<link href='blog/css/core.css' type='text/css' rel='stylesheet' id='base-theme'>");

  // option slides sliding init
  $(".option").each(function () {
    var id = $(this).attr('id');
    $("#" + id + " .option-title").attr("onclick", "optionToggle('" + id + "')").addClass("collapsed");
  });

  // set all options with class `expanded` to be open
  $(".expanded").removeClass("collapsed");
  $(".expanded").next().slideDown(0);

  // view mode radios
  $("[name='view']").change(function () {
    $("#blog-body").load("blog/blog-" + $("[name='view'] :checked").val() + ".html");
  });
  $("[name='base']").change(function () {
    $("link[id='base-theme']").attr('href', "blog/css/" + $("[name='base'] :checked").val() + ".css");
    styles.baseTheme = $("[name='base'] :checked").val();
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
    if (idleState == true) {
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
  $("#submit").click(function () {
    for (var i in styles)
      console.log(i + ":" + styles[i]); // debugging
  });

  /**
   * Styling
   */

  // Check inputs for validity
  $("[type='url']").keyup(function () {
    $(this).val().match(/^(https?:\/\/)?[a-z0-9-\.]+\.[a-z]{2,4}\/([^\s<>%"\,\{\}\\|\\\^\[\]`]+)?\.(gif|jpg|jpeg|png|php|svg)(\?\w=\w)?(&\w=\w)*/) ? $(this).removeClass("invalid") : $(this).addClass("invalid");
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
            $(this).prev().val(color);
            $(el).css(prop, color);

            // update styles
            styles[id[1] + "-" + id[2]] = color;
          }
  });
  // Set color picker to corresponding text input's value when user types
  $(".spectrum.text").keyup(function () {
    var color  = $(this).val(),
        picker = $(this).next(),
        id     = $(this).attr("id").split(/-/),
        el     = id[1].replace(/([a-z])(?=[A-Z])/, "$1-").toLowerCase().replace("class_", ".").replace("id_", "#"),
        prop   = id[2].replace(/([a-z])([A-Z])/, "$1-$2").toLowerCase();
    $(el).css(prop, color);
    $(picker).spectrum("set", color);

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
 * Try-It init
 */

function tryit () {
  /*************
   * VARIABLES *
   *************/
  // get viewport height
  var vh = $(window).height()/100;

  // find width of sidebar and of sideButton
  var headerHeight = 11.6*vh,
      headerButtonHeight =  2*vh;

  // set whether user is active or not for later
  var idleTimer = null,
      idleState = true;

  /*************
   * FUNCTIONS *
   *************/
  // Set sidebar styles
  $("header")        .css("font-size", 2.22*vh);
  $("#headerwrap")   .height(headerHeight);
  $("#header-button").css("top", headerHeight);

  // Show/hide sideButton
  // modify sideButton on click
  $("#header-button").click(function () {
    // fires when sidebar is to be closed
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

  // show sideButton on mousemove + scroll
  // taken and modified from http://css-tricks.com/snippets/jquery/fire-event-when-user-is-idle/
  $(window).bind('mousemove scroll', function (event) {
    clearTimeout(idleTimer); // clear timeout if user acts

    // user active
    if (idleState == true) {
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

/**
 * Generate random colour
 *
 * May or may not use http://llllll.li/randomColor/ in the future
 */

//var randomColour = function() { return '#'+Math.floor(Math.random()*16777215).toString(16); };

/*laquo «
&#187; and it will looks like »*/
