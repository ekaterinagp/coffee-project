"use strict"

let cart = JSON.parse(sessionStorage.getItem("cart"));
console.log("cart", cart);
if(cart){
    console.log(cart)
    let title = document.querySelector("#youSelected");
    let img = document.querySelector("img");
    let sumToPay = document.querySelector("#sumToPay");
    title.textContent = cart[0].name
    img.setAttribute("src", cart[0].img)
    console.log(cart[0].price )
    let price = cart[0].price.substr(0, cart[0].price.search(" "))
    console.log(price)
    sumToPay.textContent= (price * 1.25 ) + " DKK";
}





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
let productID = cart[0].id;
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