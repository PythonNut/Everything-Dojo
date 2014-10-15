/* globals sliderSidebar:false, Prism:false, ZeroClipboard:false */
/*******************
 *   THEMIZER JS   *
 *******************/

/*
 * Variables
 */

// Specify base theme
var baseTheme = "core";

// Set object for styling
var styles = {
  "body-backgroundColor"              : "white",
  "body-backgroundImage"              : "",
  "body-backgroundRepeat"             : "",
  "body-fontFamily"                   : "",
  "id_header-backgroundColor"         : "#EDEDEA",
  "id_wrapper-backgroundColor"        : "#EDEDEA",
  "class_entry-backgroundColor"       : "#EDEDEA",
  "class_entrywrap-backgroundColor"   : "#EDEDEA",
  "class_comment-backgroundColor"     : "#EDEDEA",
  "class_commentwrap-backgroundColor" : "#EDEDEA",
  "id_headerspaceh1-color"              : "#000000",
  "class_row1-backgroundColor"        : "#EDEDEA",
  "class_row2-backgroundColor"        : "#EDEDEA"
};

/*
 * jQuery plugins
 */

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

/**
 * Themizer (Regular mode) Init
 */
function themizerRegular () {
  sliderSidebar();
  // Base style
  $("head").append("<link href='blog/css/core.css' rel='stylesheet' id='base-theme'>");

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
          selector = split[0].replace(/([a-z])(?=[A-Z])/, "$1-").toLowerCase().replace("space", " ").replace("class_", ".").replace("id_", "#"),
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
          thiselement += "  " + k + ": " + selectors[j][k] + ";\n";
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
    $("#copycode.hover").text("Copy Code to Clipboard").removeClass("hover");
    Prism.highlightElement(document.getElementById("generatedcode-shown"));
    $("#lightbox").show();

  });

  /**
   * Styling
   */

  // Set baseTheme whenever base option is changed
  $("[name='base']").change(function () {
    $("link[id='base-theme']").attr('href', "blog/css/" + $("[name='base'] :checked").val() + ".css", function () {
      $(".text").trigger("keyup");
    });
    baseTheme = $("[name='base'] :checked").val();
  });

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
                el   = id[1].replace(/([a-z])(?=[A-Z])/, "$1-").toLowerCase().replace("space", " ").replace("class_", ".").replace("id_", "#"),
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
        el     = id[1].replace(/([a-z])(?=[A-Z])/, "$1-").toLowerCase().replace("space", " ").replace("class_", ".").replace("id_", "#"),
        prop   = id[2].replace(/([a-z])([A-Z])/, "$1-$2").toLowerCase();
        console.log(el);
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
 * Themizer (Developer mode) Init
 */
function themizerDev () {
  sliderSidebar();
  $("head").append('<style id="dev-style"></style>');

  // make sidebar-inner full height
  // $("#sidebar-inner").css("padding-bottom", "0");

  /**
   * ZeroClipboard
   */
  var client = new ZeroClipboard($("#copycode"));

  client.on("ready", function (readyEvent) {
    client.on("aftercopy", function (event) {
      event.target.innerHTML= "Copied";
      event.target.classList.add("hover");
      setTimeout(function () { //after a while, go back to non-copied state
        event.target.innerHTML= "Copy Code to Clipboard";
        event.target.classList.remove("hover");
      }, 1100);
    });
  });

  $(window).mousemove();
}
