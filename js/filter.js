"use strict";
window.addEventListener("load", init);

// VARIABLES WITH DOM ELEMENTS


const acc = document.getElementsByClassName("accordion");

const txtSearch = document.querySelector('#txtSearch');
const theResults = document.querySelector('#results');

//// Price checkboxes
let checkFirstOption = document.querySelector(".filter-price [name=option1]");
let checkSecondOption = document.querySelector(".filter-price [name=option2]");
let checkThirdOption = document.querySelector(".filter-price [name=option3]");

//// Coffee type checkboxes
let checkFirstCoffeeOption = document.querySelector('.filter-origin [name=option1]');
let checkSecondCoffeeOption = document.querySelector('.filter-origin [name=option2]');
let checkThirdCoffeeOption = document.querySelector('.filter-origin [name=option3]');
let checkFourthCoffeeOption = document.querySelector('.filter-origin [name=option4]');
let checkFifthCoffeeOption = document.querySelector('.filter-origin [name=option5]');
let checkSixthCoffeeOption = document.querySelector('.filter-origin [name=option6]');

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

function changeFormatForImg(product) {
  let str = product.cName;
  product.cName = str.replace(/\s+/g, "-").toLowerCase();
}

// ACCORDION FUNCTION
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

// PRODUCTS FUNCTION
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

// FILTERING CONDITIONS
//// Prices
function ifPriceSmaller50(product) {
  return product.nPrice <= 50;
}
function ifPriceMore50Less100(product) {
  return product.nPrice > 50 && product.nPrice < 100;
}
function ifPriceMore100(product) {
  return product.nPrice > 100;
}

//// Coffee types
function iCoffeeTypeColombia(product){
  return product.nCoffeeTypeID == 1;
}
function iCoffeeTypeEthiopia(product){
  return product.nCoffeeTypeID == 2;
}
function iCoffeeTypeSumatra(product){
  return product.nCoffeeTypeID == 3;
}
function iCoffeeTypeBrazil(product){
  return product.nCoffeeTypeID == 4;
}
function iCoffeeTypeNicaragua(product){
  return product.nCoffeeTypeID == 5;
}
function iCoffeeTypeBlend(product){
  return product.nCoffeeTypeID == 6;
}

// FILTERING FUNCTION
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
    clone.querySelector("h4").textContent =
      "Origin:" + " " + product.nCoffeeTypeID;
    clone.querySelector("p").textContent = product.nPrice;
    document.querySelector(".products-container").appendChild(clone);
  });
}

// INITIALIZING OF SEARCH FUNCTION ON INPUT
txtSearch.addEventListener('input', function(){
  fetchDataForSearch();

  if(txtSearch.value.length == 0){
      theResults.style.display = 'none';
  } else{
      theResults.style.display = 'block';
  }
});

// SEARCH FUNCTION
function fetchDataForSearch(){
  fetch('api/api-search.php?search=' + txtSearch.value
  )
  .then(function(response){
    return response.json();
  })
  .then(function(arrayMatches){
    console.log({arrayMatches});

  theResults.textContent = '';

  arrayMatches.forEach(function(match){
      let a = document.createElement("a");
      a.href = 'singleProduct.php?id=' + match.nProductID;
      a.textContent = match.cName;
      let span = document.createElement('br');
      theResults.append(a, span);
  });
});
}

// INIT FUNCTION FILTERING COFFEE'S BY TYPE AND PRICE
async function init() {
  const allProductsArray = await getAllProductsAsJson();

  let smaller50 = allProductsArray.filter(ifPriceSmaller50);
  let moreThan50 = allProductsArray.filter(ifPriceMore50Less100);
  let moreThan100 = allProductsArray.filter(ifPriceMore100);

  let coffeeTypeColombia = allProductsArray.filter(iCoffeeTypeColombia);
  let coffeeTypeEthiopia = allProductsArray.filter(iCoffeeTypeEthiopia);
  let coffeeTypeSumatra = allProductsArray.filter(iCoffeeTypeSumatra);
  let coffeeTypeBrazil = allProductsArray.filter(iCoffeeTypeBrazil);
  let coffeeTypeNicaragua = allProductsArray.filter(iCoffeeTypeNicaragua);
  let coffeeTypeBlend = allProductsArray.filter(iCoffeeTypeBlend);

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


