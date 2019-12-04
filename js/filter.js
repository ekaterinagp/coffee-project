var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}

function getAllProductsAsJson() {
  let endpoint = "api/api-get-products.php";
  fetch(endpoint)
    .then(res => res.json())
    .then(response => {
      console.log(response);
    });
}
