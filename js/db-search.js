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

$(document).ready(function () {
  var search = $(".search");

  search.on("propertychange keyup input paste", function () {
    $(".style").each(function () {
      var mainText = $(this).children().first().text().toLowerCase();

      var query = search.val().toLowerCase().trim(); // Leading and trailing whitespace makes all themes visible, so remove it

      // FIXME filters are super buggy, save them for the next update.
      /*
      var stage = $(this).children().last().text().toLowerCase();
      var author = $(this).children().first().next().text().toLowerCase();
      var authorRegex = /(^|[^\\])@[a-zA-Z0-9_]+(\b|$)/ig;
      var releaseRegex = /(^|[^\\])#\[?(release|beta|alpha|dev)\]?(\b|$)/ig;
      var requiredRegex = /(^|[^\\])\+\S+(?=(\s|$))/ig;
      var forbiddenRegex = /(^|[^\\])-\S+(?=(\s|$))/ig;

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

      // Required word filter
      var requireds = query.match(requiredRegex);
      
      var requiredMatch = true;

      if (requireds !== null) {
        requireds.every(function (r) {
          r = r.slice(2);

          if (! contains(r, mainText)) {
            requiredMatch = false;
          }

          return requiredMatch; // requiredMatch is false if a required word has not been found, and Array.prototype.every() stops if the callback returns false
        });
      }

      // Forbidden word filter
      var forbiddens = query.match(forbiddenRegex);
      
      var forbiddenMatch = true;

      if (forbiddens !== null) {
        forbiddens.every(function (f) {
          f = f.slice(2);

          if (contains(f, mainText)) {
            forbiddenMatch = false;
          }

          return forbiddenMatch; // forbiddenMatch is false if a forbidden word has been found, and Array.prototype.every() stops if the callback returns false
        });
      }*/


      if (! (containsAny(query, mainText) /*&& authorMatch && releaseMatch && requiredMatch && forbiddenMatch*/)) {
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
