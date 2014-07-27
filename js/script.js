// js/jQ functions that are available to run on any page. requires jQuery.

/**
 * makes the header an absolutely positioned element
 * with a slide in/out button for pages which can't
 * have elements affecting viewport size (themizer, try-it)
 */

function sliderHeader() {
  var classcolor = $("header").attr("class");
  var headerHeight = $("header").height();
  $("header").css("position", "absolute")
             .append("<div id=\"headerButton\" class=\"slideButton down " + classcolor + "\">Close</div>");
  var openHeader = true;
  $("#headerButton").click(function() {
    $("#headerwrap").slideToggle();
    if (openHeader) {
      $("#headerButton").animate({
        top: 0
      }, 400, function() {
        $(this).text("Open");
      });
      openHeader = false;
    } else {
      $(this).animate({
        top: headerHeight
      }, 400, function() {
        $(this).text("Close");
      });
      openHeader = true;
    }
  });
}

/**
 * slide sidebar in/out
 */

function sliderSidebar() {
  // figure out width of sidebar for positioning when hidden/shown
  var sideWidth = $("#sidebar").width();

  // add open/hide button
  $("#sidebar").append("<div id=\"side-button\" class=\"slideButton right\"></div>");

  // sidebar is opened at first
  var openSide = true;
  $("#sidebar").addClass("opened");

  // main sliding function
  $("#side-button").click(function() {
    sideWidth = $("#sidebar").width(); // in case sidebar has been resized
    if (openSide) {
      $("#sidebar").animate({
        left: -sideWidth
      }, 400, function() {
        $(this).removeClass("opened").addClass("closed");
      });

      $(this).animate({
        left: sideWidth
      }, 400);

      openSide = false;

    } else {
      $("#sidebar").removeClass("closed").addClass("opened").animate({
        left: 0
      }, 400);

      $(this).animate({
        left: sideWidth
      }, 400);

      openSide = true;
    }
  });
}

/**
 * Scroll to element
 * Based on https://stackoverflow.com/a/6677069
 *
 * @param {String} el Selector of element which we scroll to
 * @param {Integer} [duration=1000] Duration, in milliseconds, of the animation
 */
function scrollTo(el, duration) {
  duration = duration || 1000;

  $('html, body').animate({
    scrollTop: $(el).offset().top
  }, duration);
}

/**
 * Themizer init
 */
