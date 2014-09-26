function popUp(anchor) {
  var w = document.getElementById(anchor);
  w.style.display = "block";
  var main = document.getElementById("wrap");
  main.style.opacity = 0.05;
  main.onclick = function() {
    w.style.display = "none";
    main.style.opacity = 1;
  };
}