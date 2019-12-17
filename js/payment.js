"use strict"

let cart = JSON.parse(sessionStorage.getItem("cart"));
console.log("cart", cart);
let paymentSection = document.querySelector("#paymentItems")
if(cart){
  cart.forEach(cartItem => {
    

    console.log(cart)
    let template = document.querySelector("#paymentItemTemplate").content;
    let clone = template.cloneNode(true);
    clone.querySelector(".title_cart").textContent=cartItem.name;
    clone.querySelector(".price_cart").textContent =cartItem.price;
    clone.querySelector(".cart_quantity").value =cartItem.amount
    clone.querySelector(".type_cart_grind").textContent =cartItem.typeGrind;
    clone.querySelector("img").setAttribute("src",cartItem.img);
    paymentSection.appendChild(clone);
});
    let sumToPay = document.querySelector("#sumToPay");
    let taxPayment = document.querySelector("#taxPayment");
    let subsumPayment = document.querySelector("#subsumPayment");
    // title.textContent 
    // img.
    // pQuantity.textContent = ;
    // pPrice.textContent = cart[0].price;
    // pGrind.textContent = 
   
    console.log(cart[0].price);
    let price = cart[0].price.substr(0, cart[0].price.search(" "));
    console.log(price);
    sumToPay.textContent = (price * 1.25) + " DKK";
    taxPayment.textContent = (price * 0.25) + " DKK";
    subsumPayment.textContent = (price) + " DKK";

  let purchaseBtn = document.querySelector(".purchaseBtn");
  purchaseBtn.addEventListener("click", function(){
    event.preventDefault();
    let id = document.querySelector("[name=userCreditCards]").value;
    purchaseItem(id);
  })
  let showAddCardFrm = document.querySelector(".show-newCardFrm");
  showAddCardFrm.addEventListener("click", function(){
      document.querySelector("#newCardFrm").classList.add("showFrm");
  })
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
      .then(res => res.json())
      .then(response => {
      //   console.log(response);
        if (response) {
          
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
    let productID = cart[0].id;
    let creditCardID = cardID;
    let taxPercentage = 0.25;
    console.log(cardID)
    let formData = new FormData();
    let endpoint;
    formData.append("creditCardID",creditCardID)
    formData.append("taxPercentage",taxPercentage)
    formData.append("productID",productID)

    if(cart[0].purchaseType=="subscription"){
        endpoint = "api/api-purchase-subscription.php"
    }
    else{
        endpoint = "api/api-purchase-product.php";
    }
console.log(endpoint)
    fetch(endpoint, {
        method: "POST",
        body: formData
        })
        .then(res => res.json())
        .then(response => {
        //   console.log(response);
            if (response===1) {
        console.log("yes")
        location.href="thankyou";
            }else{
          console.log("something went wrong")
        }
    })
  }
