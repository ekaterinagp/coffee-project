"use strict";
window.addEventListener("load", init);

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
  return new Promise((resolve, reject) => {
    fetch(endpoint)
      .then(res => res.json())
      .then(function(products) {
        resolve(products);
      });
  });
}

// function filterPrice(allProductsArray){

// }

function ifPriceSmaller50(product) {
  if (product.nPrice <= 50) {
    return product;
  }
}

function ifPriceMore50(product) {
  if (product.nPrice > 50 && product.nPrice < 100) {
    return product;
  }
}

async function init() {
  const allProductsArray = await getAllProductsAsJson();
  console.log(allProductsArray);
  let smaller50 = allProductsArray.filter(ifPriceSmaller50);
  console.log(smaller50);
  let moreThan50 = allProductsArray.filter(ifPriceMore50);
  console.log(moreThan50);
}
