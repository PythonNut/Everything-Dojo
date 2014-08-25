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

$(".search").on("propertychange keyup input paste", function () {
  $(".style").each(function () {
    var mainText = $(this).children().first().text().toLowerCase();
    var author = $(this).children().first().next().text().toLowerCase();
    var version = $(this).children().last().prev().text().toLowerCase();
    var stage = $(this).children().last().text().toLowerCase();

    var query = $(".search").val().toLowerCase();

    if (! (containsAny(query, mainText))) {
      $(this).css("display", "none");
    }
    else {
      $(this).removeAttr("style");
    }
  });
});
