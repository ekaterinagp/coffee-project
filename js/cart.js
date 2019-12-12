"use strict";

let cart = JSON.parse(sessionStorage.getItem("cart"));
console.log("cart", cart);
let cartSection = document.querySelector("#cartItems");
selectQ();

if (cart) {
  cart.forEach(cartItem => {
    let template = document.querySelector("#cartItemTemplate").content;
    let clone = template.cloneNode(true);
    clone.querySelector(".title_cart").value = cartItem.name;
    clone.querySelector(".img_cart").setAttribute("src", cartItem.img);
    clone.querySelector(".cartDiv").setAttribute("id", cartItem.id);
    clone.querySelector(".type_cart_grind").value = cartItem.typeGrind;
    clone.querySelector(".price_cart").value = cartItem.price;

    let removeBtn = clone.querySelector(".remove");

    removeBtn.addEventListener("click", function() {
      console.log("removeItemId: ", cartItem.id);
      removeItem(cartItem.id);
    });

    cartSection.appendChild(clone);
  });
} else {
    emptyTotal();
}
if(cart.length ==0){
  displayGoBuyMessage();
}
function displayGoBuyMessage(){
  console.log("go buy");
  document.querySelector(".cartTotal").style.display = "none";
  document.querySelector(".noCart").style.display = "block";
}

function removeItem(cartItemId) {
  let cart = JSON.parse(sessionStorage.getItem("cart"));
  cart.forEach(function(cartItem, index, object) {
    if (cartItem.id === cartItemId) {
      object.splice(index, 1);
    }
  });
  sessionStorage.setItem("cart", JSON.stringify(cart));
  let cartItemElement = document.getElementById(cartItemId);
  cartItemElement.remove();

  selectQ();
}

function selectQ() {
  let totalPrice = 0;
  let sectionTotal = document.getElementById("totalItemsSection");
  let cart = JSON.parse(sessionStorage.getItem("cart"));
  cart.forEach(cartItem => {
    //parseInt takes a string and returns a number
    totalPrice = totalPrice + parseInt(cartItem.price);

    // let oneItemSum = cartItem.price;
    // let oneItemTitle = cartItem.name;
    let template = document.querySelector("#totalItemsTemplate").content;
    let clone = template.cloneNode(true);

    sectionTotal.appendChild(clone);
  });
  document.getElementById("totalsum").innerHTML =
    "Total: " + totalPrice + "DKK";
}

function emptyTotal() {
  // document.querySelector(".item_total").innerHTML = 0;
  document.getElementById("totalsum").innerHTML = 0;
}
// let numberOfItem = document.querySelector(".numberOfItems");
// function checkCart() {
//   let cart = JSON.parse(sessionStorage.getItem("cart"));

//   if (cart && cart.length > 0) {
//     numberOfItem.innerHTML = cart.length;
//     numberOfItem.setAttribute("style", "display:block;");
//   } else {
//     numberOfItem.setAttribute("style", "display: none;");
//   }
// }

// checkCart();

