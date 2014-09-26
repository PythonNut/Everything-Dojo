function contains(str, substr) {
  return str.indexOf(substr) > 1;
}

$(".search").keypress(function () {
  $(".database-table").find("tr").children().each(function () {
    if (! (contains($(this).text(), $(".search").text()) || contains($(this).children("b").text(), $(".search").text()))) {
      $(this).css("display", "none");
    }
  });
});