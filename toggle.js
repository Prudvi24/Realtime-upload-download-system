function myFunction() {
  var x = document.getElementById("table1");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

myFunction();