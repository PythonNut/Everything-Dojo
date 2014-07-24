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

  // edit id of the wrapping #content to avoid conflict with #content in blog HTML
  $("#content:first-of-type").attr("id", "themizer-content");

  $("#blog-body").load("blog-index.html");

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
    $("#blog-body").load("blog-" + $("[name='view'] :checked").val() + ".html");
  });
  $("[name='base']").change(function() {
    $("head").append("<link href='blog-" + $("[name='base'] :checked").val() + ".css' type='text/css' rel='stylesheet'>");
  });

  // resize sidebar
  // modified from https://stackoverflow.com/a/4139860
  $("#side-resizer").mousedown(function() {
    $(document).mousemove(function(event) { // use document as window is reserved for sideButton when triggered
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
   * Themizer body
   */
  $("#body-backgroundImage").change(function() {
    $("body").css("background-image", "url('" + $(this).val() + "')");
  });
  $("[name='body-backgroundRepeat']").change(function() {
    $("body").css("background-repeat", $("[name='body-backgroundRepeat']:checked").val());
  })
  // Spectrum
  $(".spectrum").spectrum({
    preferredFormat: "name",
    showAlpha: true,
    showInitial: true,
    clickoutFiresChange: true,
    showButtons: false,
    move: function(color) {
            $("[data-id='" + $(this).attr("id") + "']").val(color);
            $($(this).data("el")).css($(this).data("prop"), color.toString());
          }
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
