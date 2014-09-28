/* globals sliderSidebar:false, Prism:false, ZeroClipboard:false */
/*******************
 *   THEMIZER JS   *
 *******************/
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

/**
 * Themizer (Regular mode) Init
 */
function themizerRegular () {
  sliderSidebar();
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

