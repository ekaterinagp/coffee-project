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

let openPaymentFrmBtn = document.querySelector("#openPurchaseFrm");
openPaymentFrmBtn.addEventListener("click", openPaymentFrm);

function openPaymentFrm(){
  document.querySelector(".hiddenPaymentForm").classList.add("showFrm");
  let purchaseBtn = document.querySelector(".purchaseBtn");
  purchaseBtn.addEventListener("click", function(){
    event.preventDefault();
    let id = document.querySelector("[name=userCreditCards]").value;
    purchaseItem(id);
  })
  // let showAddCardFrm = document.querySelector(".showAddCardFrm");
  // // showAddCardFrm.addEventListener("click", )
  let registerCardBtn = document.querySelector(".addCreditCard")
  registerCardBtn.addEventListener("click", registerCard);

}
function registerCard(){
event.preventDefault();
  let IBAN = document.querySelector("[name=inputIBAN]").value;
  let CCV = document.querySelector("[name=inputCCV]").value;
  let expiration = document.querySelector("[name=inputExpiration]").value;

console.log(IBAN, CCV, expiration)
  let formData = new FormData();
  formData.append('inputIBAN', IBAN);
  formData.append('inputCCV', CCV);
  formData.append('inputExpiration', expiration);

  let endpoint = "api/api-create-creditcard.php";

  fetch(endpoint, {
      method: "POST",
      body: formData
    })
      .then(res => res.text())
      .then(response => {
      //   console.log(response);
        if (response!=0) {
          
          purchaseItem(response)
          console.log(response);
        }else{
          console.log("wrong")
        }
});
}

  function purchaseItem(cardID){
    console.log("doPurvhase")
// let itemToBePurchased = document.querySelector(".cartDiv").id
let productID = Number(document.querySelector(".cartDiv").id);
let creditCardID = cardID;
let taxPercentage = 0.25;
let formData = new FormData();
formData.append("productID",productID)
formData.append("creditCardID",creditCardID)
formData.append("taxPercentage",taxPercentage)
let endpoint = "api/api-purchase-product.php";

  fetch(endpoint, {
      method: "POST",
      body: formData
    })
      .then(res => res.text())
      .then(response => {
      //   console.log(response);
        if (response==1) {
      console.log("yes")
      sessionStorage.removeItem("cart");
      location.href="thankyou.php";
        }else{
          console.log("something went wront")
        }
});

}