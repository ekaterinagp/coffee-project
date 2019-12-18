"use strict";

let cart = JSON.parse(sessionStorage.getItem("cart"));

if (cart) {
  let title = document.querySelector(".productName");
  let img = document.querySelector(".productImg");
  let amountPayed = document.querySelector(".amountPayed");
  title.textContent = cart[0].name;
  img.setAttribute("src", cart[0].img);
  console.log(cart[0].price);
  let price = cart[0].price.substr(0, cart[0].price.search(" "));
  console.log(price);
  amountPayed.textContent = "Amount Payed: " + price * 1.25 + " DKK";
  sessionStorage.removeItem("cart");
} else {
  location.href = "cart";
}
