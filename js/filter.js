"use strict";
window.addEventListener("load", init);

const acc = document.getElementsByClassName("accordion");

for (let i = 0; i < acc.length; i++) {
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

function ifPriceSmaller50(product) {
  return product.nPrice <= 50;
}

function ifPriceMore50Less100(product) {
  return product.nPrice > 50 && product.nPrice < 100;
}

function ifPriceMore100(product) {
  return product.nPrice > 100;
}

let checkFirstOption = document.querySelector("[name=option1]");
let checkSecondOption = document.querySelector("[name=option2]");
let checkThirdOption = document.querySelector("[name=option3]");

function showFilteredCoffee(products) {
  let template = document.querySelector("template").content;
  products.forEach(product => {
    let clone = template.cloneNode(true);
    clone.querySelector("a").href =
      "singleProduct.php?id=" + product.nProductID;
    clone.querySelector("h3").textContent = product.cName;
    changeFormatForImg(product);
    clone.querySelector(".mb-medium").id = "product-" + product.nProductID;
    clone.querySelector(".image").style.backgroundImage =
      "url(img/products/" + product.cName + ".png)";
    checkCoffeeType(product);
    clone.querySelector("h4").textContent = product.nCoffeeTypeID;
    clone.querySelector("p").textContent = product.nPrice;
    document.querySelector(".products-container").appendChild(clone);
  });
}

function changeFormatForImg(product) {
  let str = product.cName;
  product.cName = str.replace(/\s+/g, "-").toLowerCase();
}

async function init() {
  const allProductsArray = await getAllProductsAsJson();
  console.log(allProductsArray);

  // console.log(smaller50);

  // showFilteredCoffee(products);
  let smaller50 = allProductsArray.filter(ifPriceSmaller50);
  let moreThan50 = allProductsArray.filter(ifPriceMore50Less100);
  let moreThan100 = allProductsArray.filter(ifPriceMore100);

  // checkFirstOption.addEventListener("change", () => {

  // });
  // checkSecondOption.addEventListener("change", () => {});

  // checkThirdOption.addEventListener("change", () => {
  //   if (checkThirdOption.checked) {
  //     console.log("optionSecond Checked");
  //     document.querySelector(".products-container").innerHTML = "";

  //     showFilteredCoffee(moreThan100);
  //   }
  // });

  document.querySelectorAll("input").forEach(input => {
    input.addEventListener("change", () => {
      if (checkThirdOption.checked) {
        console.log("optionSecond Checked");
        document.querySelector(".products-container").innerHTML = "";

        showFilteredCoffee(moreThan100);
      }
      if (checkSecondOption.checked) {
        console.log("optionSecond Checked");
        document.querySelector(".products-container").innerHTML = "";

        showFilteredCoffee(moreThan50);
      }
      if (checkFirstOption.checked) {
        console.log("optionFirst Checked");
        document.querySelector(".products-container").innerHTML = "";

        showFilteredCoffee(smaller50);
      }
      if (checkFirstOption.checked && checkSecondOption.checked) {
        document.querySelector(".products-container").innerHTML = "";
        showFilteredCoffee(moreThan50);
        showFilteredCoffee(smaller50);
      }
      if (
        checkFirstOption.checked &&
        checkSecondOption.checked &&
        checkThirdOption.checked
      ) {
        document.querySelector(".products-container").innerHTML = "";
        showFilteredCoffee(moreThan50);
        showFilteredCoffee(smaller50);
        showFilteredCoffee(moreThan100);
      }
      if (checkSecondOption.checked && checkThirdOption.checked) {
        document.querySelector(".products-container").innerHTML = "";
        showFilteredCoffee(moreThan50);
        showFilteredCoffee(moreThan100);
      }
      if (checkFirstOption.checked && checkThirdOption.checked) {
        document.querySelector(".products-container").innerHTML = "";

        showFilteredCoffee(smaller50);
        showFilteredCoffee(moreThan100);
      }
      if (
        !checkFirstOption.checked &&
        !checkThirdOption.checked &&
        !checkSecondOption.checked
      ) {
        document.querySelector(".products-container").innerHTML = "";

        showFilteredCoffee(allProductsArray);
      }
    });
  });
}

function checkCoffeeType(product) {
  if (product.nCoffeeTypeID == 1) {
    product.nCoffeeTypeID = "Colombia";
  }
  if (product.nCoffeeTypeID == 2) {
    product.nCoffeeTypeID = "Ethiopia";
  }
  if (product.nCoffeeTypeID == 3) {
    product.nCoffeeTypeID = "Sumatra";
  }
  if (product.nCoffeeTypeID == 4) {
    product.nCoffeeTypeID = "Brazil";
  }
  if (product.nCoffeeTypeID == 5) {
    product.nCoffeeTypeID = "Nicaragua";
  }
  if (product.nCoffeeTypeID == 6) {
    product.nCoffeeTypeID = "Blend";
  }
}
