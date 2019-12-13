"use strict";
//  NOTIFICATION
function showNotification(text, responseClass){
  let notificationContainer = document.createElement("div");
  notificationContainer.className = "notification-container grid justify-items-center align-items-center " + responseClass;

  let textElement = document.createElement("p");
  textElement.textContent = text;

  notificationContainer.append(textElement);
  document.querySelector('body').append(notificationContainer);

  setTimeout(function(){
      document.querySelector('.notification-container').remove();
  }, 2100);
}


// NOTIFICATIONS

function showNotification(text, responseClass){
  let notificationContainer = document.createElement("div");
  notificationContainer.className = "notification-container grid justify-items-center align-items-center " + responseClass;

  let textElement = document.createElement("p");
  textElement.textContent = text;

  notificationContainer.append(textElement);
  document.querySelector('body').append(notificationContainer);

  setTimeout(function(){
      document.querySelector('.notification-container').remove();
  }, 2100);
}


// LOGOUT

if(document.querySelector(".button-log-out")){
  document.querySelector(".button-log-out").addEventListener("click", logout);
}


  

function logout(){
    console.log('click');
    let endpoint = "api/api-logout.php";
    // console.log("delte user");
        fetch(endpoint, {
            method: "POST"
        })
        .then(res => res.text())
        .then(response => {
            window.location.href = "index";
        });
}

// TEST


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
  // console.log("check cart")
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
