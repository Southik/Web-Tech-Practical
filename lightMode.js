document.getElementById("mode-toggle").addEventListener("click", function () {
  document.body.classList.toggle("light-mode");

  if (document.body.classList.contains("light-mode")) {
      localStorage.setItem("mode", "light");
  } else {
      localStorage.setItem("mode", "dark");
  }
});

if (localStorage.getItem("mode") === "light") {
    document.body.classList.add("light-mode");
}
