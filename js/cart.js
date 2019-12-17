"use strict";
let subTotalPrice = 0;
let totalPrice = 0;
let taxAmount = 0;
let cart = JSON.parse(sessionStorage.getItem("cart"));
if (!cart) {
  cart = [];
}
console.log("cart", cart);
let cartSection = document.querySelector("#cartItems");
// selectQ();

if (cart) {
    cart.forEach(cartItem => {
    let template = document.querySelector("#cartItemTemplate").content;
    let clone = template.cloneNode(true);
    clone.querySelector(".title_cart").textContent = cartItem.name;
    clone.querySelector(".img_cart").setAttribute("src", cartItem.img);
    clone.querySelector(".cartDiv").setAttribute("id", cartItem.id);
    clone.querySelector(".type_cart_grind").textContent = cartItem.typeGrind;
    clone.querySelector(".price_cart").textContent = cartItem.price;
    clone.querySelector(".cart_quantity").value = cartItem.amount;
    clone.querySelector(".cart_quantity").addEventListener('input', function(){ 
      if(event.target.value < cartItem.amount){
        cartItem.amount = event.target.value;
        // console.log(cartItem.amount)
        subTotalPrice = subTotalPrice - parseInt(cartItem.price) ;
        // console.log(subTotalPrice)
        taxAmount = subTotalPrice * 0.25;
        totalPrice = subTotalPrice - taxAmount;
      }else{
        cartItem.amount = event.target.value;
        console.log(cartItem.amount);
        subTotalPrice = subTotalPrice + parseInt(cartItem.price);
        console.log(subTotalPrice)
        taxAmount = subTotalPrice * 0.25;
        totalPrice = subTotalPrice + taxAmount;
      }
// console.log(totalPrice)
      // console.log(cartItem.amount);

      // let originalPrice = cartItem.price;

      // originalPrice = originalPrice.substr(0,originalPrice.search(" "));

      // let newPrice = parseInt(originalPrice) * parseInt(cartItem.amount);
      // let taxAmount = newPrice * 0.25;

      document.getElementById("tax").textContent = taxAmount + " DKK";
      document.getElementById("subsum").innerHTML = subTotalPrice + " DKK";
      document.getElementById("totalsum").innerHTML = totalPrice + " DKK";
    
    })
    let removeBtn = clone.querySelector(".remove");
    removeBtn.addEventListener("click", function() {
      console.log("removeItemId: ", cartItem.id);
      removeItem(cartItem.id);
    });
    
    cartSection.appendChild(clone);
  });
  sessionStorage.setItem("cart", JSON.stringify(cart));
} else {
  emptyTotal();
}

if (cart.length == 0) {
  displayGoBuyMessage();
}

selectQ();

function displayGoBuyMessage() {
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
  checkCart();
  if (cart.length == 0) {
    displayGoBuyMessage();
  }
  // console.log()
  selectQ();
}


function selectQ() {
  let sectionTotal = document.getElementById("totalItemsSection");
  let cart = JSON.parse(sessionStorage.getItem("cart"));
  if (cart) {
    cart.forEach(cartItem => {
      subTotalPrice = subTotalPrice + parseInt(cartItem.price) * parseInt(cartItem.amount);
      // console.log(subTotalPrice)
      taxAmount = subTotalPrice * 0.25;
      totalPrice = subTotalPrice + taxAmount;
      let template = document.querySelector("#totalItemsTemplate").content;
      let clone = template.cloneNode(true);

      sectionTotal.appendChild(clone);
    });
  }
  document.getElementById("tax").textContent = taxAmount + " DKK";
  document.getElementById("subsum").innerHTML = subTotalPrice + " DKK";
  document.getElementById("totalsum").innerHTML = totalPrice + " DKK";
}

function emptyTotal() {
  document.getElementById("tax").textContent = 0;
  document.getElementById("subsum").innerHTML = 0;
  document.getElementById("totalsum").innerHTML = 0;
}
