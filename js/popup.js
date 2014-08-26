function popUp(id) {
  var w = document.getElementById(id);
  w.style.top = "1%";
  var main = document.getElementById("wrap");
  main.style.opacity = 0.05;
  
  //Exit popup
  main.onclick = function() {
    w.style.top = "200%";
    main.style.opacity = 1;
  };
}
