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
  $("input[name='view']").change(function() {
    $("#blog-body").load("blog-" + $("input[name='view']:checked").val() + ".html");
  });

  // Show/hide sideButton
  // find width of sidebar and of sideButton
  var sideWidth = $("#sidebar").width();
  var sideButtonWidth = $("#sideButton").width();

  // modify sideButton on click
  $("#sideButton").click(function() {
    if ($("#sidebar").css("left") == "0px" && $("#sidebar").hasClass("opened")) { // fires when sidebar is to be closed
      $("#sideButton").addClass("triggered");

      // timeout to remove triggered class and to hide sideButton
      setTimeout(function() {
        $("#sideButton").removeClass("triggered");
        $(".closed #sideButton").animate({
          left: sideWidth - sideButtonWidth
        }, 1500);
      }, 4000);
    }
  });

  // show sideButton on hover + scroll
  // taken and modified from http://css-tricks.com/snippets/jquery/fire-event-when-user-is-idle/
  var idleTimer = null;
  var idleState = false;

  $(window).bind('mousemove scroll', function() {
      clearTimeout(idleTimer); // clear timeout if user acts

      // user active
      if (idleState == true) {
        // Reactivated event
        $(".closed #sideButton").addClass("triggered").animate({
          left: sideWidth
        }, 100);
      }

      idleState = false;

      // user inactive
      idleTimer = setTimeout(function() {
      // Idle Event
        $("#sideButton").removeClass("triggered");
        $(".closed #sideButton").animate({
          left: sideWidth - sideButtonWidth
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

    if (content.hasClass("collapsed"))
      content.removeClass("collapsed").addClass("expanded");
    else
      content.removeClass("expanded").addClass("collapsed");
}

/*laquo «
&#187;) and it will looks like »*/

// originally written by levans as a hide tag mod
function post_hide(self) {
  var label = $(self);
  var hide = label.next();
  hide.toggle();
}

// toggle_month for archives
// from the blog software
function toggle_month(month) {
  thisMonth = document.getElementById('month_' + month);
  thisImg = document.getElementById('month_image_' + month);

  if (thisMonth && thisImg) {
    if (thisMonth.style.display == "none") {
      thisMonth.style.display = "block";
      thisImg.src = "http://www.artofproblemsolving.com/Forum/blog/styles/hyperion/images/minus.gif";
      thisImg.alt = '-';
    } else {
      thisMonth.style.display = "none";
      thisImg.src = "http://www.artofproblemsolving.com/Forum/blog/styles/hyperion/images/plus.gif";
      thisImg.alt = '+';
    }
  }
}
