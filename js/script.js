"use strict";

let allSubscriptions = document.querySelectorAll(".subscriptionItem");

allSubscriptions.forEach(subscribeOption => {
  subscribeOption.addEventListener("click", () => {
    console.log("click");
    removeSelected();
    // removeButton();
    subscribeOption.classList.add("selectedItem");
    // let buttonToPayment = document.createElement("button");
    // buttonToPayment.className = "paymentButton button";
    // buttonToPayment.textContent = "To Payment";
    // subscribeOption.append(buttonToPayment);

    document.querySelector(".paymentButton").addEventListener("click", () => {
      let subId = document.querySelector(".paymentButton").parentNode.id;
      console.log("subId", subId);
      // let a = document.createElement("a");
      window.location = "payment.php/id=" + subId;
      // document.querySelector(".paymentButton").appendChild(a);
    });
  });
});

function removeSelected() {
  document.querySelectorAll(".selectedItem").forEach(name => {
    name.classList.remove("selectedItem");
  });
}

// function removeButton() {
//   document.querySelectorAll(".paymentButton").forEach(button => {
//     button.remove();
//   });
// }
