function contains(str, substr) {
  return str.indexOf(substr) > 1;
}

function containsAny(str, substr) {
  for (var i = substr.split().length - 1; i >= 0; i--) {
    if (contains(str, substr.split()[i])) {
      return true;
    }
  }

  return false;
}

$(".search").keypress(function () {
  $(".database-table").find("tr").children().each(function () {
    if (! (containsAny($(this).text(), $(".search").text()) || containsAny($(this).children("b").text(), $(".search").text()))) {
      $(this).css("display", "none");
    }
  });
});