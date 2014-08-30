function contains(needle, haystack) {
  return haystack.indexOf(needle) > -1;
}

function containsAny(needle, haystack) {
  var words = needle.split(" ");

  for (var i = 0; i < words.length; i ++) {
    if (contains(words[i], haystack)) {
      return true;
    }
  }

  return false;
}

// Override the default string trimming methods to be more useful
String.prototype.trimLeft = function(charlist) {
  if (charlist === undefined) {
    charlist = "\\s";
  }

  return this.replace(new RegExp("^[" + charlist + "]+"), "");
};

String.prototype.trimLeft = function(charlist) {
  if (charlist === undefined) {
    charlist = "\\s";
  }

  return this.replace(new RegExp("[" + charlist + "]+$"), "");
};

String.prototype.trim = function(charlist) {
  return this.trimLeft(charlist).trimRight(charlist);
};

$(document).ready(function () {
  $(".search").on("propertychange keyup input paste", function () {
    $(".style").each(function () {
      var mainText = $(this).children().first().text().toLowerCase();
      var stage = $(this).children().last().text().toLowerCase();

      var query = $(".search").val().toLowerCase();

      var author = $(this).children().first().next().text().toLowerCase();
      var qAuthor = query.match(/@[a-zA-Z0-9_]*/i);

      $(this).children().first().unhighlight({"element": "mark"}); // Unhighlight any leftover matches from last time around as they mess up the highlighting method
      $(this).children().first().highlight(query.split(" "), {"element": "mark"}); // Highlight matches

      if (qAuthor !== null) {
        qAuthor = qAuthor[0].trimLeft("@"); // JS doesn't have lookbehind so the @ needs to be trimmed.
      }

      else {
        qAuthor = "";
      }

      if (! (containsAny(query, mainText) && contains(qAuthor, author))) {
        $(this).fadeOut();
      }

      else {
        $(this).fadeIn();
      }
    });
  });

  $(".search").keypress(function (key) {
    if (key.which == 13) {
      $(this).blur();
    }
  });

  $(".search-box .icon-box").click(function () {
    $(".search").blur();
  });
});
