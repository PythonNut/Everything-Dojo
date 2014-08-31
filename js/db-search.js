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
  var search = $(".search");

  search.on("propertychange keyup input paste", function () {
    $(".style").each(function () {
      var mainText = $(this).children().first().text().toLowerCase();
      var stage = $(this).children().last().text().toLowerCase();
      var author = $(this).children().first().next().text().toLowerCase();

      var query = search.val().toLowerCase();

      var authorRegex = /[^\\]@[a-zA-Z0-9_]+\b/ig;
      var releaseRegex = /[^\\]#\[?(release|beta|alpha|dev)\]?\b/ig;
      var requiredRegex = /[^\\]\+\w+(?=\s)/ig;
      var forbiddenRegex = /[^\\]-\w+(?=\s)/ig;

      // Author filter
      var authors = query.match(authorRegex);
      
      var authorMatch = false;

      if (authors !== null) {
        authors.some(function (a) {
          a = a.slice(2);

          if (contains(a, author)) {
            authorMatch = true;
            return false;
          }

          return authorMatch; // authorMatch is true if a match has been found, and Array.prototype.some() stops if the callback returns true
        });
      }

      else {
        authorMatch = true;
      }

      // Release stage filter
      var releases = query.match(releaseRegex);
      
      var releaseMatch = false;

      if (releases !== null) {
        releases.some(function (r) {
          r = r.slice(2);

          if (contains(r, stage)) {
            releaseMatch = true;
            return false;
          }

          return releaseMatch; // releaseMatch is true if a match has been found, and Array.prototype.some() stops if the callback returns true
        });
      }

      else {
        releaseMatch = true;
      }


      if (! (containsAny(query, mainText) && authorMatch && releaseMatch)) {
        $(this).fadeOut();
      }

      else {
        $(this).fadeIn();
      }

      $(this).children().first().unhighlight({"element": "mark"}); // Unhighlight any leftover matches from last time around as they mess up the highlighting method
      $(this).children().first().highlight(query.split(" "), {"element": "mark"}); // Highlight matches
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
