//js/jQ functions that are available to run on any page. requires jQuery.

//makes the header an absolutely positioned element
//with a slide in/out button for pages which can't 
//have elements affecting viewport size (themizer, try-it)
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

function sliderSidebar() {
  var color = $("#sidebar").css("background-color");
  var sideWidth = $("#sidebar").width();
  $("#sidebar").append("<div id=\"sideButton\" class=\"slideButton right\" style=\"background: " + color + "\">Close</div>");
  var openSide = true;
  $("#sideButton").click(function() {
    $("#sidebar-inner").animate({width: 'toggle'}, 400);
    if (openSide) {
      $("#sideButton").animate({
        left: 0
      }, 400, function() {
        $(this).text("Open");
      });
      openSide = false;
    } else {
      $(this).animate({
        left: sideWidth
      }, 400, function() {
        $(this).text("Close");
      });
      openSide = true;
    }
  });
}

function themizer() {
  //init
  //unload style.css. Too much messing up stuff.
  $("link[href='css/style.css']").remove();
  //remove the header :D
  $("header").remove();
  //set index to be default mode
  $("input[name='view'][value='index']").prop("checked", "checked");
  $("#blog-body").load("blog-index.html");
  //option slides sliding init
  $(".option").each(function() {
    var id = $(this).attr('id');
    $("#" + id + " .option-title").attr("onclick", "optionToggle('" + id + "')");
    optionToggle(id);
  });
  var firstop = $(".option:first-of-type").attr('id');
  $("#" + firstop + " .option-title").removeClass("collapsed").addClass("expanded");
  $("#" + firstop + " .option-wrap").slideDown(0);
   
  //view mode radios
  $("input[name='view']").change(function() {
    $("#blog-body").load("blog-" + $("input[name='view']:checked").val() + ".html");
  });
}

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

//originally written by levans as a hide tag mod
function post_hide(self) {
  var e = $(self);
  var d = e.next();
  d.toggle();
}

//toggle_month for archives
//from the blog software
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
