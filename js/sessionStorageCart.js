"use strict";

let addToCartBtn = document.querySelector("#addToCartBtn");
let cartItem = document.querySelector("#cartItem");
// let numberOfItem = document.querySelector(".numberOfItems");
// checkCart();

function createCartItem() {
  let cartItem = {
    id: 0,
    img: "",
    name: "",
    price: 0,
    amount: 0,
    typeGrind: ""
  };
  return cartItem;
}

let currentCartItem = {};

function getCartItem() {
  let cartItem = createCartItem();
  let urlParams = new URLSearchParams(window.location.search);
  let itemId = urlParams.get("id");
  cartItem.id = itemId;
  let itemName = document.querySelector(".productName").innerHTML;
  cartItem.name = itemName;
  let price = document.querySelector(".productPrice").innerHTML;
  cartItem.price = price;
  let imgPath = changeFormatForName(itemName);
  let img = "img/products/" + imgPath;
  cartItem.img = img;
  let checkedValue = document.querySelector(".mb-small:checked").value;
  cartItem.typeGrind = checkedValue;
  let amountSelected = document.querySelector('input[name="option1"]').value;
  cartItem.amount = amountSelected;
  console.log(cartItem);
  currentCartItem = cartItem;
}

function changeFormatForName(str) {
  return (
    str
      .split(" ")
      .join("-")
      .toLowerCase() + ".png"
  );
}

// function checkCart() {
//   let cart = JSON.parse(sessionStorage.getItem("cart"));

//   if (cart && cart.length > 0) {
//     numberOfItem.innerHTML = cart.length;
//     numberOfItem.setAttribute("style", "display:block;");
//   } else {
//     numberOfItem.setAttribute("style", "display: none;");
//   }
// }

addToCartBtn.addEventListener("click", () => {
  getCartItem();
  let cart = JSON.parse(sessionStorage.getItem("cart"));

  if (cart) {
    //adds one or more elements to the array cart
    cart.push(currentCartItem);
    sessionStorage.setItem("cart", JSON.stringify(cart));
  } else {
    cart = [];
    cart.push(currentCartItem);
    sessionStorage.setItem("cart", JSON.stringify(cart));
  }

  checkCart();
});
