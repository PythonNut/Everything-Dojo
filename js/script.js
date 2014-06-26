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
  $("#sidebar").append("<div id=\"sideButton\" class=\"slideButton right\"></div>");

  // sidebar is opened at first
  var openSide = true;
  $("#sidebar").addClass("opened");

  // main sliding function
  $("#sideButton").click(function() {
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

function themizer() {
  // init
  // unload style.css. Too much messing up stuff.
  $("link[href='css/style.css']").remove();

  // remove the header :D
  $("header").remove();

  // edit id of the wrapping #content to avoid conflict with #content in blog HTML
  $("#content:first-of-type").attr("id", "themizer-content");

  // set index to be default mode
  $("input[name='view'][value='index']").prop("checked", "checked");
  $("input[name='base'][value='original']").prop("checked", "checked");
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
    $("#blog-body").load("blog-" + $("[name='view']:checked").val() + ".html");
  });
  $("[name='base']").change(function() {
    $("head").append("<link href='blog-" + $("[name='base']:checked").val() + ".css' type='text/css' rel='stylesheet'>");
  });

  // Show/hide sideButton
  // find width of sidebar and of sideButton
  var sideWidth = $("#sidebar").width();
  var sideButtonWidth = $("#sideButton").width();
  // set whether user is active or not for later
  var idleTimer = null;
  var idleState = true;

  // modify sideButton on click
  $("#sideButton").click(function() {
    if ($("#sidebar").css("left") == "0px" && $("#sidebar").hasClass("opened")) { // fires when sidebar is to be closed
      $("#sideButton").addClass("triggered");
      idleState = true; // since user is active
    } else {
      $("#sideButton").removeClass("targeted");
    }
  });

  // show sideButton on mousemove + scroll
  // taken and modified from http://css-tricks.com/snippets/jquery/fire-event-when-user-is-idle/
  $(window).bind('mousemove scroll', function(event) {
    clearTimeout(idleTimer); // clear timeout if user acts

    // user active
    if (idleState == true) {
      // Reactivated event
      $(".closed #sideButton").addClass("triggered").animate({
        left: sideWidth
      }, 100);
    }

    // user mouse in "targeted" zone
    // We cannot use jQuery animations as they are too CPU-intensive
    // Instead, we just add .targeted.
    if (event.pageX < sideWidth*2/3) {
      $(".closed #sideButton").addClass("targeted");
    } else {
      $(".closed #sideButton").removeClass("targeted");
    }

    idleState = false;

    // user inactive
    idleTimer = setTimeout(function() {
      // Idle Event
      // cursor outside target zone
      $("#sideButton").removeClass("triggered");
      $(".closed #sideButton:not(:hover):not(.targeted)").animate({
        left: sideWidth - sideButtonWidth
      }, 1500);
      // cursor inside target zone
      $(".closed #sideButton.targeted:not(:hover)").animate({
        left: sideWidth - 2*sideButtonWidth
      }, 3000, function() {
        $("#sideButton").removeClass("targeted");
      });
      idleState = true;
    }, 4000);
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
