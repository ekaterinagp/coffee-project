"use strict";

const createUserBtn = document.getElementsByName("reg_user")[0];

createUserBtn.addEventListener("click", () => {
  event.preventDefault();
  addNewUser();
});

function addNewUser() {
  let endpoint = "api/api-create-new-user.php";
  let userName = document.querySelector("[name=inputName]").value;
  let userLastName = document.querySelector("[name=inputLastName]").value;
  let userEmail = document.querySelector("[name=inputEmail]").value;
  let userAddress = document.querySelector("[name=inputAddress]").value;
  let userPassword = document.querySelector("[name=password_1]").value;
  let userPassword2 = document.querySelector("[name=password_2]").value;
  let userLoginName = document.querySelector("[name=inputLoginName]").value;
  let userPhone = document.querySelector("[name=inputPhone]").value;
  let cityID = document.querySelector("[name=cityInput]").value;

  let formData = new FormData();
  formData.append("inputName", userName);
  formData.append("inputLastName", userLastName);
  formData.append("inputEmail", userEmail);
  formData.append("inputPhone", userPhone);
  formData.append("inputLoginName", userLoginName);
  formData.append("password_1", userPassword);
  formData.append("password_2", userPassword2);
  formData.append("inputAddress", userAddress);
  formData.append("cityInput", cityID);

  console.log(userName, userLastName, cityID);
  fetch(endpoint, {
    method: "POST",
    body: formData
  })
    .then(res => res.text())
    .then(response => {
      console.log(response);
      if (response) {
        if(document.referrer.indexOf("cart")!=-1){
          location.href = "cart";
        }else{
          location.href = "profile";
        }

      }
    });
}