function themizer() {
  /*************
   * VARIABLES *
   *************/
  // get viewport height
  var vh = $(window).height()/100;

  // find width of sidebar and of sideButton
  var sideWidth       = 35*vh,
      sideButtonWidth =  2*vh;

  // set whether user is active or not for later
  var idleTimer = null,
      idleState = true;

  /*************
   * FUNCTIONS *
   *************/
  // Set sidebar styles
  $("#sidebar")      .css("font-size", 2.22*vh);
  $("#sidebar-inner").width(sideWidth);
  $("#side-button").css("left", sideWidth);

  $("#blog-body").load("blog/blog-index.html");
  $("head").append("<link href='blog/css/core.css' type='text/css' rel='stylesheet' id='base-theme'>");

  // option slides sliding init
  $(".option").each(function() {
    var id = $(this).attr('id');
    $("#" + id + " .option-title").attr("onclick", "optionToggle('" + id + "')");
    optionToggle(id);
  });

  // set first option to be open
  var firstop = $(".option:first-of-type").attr('id');
  $("#" + firstop + " .option-title").removeClass("collapsed").addClass("expanded");
  $("#" + firstop + " .option-wrap").slideDown(0);

  // view mode radios
  $("[name='view']").change(function() {
    $("#blog-body").load("blog/blog-" + $("[name='view'] :checked").val() + ".html");
  });
  $("[name='base']").change(function() {
    $("link[id='base-theme']").attr('href', "blog/css/" + $("[name='base'] :checked").val() + ".css");
  });

  // resize sidebar
  // modified from https://stackoverflow.com/a/4139860
  $("#side-resizer").mousedown(function() {
    $(document).mousemove(function(event) { // use document to avoid conflict with sideButton
      var mousePosX = event.pageX;
      sideWidth = mousePosX > 35*vh ? mousePosX : sideWidth; // set original width as minimum
      $("#sidebar-inner").width(sideWidth);
      // move sideButton and remove transitions as they screw the former up
      $("#side-button").css({
        "left": sideWidth,
        "transition": "0s linear"
      });
    });
  });
  $(document).bind("mouseup click", function() {
    $(document).unbind("mousemove");
    // readd transitions
    $("#side-button").css({
      "transition": ""
    });
  });

  // Show/hide sideButton
  // modify sideButton on click
  $("#side-button").click(function() {
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
  $(window).bind('mousemove scroll', function(event) {
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
    idleTimer = setTimeout(function() {
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

  /**
   * Styling
   */

  // General

  /**
   * Style elements targeted by Themizer
   *
   * @param {Boolean} [useName] Use name to refer to selector
   * @param {String}  [value]   Value to assign to CSS property
   */
  $.fn.style = function(useName, value) {
    var // Get selector of corresponding field
        id       = useName ? "[name='" + this.attr("name") + "']" : "#" + this.attr("id"),
        // Create a temp variable from which we decompose the selector and property
        cssId    = useName ? this.attr("name") : this.attr("id"),
        // Split cssId into array so we can decompose it
        cssArray = cssId.split("-"),
        // Get selector for elements
        el       = cssArray[0].replace(/([a-z])(?=[A-Z])/, "$1-").toLowerCase().replace("class_", ".").replace("id_", "#"),
        // Get CSS property
        prop     = cssArray[1].replace(/([a-z])([A-Z])/, "$1-$2").toLowerCase(),
        // Value of `this`
        thisVal;

    this.change(function() {
      thisVal = !useName ? value || this.value : null; // this.val() throws error

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
            $(el).css("background-image", "url(" + thisVal + ")");
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
      }
    });
  };

  // Check inputs for validity
  $("[type='url']").keyup(function() {
    $(this).val().match(/^https?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/([^\s<>%"\,\{\}\\|\\\^\[\]`]+)?\.(gif|jpg|jpeg|png|php|svg)$/) ? $(this).removeClass("invalid") : $(this).addClass("invalid");
  });

  // Body
  $("#body-backgroundImage").style();
  $("[name='body-backgroundRepeat']").style(1);
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
    move: function(color) {
            // this is as the IDs follow the pattern
            // spectrum-<selector>-<CSSProperty (camelCased)>
            // Hence, we can deconstruct the id to produce our desired selectors.
            var id   = $(this).attr("id").split(/-/),
                el   = id[1],
                prop = id[2].replace(/([a-z])([A-Z])/, "$1-$2").toLowerCase();
            $(this).prev().val(color);
            $(el).css(prop, color);
          }
  });
  // Set color picker to corresponding text input's value when user types
  $(".spectrum.text").keyup(function() {
    var color  = $(this).val(),
        picker = $(this).next(),
        id     = $(this).attr("id").split(/-/),
        el     = id[1],
        prop   = id[2].replace(/([a-z])([A-Z])/, "$1-$2").toLowerCase();
    $(el).css(prop, color);
    $(picker.spectrum("set", color));
  });
  // Reposition picker when user scrolls sidebar
  $("#sidebar-inner").bind("scroll", function() {
    $(".spectrum.color-picker").spectrum("reflow");
  });

  $(window).mousemove();
}

/**
 * Toggle options
 */
function optionToggle(id) {
  $("#" + id + " .option-wrap").slideToggle();
  var content = $("#" + id + " .option-title");

  if (content.hasClass("collapsed")) {
    content.removeClass("collapsed").addClass("expanded");
  } else {
    content.removeClass("expanded").addClass("collapsed");
  }
}

/**
 * Generate random colour
 *
 * May or may not use http://llllll.li/randomColor/ in the future
 */

var randomColour = function() { return '#'+Math.floor(Math.random()*16777215).toString(16); };

/*laquo «
&#187; and it will looks like »*/
