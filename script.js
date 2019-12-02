"use strict";

let allSubscriptions = document.querySelectorAll(".subscriptionItem");

allSubscriptions.forEach(subscribeButton => {
  subscribeButton.addEventListener("click", () => {
    console.log("click");
    removeSelected();
    subscribeButton.classList.add("selectedItem");
  });
});

function removeSelected() {
  document.querySelectorAll(".selectedItem").forEach(name => {
    name.classList.remove("selectedItem");
  });
}
