"use strict"

let cart = JSON.parse(sessionStorage.getItem("cart"));
console.log("cart", cart);
let cartSection = document.querySelector("#paymentItems");

if(cart){
    console.log(cart)

    const sumToPay = document.querySelector("#sumToPay");
    const taxPayment = document.querySelector("#taxPayment");
    const subsumPayment = document.querySelector("#subsumPayment");

    let subsum = 0;
    let totalsum = 0;
    let tax = 0;

    sumToPay.textContent = 0; //(price * 1.25) + " DKK";
    taxPayment.textContent = 0; //(price * 0.25) + " DKK";
    subsumPayment.textContent = 0; //(price) + " DKK";

    if (cart) {
      cart.forEach(cartItem => {
        let template = document.querySelector("#paymentItemTemplate").content;
        let clone = template.cloneNode(true);
        clone.querySelector(".title_cart").textContent = cartItem.name;
        clone.querySelector(".img_cart").setAttribute("src", cartItem.img);
        clone.querySelector(".cartDiv").setAttribute("id", cartItem.id);
        clone.querySelector(".type_cart_grind").textContent = cartItem.typeGrind;
        clone.querySelector(".price_cart").textContent = cartItem.price;
        clone.querySelector(".cart_quantity").value = cartItem.amount;

        let price = cartItem.price.substr(0, cartItem.price.search(" "));

        subsum = parseInt(subsum) + parseInt(price);
        tax = parseInt(subsum*0.25);
        totalsum =parseInt(subsum*1.25);

        sumToPay.textContent = totalsum + " DKK";
        taxPayment.textContent = tax + " DKK";
        subsumPayment.textContent = subsum + " DKK";

        cartSection.appendChild(clone);

      });

    } else {
      emptyTotal();
    }

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
    console.log("doPurchase");

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
