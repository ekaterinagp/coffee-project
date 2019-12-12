"use strict";
window.addEventListener("load", init);
function init() {
  let allSubscriptions = document.querySelectorAll(".subscriptionItem");

  allSubscriptions.forEach(subscribeOption => {
    subscribeOption.addEventListener("click", () => {
      // console.log("click");
      removeSelected();
      // removeButton();
      subscribeOption.classList.add("selectedItem");
      // let buttonToPayment = document.createElement("button");
      // buttonToPayment.className = "paymentButton button";
      // buttonToPayment.textContent = "To Payment";
      // subscribeOption.append(buttonToPayment);

      // document.querySelector(".addSubToCartBtn").addEventListener("click", () => {
      //   let subId = document.querySelector(".addSubToCartBtn").parentNode.id;
      //   console.log("subId", subId);
      //   // let a = document.createElement("a");
      //   window.location = "payment?id=" + subId;
        // document.querySelector(".paymentButton").appendChild(a);
      // });
    });
  });
}

function removeSelected() {
  document.querySelectorAll(".selectedItem").forEach(name => {
    name.classList.remove("selectedItem");
  });
}

if (document.querySelector(".back-button")) {
  // console.log("yes");
  document.querySelector(".back-button").addEventListener("click", function() {
    window.history.back();
  });
}

function checkCart() {
  let numberOfItem = document.querySelector(".numberOfItems");
  let cart = JSON.parse(sessionStorage.getItem("cart"));

  if (cart && cart.length > 0) {
    numberOfItem.innerHTML = cart.length;
    numberOfItem.setAttribute("style", "display:inline;");
  } else {
    numberOfItem.setAttribute("style", "display: none;");
  }
}

checkCart();
