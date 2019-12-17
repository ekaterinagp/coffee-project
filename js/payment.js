"use strict"

let cart = JSON.parse(sessionStorage.getItem("cart"));
console.log("cart", cart);
//something silly
if(cart){
    console.log(cart)
    let title = document.querySelector("#youSelected");
    let pPrice = document.querySelector(".price")
    let pQuantity = document.querySelector(".quantity")
    let pGrind = document.querySelector(".grind");
    let img = document.querySelector("img");
    let sumToPay = document.querySelector("#sumToPay");
    title.textContent = cart[0].name;
    img.setAttribute("src", cart[0].img)
    pQuantity.textContent = cart[0].amount;
    pPrice.textContent = cart[0].price;
    pGrind.textContent = cart[0].typeGrind;

    console.log(cart[0].price )
    let price = cart[0].price.substr(0, cart[0].price.search(" "))
    console.log(price)
    sumToPay.textContent= (price * 1.25 ) + " DKK";

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
